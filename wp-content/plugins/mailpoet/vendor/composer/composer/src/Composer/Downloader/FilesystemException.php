<?php
namespace Composer\Downloader;
if (!defined('ABSPATH')) exit;
class FilesystemException extends \Exception
{
 public function __construct($message = '', $code = 0, \Exception $previous = null)
 {
 parent::__construct("Filesystem exception: \n".$message, $code, $previous);
 }
}
