<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class PasswordUpdateLog extends Model
{
    public $timestamps = false;

    protected $fillable = ['user_id', 'email', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(Signup::class, 'user_id');
    }
}
