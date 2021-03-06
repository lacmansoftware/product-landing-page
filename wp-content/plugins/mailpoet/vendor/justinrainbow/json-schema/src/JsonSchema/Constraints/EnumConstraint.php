<?php
namespace JsonSchema\Constraints;
if (!defined('ABSPATH')) exit;
use JsonSchema\Entity\JsonPointer;
class EnumConstraint extends Constraint
{
 public function check(&$element, $schema = null, JsonPointer $path = null, $i = null)
 {
 // Only validate enum if the attribute exists
 if ($element instanceof UndefinedConstraint && (!isset($schema->required) || !$schema->required)) {
 return;
 }
 $type = gettype($element);
 foreach ($schema->enum as $enum) {
 $enumType = gettype($enum);
 if ($this->factory->getConfig(self::CHECK_MODE_TYPE_CAST) && $type == 'array' && $enumType == 'object') {
 if ((object) $element == $enum) {
 return;
 }
 }
 if ($type === gettype($enum)) {
 if ($type == 'object') {
 if ($element == $enum) {
 return;
 }
 } elseif ($element === $enum) {
 return;
 }
 }
 }
 $this->addError($path, 'Does not have a value in the enumeration ' . json_encode($schema->enum), 'enum', array('enum' => $schema->enum));
 }
}
