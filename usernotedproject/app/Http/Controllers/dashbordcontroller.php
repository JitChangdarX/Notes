<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class dashbordcontroller extends Controller
{
    public function dashbordaction()

    {
        return view('dashbord');
    }
}
