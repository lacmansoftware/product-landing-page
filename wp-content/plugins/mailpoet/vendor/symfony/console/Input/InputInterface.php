<?php
namespace Symfony\Component\Console\Input;
if (!defined('ABSPATH')) exit;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Exception\RuntimeException;
interface InputInterface
{
 public function getFirstArgument();
 public function hasParameterOption($values, $onlyParams = false);
 public function getParameterOption($values, $default = false, $onlyParams = false);
 public function bind(InputDefinition $definition);
 public function validate();
 public function getArguments();
 public function getArgument($name);
 public function setArgument($name, $value);
 public function hasArgument($name);
 public function getOptions();
 public function getOption($name);
 public function setOption($name, $value);
 public function hasOption($name);
 public function isInteractive();
 public function setInteractive($interactive);
}
