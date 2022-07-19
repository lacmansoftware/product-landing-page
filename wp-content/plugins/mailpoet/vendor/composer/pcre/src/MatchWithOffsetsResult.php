<?php
namespace Composer\Pcre;
if (!defined('ABSPATH')) exit;
final class MatchWithOffsetsResult
{
 public $matches;
 public $matched;
 public function __construct($count, array $matches)
 {
 $this->matches = $matches;
 $this->matched = (bool) $count;
 }
}
