<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class AffiliateM extends Model
{
    
    public function userinfo(){
    	return $this->belongsTo(App\Models\User::class,'user_id');

    }
}
