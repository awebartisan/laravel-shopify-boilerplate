<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $fillable = ['shopify_id', 'myshopify_domain','access_token', 'is_premium', 'charge_status'];

    public function settings()
    {
        return $this->hasOne('App\Setting');
    }

    public function isPremiumShop()
    {
        if($this->is_premium)
        {
            return true;
        }
    }
}
