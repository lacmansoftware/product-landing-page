<?php
namespace Composer\Repository;
if (!defined('ABSPATH')) exit;
use Composer\Factory;
use Composer\IO\IOInterface;
use Composer\Config;
use Composer\EventDispatcher\EventDispatcher;
use Composer\Pcre\Preg;
use Composer\Util\HttpDownloader;
use Composer\Util\ProcessExecutor;
use Composer\Json\JsonFile;
class RepositoryFactory
{
 public static function configFromString(IOInterface $io, Config $config, $repository, $allowFilesystem = false)
 {
 if (0 === strpos($repository, 'http')) {
 $repoConfig = array('type' => 'composer', 'url' => $repository);
 } elseif ("json" === pathinfo($repository, PATHINFO_EXTENSION)) {
 $json = new JsonFile($repository, Factory::createHttpDownloader($io, $config));
 $data = $json->read();
 if (!empty($data['packages']) || !empty($data['includes']) || !empty($data['provider-includes'])) {
 $repoConfig = array('type' => 'composer', 'url' => 'file://' . strtr(realpath($repository), '\\', '/'));
 } elseif ($allowFilesystem) {
 $repoConfig = array('type' => 'filesystem', 'json' => $json);
 } else {
 throw new \InvalidArgumentException("Invalid repository URL ($repository) given. This file does not contain a valid composer repository.");
 }
 } elseif (strpos($repository, '{') === 0) {
 // assume it is a json object that makes a repo config
 $repoConfig = JsonFile::parseJson($repository);
 } else {
 throw new \InvalidArgumentException("Invalid repository url ($repository) given. Has to be a .json file, an http url or a JSON object.");
 }
 return $repoConfig;
 }
 public static function fromString(IOInterface $io, Config $config, $repository, $allowFilesystem = false, RepositoryManager $rm = null)
 {
 $repoConfig = static::configFromString($io, $config, $repository, $allowFilesystem);
 return static::createRepo($io, $config, $repoConfig, $rm);
 }
 public static function createRepo(IOInterface $io, Config $config, array $repoConfig, RepositoryManager $rm = null)
 {
 if (!$rm) {
 $rm = static::manager($io, $config, Factory::createHttpDownloader($io, $config));
 }
 $repos = self::createRepos($rm, array($repoConfig));
 return reset($repos);
 }
 public static function defaultRepos(IOInterface $io = null, Config $config = null, RepositoryManager $rm = null)
 {
 if (!$config) {
 $config = Factory::createConfig($io);
 }
 if ($io) {
 $io->loadConfiguration($config);
 }
 if (!$rm) {
 if (!$io) {
 throw new \InvalidArgumentException('This function requires either an IOInterface or a RepositoryManager');
 }
 $rm = static::manager($io, $config, Factory::createHttpDownloader($io, $config));
 }
 return self::createRepos($rm, $config->getRepositories());
 }
 public static function manager(IOInterface $io, Config $config, HttpDownloader $httpDownloader, EventDispatcher $eventDispatcher = null, ProcessExecutor $process = null)
 {
 $rm = new RepositoryManager($io, $config, $httpDownloader, $eventDispatcher, $process);
 $rm->setRepositoryClass('composer', 'Composer\Repository\ComposerRepository');
 $rm->setRepositoryClass('vcs', 'Composer\Repository\VcsRepository');
 $rm->setRepositoryClass('package', 'Composer\Repository\PackageRepository');
 $rm->setRepositoryClass('pear', 'Composer\Repository\PearRepository');
 $rm->setRepositoryClass('git', 'Composer\Repository\VcsRepository');
 $rm->setRepositoryClass('bitbucket', 'Composer\Repository\VcsRepository');
 $rm->setRepositoryClass('git-bitbucket', 'Composer\Repository\VcsRepository');
 $rm->setRepositoryClass('github', 'Composer\Repository\VcsRepository');
 $rm->setRepositoryClass('gitlab', 'Composer\Repository\VcsRepository');
 $rm->setRepositoryClass('svn', 'Composer\Repository\VcsRepository');
 $rm->setRepositoryClass('fossil', 'Composer\Repository\VcsRepository');
 $rm->setRepositoryClass('perforce', 'Composer\Repository\VcsRepository');
 $rm->setRepositoryClass('hg', 'Composer\Repository\VcsRepository');
 $rm->setRepositoryClass('artifact', 'Composer\Repository\ArtifactRepository');
 $rm->setRepositoryClass('path', 'Composer\Repository\PathRepository');
 return $rm;
 }
 private static function createRepos(RepositoryManager $rm, array $repoConfigs)
 {
 $repos = array();
 foreach ($repoConfigs as $index => $repo) {
 if (is_string($repo)) {
 throw new \UnexpectedValueException('"repositories" should be an array of repository definitions, only a single repository was given');
 }
 if (!is_array($repo)) {
 throw new \UnexpectedValueException('Repository "'.$index.'" ('.json_encode($repo).') should be an array, '.gettype($repo).' given');
 }
 if (!isset($repo['type'])) {
 throw new \UnexpectedValueException('Repository "'.$index.'" ('.json_encode($repo).') must have a type defined');
 }
 $name = self::generateRepositoryName($index, $repo, $repos);
 if ($repo['type'] === 'filesystem') {
 $repos[$name] = new FilesystemRepository($repo['json']);
 } else {
 $repos[$name] = $rm->createRepository($repo['type'], $repo, $index);
 }
 }
 return $repos;
 }
 public static function generateRepositoryName($index, array $repo, array $existingRepos)
 {
 $name = is_int($index) && isset($repo['url']) ? Preg::replace('{^https?://}i', '', $repo['url']) : $index;
 while (isset($existingRepos[$name])) {
 $name .= '2';
 }
 return $name;
 }
}
