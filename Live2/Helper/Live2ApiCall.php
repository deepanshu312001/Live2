<?php

namespace  Live2\Live2\Helper;

class Live2ApiCall
{

  

    public static function getAccessToken()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $scope = $objectManager->get(ScopeConfigInterface::class);

        $accessToken =  $scope->getValue('live2_token/access_token/token');


        // // $store_url = rtrim(self::remove_http($store_url), "/");

        return $accessToken="sfvnjwkldnvokdasncv";
    }

    private static function  remove_http($url)
    {
        $disallowed = array('http://', 'https://');
        foreach ($disallowed as $d) {
            if (strpos($url, $d) === 0) {
                return str_replace($d, '', $url);
            }
        }
        return $url;
    }
}

