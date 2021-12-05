<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use App\Shiptype;

class Shipping extends Model
{
    protected $fillable = ['user_id', 'location', 'duration', 'price','shiptype_id'];

    public $timestamps = false;

    public function typeinfo(){
    	return $this->belongsTo('App\Shiptype','shiptype_id');
    }

}