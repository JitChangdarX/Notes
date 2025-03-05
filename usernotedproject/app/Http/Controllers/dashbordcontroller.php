<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;
class dashbordcontroller extends Controller
{
    public function dashbordaction() {
        $user_id = Session::get('user_id');
        $user = User::find($user_id);
      
        return view('dashbord', compact('user', 'user_id'));
    }

    
}
