<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Api extends Model
{
    
    public static function api(){

    		$api=Api::get()->first();
    		return $api;
    }
}
