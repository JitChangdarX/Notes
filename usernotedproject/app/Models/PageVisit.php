<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageVisit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ip_address',
        'user_agent',
        'url',
        'referrer',
        'browser',
        'device_type',
        'country',
        'country_code',
        'region',
        'city',
        'zip_code',
        'latitude',
        'longitude'
    ];
}
