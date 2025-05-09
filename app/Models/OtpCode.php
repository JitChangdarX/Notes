<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtpCode extends Model
{
    use HasFactory;

    protected $table = 'otp_codes'; // add this explicitly

    protected $fillable = ['email', 'token', 'created_at', 'expires_at'];

    protected $dates = ['created_at', 'expires_at'];

    public $timestamps = false; // we’re manually handling timestamps
}
