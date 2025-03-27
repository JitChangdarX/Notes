<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable; // ✅ Change from Model to Authenticatable

class Signup extends Authenticatable
{
    use HasFactory;
    protected $table = 'signup_account';
    protected $fillable = ['name', 'email', 'password']; // ✅ Ensure these fields are mass assignable

    protected $hidden = ['password']; // ✅ Hide password in responses

    protected $casts = [
        'password' => 'hashed', // ✅ Ensure password is securely hashed (Laravel 10+)
    ];
}

