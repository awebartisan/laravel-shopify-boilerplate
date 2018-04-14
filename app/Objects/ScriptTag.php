<?php

namespace App\Objects;


use Oseintow\Shopify\Facades\Shopify;

class ScriptTag {
    
    public static function register()
    {
        $postData = [

            'event' => 'onload',
            'src' => config('app.url') . '/js/storefront.js'

        ];

        return Shopify::setShopUrl(session('myshopifyDomain'))
               ->setAccessToken(session('accessToken'))
               ->post('admin/script_tags.json' , [ "script_tag" => $postData]);
    }

}