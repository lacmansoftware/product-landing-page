<?php
namespace Composer\DependencyResolver\Operation;
if (!defined('ABSPATH')) exit;
use Composer\Package\PackageInterface;
use Composer\Package\Version\VersionParser;
class UpdateOperation extends SolverOperation implements OperationInterface
{
 const TYPE = 'update';
 protected $initialPackage;
 protected $targetPackage;
 public function __construct(PackageInterface $initial, PackageInterface $target)
 {
 $this->initialPackage = $initial;
 $this->targetPackage = $target;
 }
 public function getInitialPackage()
 {
 return $this->initialPackage;
 }
 public function getTargetPackage()
 {
 return $this->targetPackage;
 }
 public function show($lock)
 {
 return self::format($this->initialPackage, $this->targetPackage, $lock);
 }
 public static function format(PackageInterface $initialPackage, PackageInterface $targetPackage, $lock = false)
 {
 $fromVersion = $initialPackage->getFullPrettyVersion();
 $toVersion = $targetPackage->getFullPrettyVersion();
 if ($fromVersion === $toVersion && $initialPackage->getSourceReference() !== $targetPackage->getSourceReference()) {
 $fromVersion = $initialPackage->getFullPrettyVersion(true, PackageInterface::DISPLAY_SOURCE_REF);
 $toVersion = $targetPackage->getFullPrettyVersion(true, PackageInterface::DISPLAY_SOURCE_REF);
 } elseif ($fromVersion === $toVersion && $initialPackage->getDistReference() !== $targetPackage->getDistReference()) {
 $fromVersion = $initialPackage->getFullPrettyVersion(true, PackageInterface::DISPLAY_DIST_REF);
 $toVersion = $targetPackage->getFullPrettyVersion(true, PackageInterface::DISPLAY_DIST_REF);
 }
 $actionName = VersionParser::isUpgrade($initialPackage->getVersion(), $targetPackage->getVersion()) ? 'Upgrading' : 'Downgrading';
 return $actionName.' <info>'.$initialPackage->getPrettyName().'</info> (<comment>'.$fromVersion.'</comment> => <comment>'.$toVersion.'</comment>)';
 }
}
