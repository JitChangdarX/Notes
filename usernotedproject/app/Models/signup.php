<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class signup extends Model
{
    use HasFactory;

    protected $table = 'signup_account';
    protected $fillable = ['name', 'email', 'password', 'profile_photo'];
    // public $timestamps = false;

}
