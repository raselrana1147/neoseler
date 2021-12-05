<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use App\Models\Users;

class Review extends Model
{
    protected $fillable = ['photo','title','subtitle','details','user_id'];
    public $timestamps = false;

    public function user()
    {
    	return $this->belongsTo('App\Models\User');
    }
}
