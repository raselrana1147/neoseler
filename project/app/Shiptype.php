<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shiptype extends Model
{
    protected $fillable = ['name']; 
    
    public function shipinfo(){
    	return $this->hasMany('App\Models\Shipping');
    }
}
