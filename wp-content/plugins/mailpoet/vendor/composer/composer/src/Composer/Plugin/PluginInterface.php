<?php
namespace Composer\Plugin;
if (!defined('ABSPATH')) exit;
use Composer\Composer;
use Composer\IO\IOInterface;
interface PluginInterface
{
 const PLUGIN_API_VERSION = '2.2.0';
 public function activate(Composer $composer, IOInterface $io);
 public function deactivate(Composer $composer, IOInterface $io);
 public function uninstall(Composer $composer, IOInterface $io);
}
