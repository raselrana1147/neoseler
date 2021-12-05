<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $guard = 'admin';

    protected $fillable = [
        'name', 'email', 'phone', 'username', 'avatar', 'password','commission','role','emergency_number', 
    ];

    protected $hidden = [
        'password','remember_token',
    ];
    public function IsAdmin(){
        if ($this->role == 'Administrator') {
           return true;
        }
        return false;
    }
    public function IsStaff(){
        if ($this->role == 'Staff') {
           return true;
        }
        return false;
    }

    public function IsMerchant(){
        if ($this->role == 'Merchant') {
           return true;
        }
        return false;
    }

   

}
