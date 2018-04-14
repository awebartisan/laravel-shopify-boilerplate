<?php

namespace App\Objects;



use Oseintow\Shopify\Facades\Shopify;

class ShopifyWebhook {
    
    public static function registerAppUninstallWebhook()
    {
        $postData = [
            
            "topic" => "app/uninstalled",
            "address" => config('app.url') . '/shopify/webhook/app_uninstall',
            "format" => "json"
            
        ];
        
        return Shopify::setShopUrl(session('myshopifyDomain'))
                       ->setAccessToken(session('accessToken'))
                       ->post('admin/webhooks.json' , [ "webhook" => $postData]);
    }
    
}