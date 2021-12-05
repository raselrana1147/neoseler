<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    



    public function user()
    {
    	return $this->belongsTo('App\Models\User','user_id');
    }
    public function merchant()
    {
    	return $this->belongsTo('App\Models\Admin','user_id');
    }
}
