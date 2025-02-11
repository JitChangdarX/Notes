<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;

use App\Models\signup;

use Illuminate\Http\Request;

class signupcontroller extends Controller
{
    public function signup()
    {
        return view('signup');
    }

    public function signupactions(Request $request)
    {
        $rule = [
            'name' => 'required|max:50|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|max:15',
            'confirmpassword' => 'required|same:password',
        ];

        $validator = Validator::make($request->all(), $rule);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();  // Retain old input values
        }

        // Save user data if validation passes
        $signup = new Signup();
        $signup->name = $request->name;
        $signup->email = $request->email;
        $signup->password = bcrypt($request->password); // Hash the password
        $signup->save();

        return redirect()->route('signup')->with('success', 'Signup successful');
    }
}
