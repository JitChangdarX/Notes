<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Signup extends Authenticatable
{
    use HasFactory;

    protected $table = 'signup_account';

    // Make sure remember_token is included here
    protected $fillable = ['name', 'email', 'password', 'profile_photo', 'remember_token'];

    // Fields that should be hidden
    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'password' => 'hashed',
    ];
}

