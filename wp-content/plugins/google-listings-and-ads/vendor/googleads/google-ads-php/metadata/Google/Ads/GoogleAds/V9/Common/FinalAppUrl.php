<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/ads/googleads/v9/common/final_app_url.proto

namespace GPBMetadata\Google\Ads\GoogleAds\V9\Common;

class FinalAppUrl
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();
        if (static::$is_initialized == true) {
          return;
        }
        \GPBMetadata\Google\Api\Http::initOnce();
        \GPBMetadata\Google\Api\Annotations::initOnce();
        $pool->internalAddGeneratedFile(
            '
�
Agoogle/ads/googleads/v9/enums/app_url_operating_system_type.protogoogle.ads.googleads.v9.enums"p
AppUrlOperatingSystemTypeEnum"O
AppUrlOperatingSystemType
UNSPECIFIED 
UNKNOWN
IOS
ANDROIDB�
!com.google.ads.googleads.v9.enumsBAppUrlOperatingSystemTypeProtoPZBgoogle.golang.org/genproto/googleapis/ads/googleads/v9/enums;enums�GAA�Google.Ads.GoogleAds.V9.Enums�Google\\Ads\\GoogleAds\\V9\\Enums�!Google::Ads::GoogleAds::V9::Enumsbproto3
�
2google/ads/googleads/v9/common/final_app_url.protogoogle.ads.googleads.v9.commongoogle/api/annotations.proto"�
FinalAppUrlg
os_type (2V.google.ads.googleads.v9.enums.AppUrlOperatingSystemTypeEnum.AppUrlOperatingSystemType
url (	H �B
_urlB�
"com.google.ads.googleads.v9.commonBFinalAppUrlProtoPZDgoogle.golang.org/genproto/googleapis/ads/googleads/v9/common;common�GAA�Google.Ads.GoogleAds.V9.Common�Google\\Ads\\GoogleAds\\V9\\Common�"Google::Ads::GoogleAds::V9::Commonbproto3'
        , true);
        static::$is_initialized = true;
    }
}

