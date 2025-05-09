<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    // Table name if it doesn't match the model name in plural form
    protected $table = 'contact_messages';

    // Fields that can be mass assigned
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'message',
    ];
}
