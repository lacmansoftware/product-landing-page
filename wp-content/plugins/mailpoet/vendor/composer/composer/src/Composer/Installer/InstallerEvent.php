<?php
namespace Composer\Installer;
if (!defined('ABSPATH')) exit;
use Composer\Composer;
use Composer\DependencyResolver\Transaction;
use Composer\EventDispatcher\Event;
use Composer\IO\IOInterface;
class InstallerEvent extends Event
{
 private $composer;
 private $io;
 private $devMode;
 private $executeOperations;
 private $transaction;
 public function __construct($eventName, Composer $composer, IOInterface $io, $devMode, $executeOperations, Transaction $transaction)
 {
 parent::__construct($eventName);
 $this->composer = $composer;
 $this->io = $io;
 $this->devMode = $devMode;
 $this->executeOperations = $executeOperations;
 $this->transaction = $transaction;
 }
 public function getComposer()
 {
 return $this->composer;
 }
 public function getIO()
 {
 return $this->io;
 }
 public function isDevMode()
 {
 return $this->devMode;
 }
 public function isExecutingOperations()
 {
 return $this->executeOperations;
 }
 public function getTransaction()
 {
 return $this->transaction;
 }
}
