<?php

namespace App\Objects;



use Oseintow\Shopify\Facades\Shopify;

class ShopifyWebhook {
    
    public static function registerAppUninstallWebhook()
    {
        $postData = [
            
            "topic" => "app/uninstalled",
            "address" => env('APP_URL') . '/shopify/webhook/app_uninstall',
            "format" => "json"
            
        ];
        
        return Shopify::setShopUrl(session('domain'))
                       ->setAccessToken(session('access_token'))
                       ->post('admin/webhooks.json' , [ "webhook" => $postData]);
    }
    
}