<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Signup extends Authenticatable
{
    use HasFactory;

    protected $table = 'signup_account';

    // Include online_user in fillable
    protected $fillable = ['name', 'email', 'password', 'profile_photo', 'remember_token', 'online_user', 'type','session_id'];

    // Optionally remove online_user from hidden for debugging
    protected $hidden = ['password', 'remember_token', 'online_user', 'session_id'];

    protected $casts = [
        'password' => 'hashed',
    ];
}