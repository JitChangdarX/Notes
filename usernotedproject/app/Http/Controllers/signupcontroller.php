<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use App\Models\signup;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;



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

        // $this->validator($request->all())->validate();
        // event(new Registered($user = $this->create($request->all())));

        // // Manually log the user in if auto-login is broken
        // $this->guard()->login($user);

        // return $this->registered($request, $user)
        //     ?: redirect($this->redirectPath());

        $validator = Validator::make($request->all(), $rule);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();  // Retain old input values
        }

        if ($request->password != $request->confirmpassword) {
            return redirect()->back()->with('error', 'Password and Confirm Password do not match');
        }

        if (signup::where('email', $request->email)->exists()) {
            return redirect()->back()->with('error', 'Email already exists');
        }


        // Save user data if validation passes
        $signup = new Signup();
        $signup->name = $request->name;
        $signup->email = $request->email;
        $signup->password = bcrypt($request->password); // Hash the password
        $signup->save();

        // Auth::login($signup);

        return redirect()->route('login')->with('success', 'Signup successful');
    }
}
