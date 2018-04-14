<?php

namespace App\Http\Controllers;

use App\Objects\ScriptTag;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    /**
     * @param Request $request
     */
    public function charge(Request $request)
    {
        $newCharge = new Charge();
        try{
            $response = $newCharge->charge();
            $confirmationUrl = $response['confirmation_url'];
            return view('billing.escape_iframe' , ['url' => $confirmationUrl]);
        }catch (ShopifyApiException $e){
            Log::error('Error occured while creating charge for ' . session('myshopifyDomain') . ' ' . $e->getMessage());
            abort(500);
        }

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function callback(Request $request)
    {
        $chargeId = $request->charge_id;
        if(!is_null($chargeId))
        {
            try{
                $charge = new Charge();
                $chargeStatus = $charge->status($chargeId);
                if($chargeStatus['status'] === 'accepted')
                {

                    $activateChargeResponse = $charge->activate($chargeStatus);
                    if($activateChargeResponse['status'] === 'active')
                    {
                        ScriptTag::register();
                        $shop = Shop::where('myshopify_domain' , session('myshopifyDomain'))->first();
                        $shop->is_premium = true;
                        $shop->charge_status = 'active';
                        $shop->save();
                        session(['is_premium_shop' => true]);
                        return redirect()->route('home');
                    }else{
                        Log::error('Their status was not active ' . session('myshopifyDomain'));
                        abort(500);
                    }
                }else{
                    Log::error('They did not accept the charge somehow ' . session('myshopifyDomain'));
                    return redirect()->route('billing.declined');
                }
            }catch (ShopifyApiException $e){
                Log::error('Error occured while activating charge for ' . session('myshopifyDomain') . ' ' . $e->getMessage());
                return redirect()->route('billing.declined');
            }
        }else{
            abort(500);
        }

    }

    public function declined()
    {
        return view('billing.declined');
    }

}
