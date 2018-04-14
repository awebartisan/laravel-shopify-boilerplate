<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Shopify Api
    |--------------------------------------------------------------------------
    |
    | This file is for setting the credentials for shopify api key and secret.
    |
    */

    'key' => env("SHOPIFY_API_KEY", null),
    'secret' => env("SHOPIFY_API_SECRET", null),
    'scope' => ["read_products" , "write_script_tags"],
    'redirect_uri' => env("SHOPIFY_REDIRECT_URI" , NULL),
    'billing_enabled' => env('SHOPIFY_BILLING_ENABLED' , FALSE),
    'billing_price' => env("SHOPIFY_BILLING_PRICE", NULL),
    'billing_trial_days' => env("SHOPIFY_BILLING_TRIAL_DAYS", NULL),
    'billing_test_charge' => env("SHOPIFY_BILLING_TEST_CHARGE", TRUE)
];