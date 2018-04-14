<?php

namespace App\Http\Controllers;

use Log;
use App\Shop;
use Illuminate\Http\Request;
use Oseintow\Shopify\Facades\Shopify;
use Symfony\Component\HttpFoundation\Response;

class WebhookController extends Controller
{
    public function app_uninstall(Request $request)
    {

	    $data = $request->getContent();

	    $hmacHeader = $request->server('HTTP_X_SHOPIFY_HMAC_SHA256');

	    if (Shopify::verifyWebHook($data, $hmacHeader)) {
	        
	    	$payload = json_decode($data , true);
	    	$shop = Shop::where('shopify_id' , $payload['id'])->first();
	    	$shop->delete();
	    	Log::info('Webhook Request verified and Handled.');
	    	return new Response('Webhook Handled', 200);

	    } else {
	        Log::info('Webhook Request was not verified.');
	    }

    }
}
