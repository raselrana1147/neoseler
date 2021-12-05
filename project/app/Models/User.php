<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    //use Notifiable;
    protected $fillable = ['name','phone','email','verifycode','password','verification_link','photo','ref_user','parentuser','address','city','is_shopowner','businessname','shopname','location','businesstype','selling_way','emergency_number','facebook_link'];


    protected $hidden = [
        'password', 'remember_token'
    ];

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

    public function affcode()
    {
       return $this->hasOne('App\AffiliateM');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

    public function replies()
    {
        return $this->hasMany('App\Models\Reply');
    }

    public function ratings()
    {
        return $this->hasMany('App\Models\Rating');
    }

    public function wishlists()
    {
        return $this->hasMany('App\Models\Wishlist');
    }

    public function socialProviders()
    {
        return $this->hasMany('App\Models\SocialProvider');
    }

    public function withdraws()
    {
        return $this->hasMany('App\Models\Withdraw');
    }

    public function conversations()
    {
        return $this->hasMany('App\Models\AdminUserConversation');
    }

    public function notifications()
    {
        return $this->hasMany('App\Models\Notification');
    }

    public function reports()
    {
        return $this->hasMany('App\Models\Report','user_id');
    }

}
