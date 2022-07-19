<?php
namespace Composer\Repository\Vcs;
if (!defined('ABSPATH')) exit;
use Composer\Config;
use Composer\Cache;
use Composer\IO\IOInterface;
use Composer\Pcre\Preg;
use Composer\Util\ProcessExecutor;
use Composer\Util\Perforce;
class PerforceDriver extends VcsDriver
{
 protected $depot;
 protected $branch;
 protected $perforce = null;
 public function initialize()
 {
 $this->depot = $this->repoConfig['depot'];
 $this->branch = '';
 if (!empty($this->repoConfig['branch'])) {
 $this->branch = $this->repoConfig['branch'];
 }
 $this->initPerforce($this->repoConfig);
 $this->perforce->p4Login();
 $this->perforce->checkStream();
 $this->perforce->writeP4ClientSpec();
 $this->perforce->connectClient();
 }
 private function initPerforce($repoConfig)
 {
 if (!empty($this->perforce)) {
 return;
 }
 if (!Cache::isUsable((string) $this->config->get('cache-vcs-dir'))) {
 throw new \RuntimeException('PerforceDriver requires a usable cache directory, and it looks like you set it to be disabled');
 }
 $repoDir = $this->config->get('cache-vcs-dir') . '/' . $this->depot;
 $this->perforce = Perforce::create($repoConfig, $this->getUrl(), $repoDir, $this->process, $this->io);
 }
 public function getFileContent($file, $identifier)
 {
 return $this->perforce->getFileContent($file, $identifier);
 }
 public function getChangeDate($identifier)
 {
 return null;
 }
 public function getRootIdentifier()
 {
 return $this->branch;
 }
 public function getBranches()
 {
 return $this->perforce->getBranches();
 }
 public function getTags()
 {
 return $this->perforce->getTags();
 }
 public function getDist($identifier)
 {
 return null;
 }
 public function getSource($identifier)
 {
 return array(
 'type' => 'perforce',
 'url' => $this->repoConfig['url'],
 'reference' => $identifier,
 'p4user' => $this->perforce->getUser(),
 );
 }
 public function getUrl()
 {
 return $this->url;
 }
 public function hasComposerFile($identifier)
 {
 $composerInfo = $this->perforce->getComposerInformation('//' . $this->depot . '/' . $identifier);
 return !empty($composerInfo);
 }
 public function getContents($url)
 {
 throw new \BadMethodCallException('Not implemented/used in PerforceDriver');
 }
 public static function supports(IOInterface $io, Config $config, $url, $deep = false)
 {
 if ($deep || Preg::isMatch('#\b(perforce|p4)\b#i', $url)) {
 return Perforce::checkServerExists($url, new ProcessExecutor($io));
 }
 return false;
 }
 public function cleanup()
 {
 $this->perforce->cleanupClientSpec();
 $this->perforce = null;
 }
 public function getDepot()
 {
 return $this->depot;
 }
 public function getBranch()
 {
 return $this->branch;
 }
}
