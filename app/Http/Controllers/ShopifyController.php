<?php

namespace App\Http\Controllers;

use DB;
use Log;
use App\Shop;
use App\Setting;
use App\Objects\ScriptTag;
use Illuminate\Http\Request;
use Oseintow\Shopify\Shopify;
use App\Objects\ShopifyWebhook;
use Oseintow\Shopify\Exceptions\ShopifyApiException;
use App\ShopInfo;


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
    		$shop = Shop::where('myshopify_domain' , $shopUrl)->first();
    		if($shop)
    		{
    			session([

    					'shopifyId' => $shop->shopify_id,
    					'myshopifyDomain' => $shop->domain,
    					'accessToken' => $shop->access_token

    				]);

    			return view('home.index' , ['shop' => $shop , 'settings' => $shop->settings]);
    		}
    		else{
    			$shopify = $this->shopify->setShopUrl($shopUrl);
    			return redirect()->to($shopify->getAuthorizeUrl(config('shopify.scope') , config('shopify.redirect_uri')));
    		}
    	}
    	else{
    		abort(404);
    	}

    }

    public function callback(Request $request)
    {
		$queryString = $request->getQueryString();
		
    	if($this->shopify->verifyRequest($queryString))
    	{

    		$shopUrl = $request->shop;
    		try{
    			$accessToken = $this->shopify->setShopUrl($shopUrl)->getAccessToken($request->code);

    			$shopResponse = $this->shopify->setShopUrl($shopUrl)
    										  ->setAccessToken($accessToken)
    										  ->get('admin/shop.json');
  				if($shopResponse)
  				{
  					session([
  							'shopifyId' => $shopResponse['id'],
  							'myshopifyDomain' => $shopUrl,
  							'accessToken' => $accessToken
					]);
					
					$shop = $this->createShop($shopResponse);
					$this->createDefaultSettings($shop);
					$this->storeShopInfo($shopResponse, $shop->id);

					ShopifyWebhook::registerAppUninstallWebhook();

					if(config('shopify.billing_enabled'))
					{
						return redirect()->route('billing.charge');
					}
		
					ScriptTag::register();
					  
  					return redirect("https://{$shopUrl}/admin/apps");
  				}

    		} catch (ShopifyApiException $e) {
				Log::critical("Installation Callback exception." , ['message' => $e->getMessage(), 'shop' => $shopUrl]);
				abort(500);
    		}
    	}else{
			abort(500,"Hmm, Something doesn't look right.");
		}
    }

   	protected function createShop($data)
	{
		return Shop::create([
				'shopify_id' => $data['id'],
				'myshopify_domain' => $data['myshopify_domain'],
				'access_token' => session('accessToken')
		]);
	}

	protected function createDefaultSettings($shop)
    {
        return $settings = Setting::create([
            'enabled' => 1,
            'shop_id' => $shop->id,
            'myshopify_domain' => $shop->myshopify_domain
        ]);
	}
	
	protected function storeShopInfo($data, $shopId)
	{
		unset($data['id']);
		$data['shop_id'] = $shopId;
		return ShopInfo::create($data->toArray());
	}
}
