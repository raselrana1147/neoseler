<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class MerchantHistori extends Model
{
    protected $guarded=[];

    public function merchant()
    {
        return $this->belongsTo('App\Models\Admin','merchant_id');
    }

    public function order()
    {
        return $this->belongsTo('App\Models\Order','order_id');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product','pro_id');
    }
}
