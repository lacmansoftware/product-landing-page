<?php
namespace Composer\Util;
if (!defined('ABSPATH')) exit;
use Composer\CaBundle\CaBundle;
use Composer\Pcre\Preg;
final class TlsHelper
{
 public static function checkCertificateHost($certificate, $hostname, &$cn = null)
 {
 $names = self::getCertificateNames($certificate);
 if (empty($names)) {
 return false;
 }
 $combinedNames = array_merge($names['san'], array($names['cn']));
 $hostname = strtolower($hostname);
 foreach ($combinedNames as $certName) {
 $matcher = self::certNameMatcher($certName);
 if ($matcher && $matcher($hostname)) {
 $cn = $names['cn'];
 return true;
 }
 }
 return false;
 }
 public static function getCertificateNames($certificate)
 {
 if (is_array($certificate)) {
 $info = $certificate;
 } elseif (CaBundle::isOpensslParseSafe()) {
 $info = openssl_x509_parse($certificate, false);
 }
 if (!isset($info['subject']['commonName'])) {
 return null;
 }
 $commonName = strtolower($info['subject']['commonName']);
 $subjectAltNames = array();
 if (isset($info['extensions']['subjectAltName'])) {
 $subjectAltNames = Preg::split('{\s*,\s*}', $info['extensions']['subjectAltName']);
 $subjectAltNames = array_filter(array_map(function ($name) {
 if (0 === strpos($name, 'DNS:')) {
 return strtolower(ltrim(substr($name, 4)));
 }
 return null;
 }, $subjectAltNames));
 $subjectAltNames = array_values($subjectAltNames);
 }
 return array(
 'cn' => $commonName,
 'san' => $subjectAltNames,
 );
 }
 public static function getCertificateFingerprint($certificate)
 {
 $pubkeydetails = openssl_pkey_get_details(openssl_get_publickey($certificate));
 $pubkeypem = $pubkeydetails['key'];
 //Convert PEM to DER before SHA1'ing
 $start = '-----BEGIN PUBLIC KEY-----';
 $end = '-----END PUBLIC KEY-----';
 $pemtrim = substr($pubkeypem, strpos($pubkeypem, $start) + strlen($start), (strlen($pubkeypem) - strpos($pubkeypem, $end)) * (-1));
 $der = base64_decode($pemtrim);
 return sha1($der);
 }
 public static function isOpensslParseSafe()
 {
 return CaBundle::isOpensslParseSafe();
 }
 private static function certNameMatcher($certName)
 {
 $wildcards = substr_count($certName, '*');
 if (0 === $wildcards) {
 // Literal match.
 return function ($hostname) use ($certName) {
 return $hostname === $certName;
 };
 }
 if (1 === $wildcards) {
 $components = explode('.', $certName);
 if (3 > count($components)) {
 // Must have 3+ components
 return null;
 }
 $firstComponent = $components[0];
 // Wildcard must be the last character.
 if ('*' !== $firstComponent[strlen($firstComponent) - 1]) {
 return null;
 }
 $wildcardRegex = preg_quote($certName);
 $wildcardRegex = str_replace('\\*', '[a-z0-9-]+', $wildcardRegex);
 $wildcardRegex = "{^{$wildcardRegex}$}";
 return function ($hostname) use ($wildcardRegex) {
 return Preg::isMatch($wildcardRegex, $hostname);
 };
 }
 return null;
 }
}
