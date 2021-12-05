<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    


	public function order(){

		return $this->belongsTo('App\Models\Order');
	}

	public function product(){

		return $this->belongsTo('App\Models\Product','pro_id');
	}
	public function merchant(){

		return $this->belongsTo('App\Models\Admin','merchant_user');
	}

}
