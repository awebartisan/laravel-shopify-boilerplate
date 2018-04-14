<?php
namespace App\Objects\Billing;

use Log;
use Oseintow\Shopify\Facades\Shopify;

class Charge {

    public function charge()
    {

        $postData = [

            "name" => "Primary Plan",
            "price" => config('shopify.billing_price'),
            "return_url" => config('app.url') . '/billing/callback',
            "test" => config('shopify.billing_test_charge'),
            "trial_days" => config('shopify.billing_trial_days'),

        ];
        $response = Shopify::setShopUrl(session('myshopifyDomain'))
                            ->setAccessToken(session('accessToken'))
                            ->post('admin/recurring_application_charges.json' , [ "recurring_application_charge" => $postData]);

        return $response;
    }

    public function status($chargeId)
    {
        return Shopify::setShopUrl(session('myshopifyDomain'))
                        ->setAccessToken(session('accessToken'))
                        ->get("admin/recurring_application_charges/{$chargeId}.json");
    }

    public function activate($charge)
    {
        $postData = [

            'id' => $charge['id'],
            'name' => $charge['name'],
            'price' => $charge['price'],
            'test' => $charge['test'],
        ];
        $chargeId = $charge['id'];

        $response = Shopify::setShopUrl(session('myshopifyDomain'))
            ->setAccessToken(session('accessToken'))
            ->post("admin/recurring_application_charges/{$chargeId}/activate.json" , [ "recurring_application_charge" => $postData]);
    
        return $response;
    }

}