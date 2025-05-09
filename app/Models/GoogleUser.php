<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class GoogleUser extends Authenticatable
{
    protected $table = 'google_users';
    protected $fillable = ['name', 'email', 'google_id', 'avatar'];

    // Disable remember token
    public function getRememberToken()
    {
        return null;
    }

    public function setRememberToken($value)
    {
        // Do nothing
    }

    public function getRememberTokenName()
    {
        return null;
    }
}