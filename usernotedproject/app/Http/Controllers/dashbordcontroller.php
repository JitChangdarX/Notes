<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
use App\Models\Signup;
use Illuminate\Support\Facades\DB;

class dashbordcontroller extends Controller
{
    public function show($id)
    {
        $user = DB::table('signup_account')->where('id', $id)->first();

        if (!$user) {
            return redirect('/login')->withErrors(['error' => 'User not found']);
        }

        return view('dashbord', ['user' => $user]);
    }
}


