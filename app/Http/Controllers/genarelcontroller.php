<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class genarelcontroller extends Controller
{
    public function index()
    {
        return view('genaral_setting');
    }
}
