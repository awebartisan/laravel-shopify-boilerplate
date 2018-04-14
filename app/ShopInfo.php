<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShopInfo extends Model
{
    protected $table = 'shops_info';

    protected $fillable = [
        'shop_id',
        'name',
        'email',
        'domain',
        'shop_owner',
        'phone',
        'country',
        'province',
        'city',
        'currency',
        'primary_locale',
        'iana_timezone',
    ];
    
}
