<?php
namespace Composer\Package\Archiver;
if (!defined('ABSPATH')) exit;
use Composer\Pcre\Preg;
use Composer\Util\Filesystem;
use FilesystemIterator;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
class ArchivableFilesFinder extends \FilterIterator
{
 protected $finder;
 public function __construct($sources, array $excludes, $ignoreFilters = false)
 {
 $fs = new Filesystem();
 $sources = $fs->normalizePath(realpath($sources));
 if ($ignoreFilters) {
 $filters = array();
 } else {
 $filters = array(
 new GitExcludeFilter($sources),
 new ComposerExcludeFilter($sources, $excludes),
 );
 }
 $this->finder = new Finder();
 $filter = function (\SplFileInfo $file) use ($sources, $filters, $fs) {
 if ($file->isLink() && strpos($file->getRealPath(), $sources) !== 0) {
 return false;
 }
 $relativePath = Preg::replace(
 '#^'.preg_quote($sources, '#').'#',
 '',
 $fs->normalizePath($file->getRealPath())
 );
 $exclude = false;
 foreach ($filters as $filter) {
 $exclude = $filter->filter($relativePath, $exclude);
 }
 return !$exclude;
 };
 if (method_exists($filter, 'bindTo')) {
 $filter = $filter->bindTo(null);
 }
 $this->finder
 ->in($sources)
 ->filter($filter)
 ->ignoreVCS(true)
 ->ignoreDotFiles(false)
 ->sortByName();
 parent::__construct($this->finder->getIterator());
 }
 #[\ReturnTypeWillChange]
 public function accept()
 {
 $current = $this->getInnerIterator()->current();
 if (!$current->isDir()) {
 return true;
 }
 $iterator = new FilesystemIterator($current, FilesystemIterator::SKIP_DOTS);
 return !$iterator->valid();
 }
}
