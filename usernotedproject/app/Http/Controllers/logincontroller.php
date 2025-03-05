<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Signup;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function loginactions(Request $request)
    {
        $rules = 
        [
            'email' => 'required|email',
            'password' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = Signup::where('email', $request->email)->first();
        // fetch the use id
        Session::put('user_id', $user->id);
        session::put('name', $user->name);
        if (!$user) {
            return redirect()->back()->withErrors(['email' => 'User not found']);
        }

        if (!password_verify($request->password, $user->password)) {
            return redirect()->back()->withErrors(['password' => 'Incorrect password']);
        }


        // Login the user
    
        return redirect()->route('dashbord', ['id' => $user->id]); // Ensure this route exists
    }
   
}
