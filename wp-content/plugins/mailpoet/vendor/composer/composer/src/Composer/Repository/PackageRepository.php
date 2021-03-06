<?php
namespace Composer\Repository;
if (!defined('ABSPATH')) exit;
use Composer\Package\Loader\ArrayLoader;
use Composer\Package\Loader\ValidatingArrayLoader;
use Composer\Pcre\Preg;
class PackageRepository extends ArrayRepository
{
 private $config;
 public function __construct(array $config)
 {
 parent::__construct();
 $this->config = $config['package'];
 // make sure we have an array of package definitions
 if (!is_numeric(key($this->config))) {
 $this->config = array($this->config);
 }
 }
 protected function initialize()
 {
 parent::initialize();
 $loader = new ValidatingArrayLoader(new ArrayLoader(null, true), true);
 foreach ($this->config as $package) {
 try {
 $package = $loader->load($package);
 } catch (\Exception $e) {
 throw new InvalidRepositoryException('A repository of type "package" contains an invalid package definition: '.$e->getMessage()."\n\nInvalid package definition:\n".json_encode($package));
 }
 $this->addPackage($package);
 }
 }
 public function getRepoName()
 {
 return Preg::replace('{^array }', 'package ', parent::getRepoName());
 }
}
