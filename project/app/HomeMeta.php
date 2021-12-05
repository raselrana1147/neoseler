<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HomeMeta extends Model
{
    protected $fillable = ['meta_value', 'meta_title','meta_content','meta_type'];
}
