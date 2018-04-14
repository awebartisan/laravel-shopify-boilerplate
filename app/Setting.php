<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['enabled', 'shop_id'];

    protected $casts = [
        'enabled' => 'boolean'
    ];

    public function shop()
    {
        return $this->belongsTo('App\Shop');
    }
}
