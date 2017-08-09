<?php

namespace App\Objects;



use Oseintow\Shopify\Facades\Shopify;

class ScriptTag {
    
    public static function register()
    {
        $postData = [

            'event' => 'onload',
            'src' => env('APP_URL') . 'js/storefront.js'

        ];

        return Shopify::setShopUrl(session('domain'))
               ->setAccessToken(session('access_token'))
               ->post('admin/script_tags.json' , [ "script_tag" => $postData]);
    }

}