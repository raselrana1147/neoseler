<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aorder extends Model
{
     protected $fillable = ['customer_name','customer_phone','customer_city','customer_address','price','quantity','username','commission','shippingmethod','product_id'];


     public function product(){
     	return $this->belongsTo('App\Models\Product');
     }
     
}
