<?php

namespace App\Http\Controllers;

use App\Shop;
use App\Objects\ScriptTag;
use Illuminate\Http\Request;
use Oseintow\Shopify\Shopify;
use App\Objects\ShopifyWebhook;
use Oseintow\Shopify\Exceptions\ShopifyApiException;


class ShopifyController extends Controller
{
    protected $shopify;

    function __construct(Shopify $shopify)
    {
    	$this->shopify = $shopify;
    }

    public function access(Request $request)
    {
    	
    	$shopUrl = $request->shop;

    	if($shopUrl)
    	{
    		$shop = Shop::where('domain' , $shopUrl)->first();
    		if($shop)
    		{
    			session([

    					'shop_id' => $shop->shop_id,
    					'domain' => $shop->domain,
    					'access_token' => $shop->access_token

    				]);

    			return view('app.index');
    		}
    		else{
    			$shopify = $this->shopify->setShopUrl($shopUrl);
    			return redirect()->to($shopify->getAuthorizeUrl(config('shopify.scope') , env('SHOPIFY_REDIRECT_URI')));
    		}
    	}
    	else{
    		dd('You must provide a valid myshopify domain!');
    	}

    }

    public function callback(Request $request)
    {
    	$queryString = $request->getQueryString();
    	if($this->shopify->verifyRequest($queryString))
    	{
    		$shopUrl = $request->shop;

    		try {
    			$accessToken = $this->shopify->setShopUrl($shopUrl)->getAccessToken($request->code);

    			//Make your first API call and get Shop Data
    			$shopResponse = $this->shopify->setShopUrl($shopUrl)
    										  ->setAccessToken($accessToken)
    										  ->get('admin/shop.json');
  				if($shopResponse)
  				{
  					session([

  							'shop_id' => $shopResponse['id'],
  							'domain' => $shopUrl,
  							'access_token' => $accessToken

  						]);

  					$this->createShop($shopResponse);


  					ShopifyWebhook::registerAppUninstallWebhook();
  					ScriptTag::register();

  					return redirect("https://{$shopUrl}/admin/apps");


  				}

    		} catch (ShopifyApiException $e) {
    			dd($e->getMessage());
    		}
    	}
    }

   	protected function createShop($shopResponse)
	{
		return Shop::create([
				'shop_id' => $shopResponse['id'],
				'name' => $shopResponse['name'],
				'domain' => $shopResponse['myshopify_domain'],
				'access_token' => session('access_token')

			]);
	}
}
