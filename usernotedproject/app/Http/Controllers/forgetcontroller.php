<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class forgetcontroller extends Controller
{
   public function forgetpassword(){
    return view('forgetpassword');
   }
} 
