<?php
namespace Composer\DependencyResolver;
if (!defined('ABSPATH')) exit;
class MultiConflictRule extends Rule
{
 protected $literals;
 public function __construct(array $literals, $reason, $reasonData)
 {
 parent::__construct($reason, $reasonData);
 if (\count($literals) < 3) {
 throw new \RuntimeException("multi conflict rule requires at least 3 literals");
 }
 // sort all packages ascending by id
 sort($literals);
 $this->literals = $literals;
 }
 public function getLiterals()
 {
 return $this->literals;
 }
 public function getHash()
 {
 $data = unpack('ihash', md5('c:'.implode(',', $this->literals), true));
 return $data['hash'];
 }
 public function equals(Rule $rule)
 {
 if ($rule instanceof MultiConflictRule) {
 return $this->literals === $rule->getLiterals();
 }
 return false;
 }
 public function isAssertion()
 {
 return false;
 }
 public function disable()
 {
 throw new \RuntimeException("Disabling multi conflict rules is not possible. Please contact composer at https://github.com/composer/composer to let us debug what lead to this situation.");
 }
 public function __toString()
 {
 // TODO multi conflict?
 $result = $this->isDisabled() ? 'disabled(multi(' : '(multi(';
 foreach ($this->literals as $i => $literal) {
 if ($i != 0) {
 $result .= '|';
 }
 $result .= $literal;
 }
 $result .= '))';
 return $result;
 }
}
