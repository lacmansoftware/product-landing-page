<?php
namespace Composer\Package\Archiver;
if (!defined('ABSPATH')) exit;
use ZipArchive;
use Composer\Util\Filesystem;
class ZipArchiver implements ArchiverInterface
{
 protected static $formats = array(
 'zip' => true,
 );
 public function archive($sources, $target, $format, array $excludes = array(), $ignoreFilters = false)
 {
 $fs = new Filesystem();
 $sources = $fs->normalizePath($sources);
 $zip = new ZipArchive();
 $res = $zip->open($target, ZipArchive::CREATE);
 if ($res === true) {
 $files = new ArchivableFilesFinder($sources, $excludes, $ignoreFilters);
 foreach ($files as $file) {
 $filepath = strtr($file->getPath()."/".$file->getFilename(), '\\', '/');
 $localname = $filepath;
 if (strpos($localname, $sources . '/') === 0) {
 $localname = substr($localname, strlen($sources . '/'));
 }
 if ($file->isDir()) {
 $zip->addEmptyDir($localname);
 } else {
 $zip->addFile($filepath, $localname);
 }
 if (PHP_VERSION_ID >= 50600 && method_exists($zip, 'setExternalAttributesName')) {
 $perms = fileperms($filepath);
 $zip->setExternalAttributesName($localname, ZipArchive::OPSYS_UNIX, $perms << 16);
 }
 }
 if ($zip->close()) {
 return $target;
 }
 }
 $message = sprintf(
 "Could not create archive '%s' from '%s': %s",
 $target,
 $sources,
 $zip->getStatusString()
 );
 throw new \RuntimeException($message);
 }
 public function supports($format, $sourceType)
 {
 return isset(static::$formats[$format]) && $this->compressionAvailable();
 }
 private function compressionAvailable()
 {
 return class_exists('ZipArchive');
 }
}
