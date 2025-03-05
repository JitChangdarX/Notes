<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SignupAccount extends Model
{
    use HasFactory;
    protected $table = 'signup_account'; // Define exact table name

    protected $fillable = ['name', 'email', 'password']; // Add actual columns
}
