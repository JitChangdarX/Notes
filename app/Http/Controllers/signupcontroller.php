<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Signup;
use Illuminate\Support\Str;

class SignupController extends Controller
{
    public function signup()
    {
        return view('signup');
    }

    public function signupactions(Request $request)
    {
      
        $rules = [
            'name' => 'required|max:50|min:3',
            'email' => 'required|email|unique:signup_account,email', // Ensure email is unique
            'password' => 'required|max:15|min:6',
            'confirmpassword' => 'required|same:password',
            'profile_photo.*' => 'nullable|image|mimes:jpg,jpeg,gif,png,avif|max:2048',  // Support single file
        ];
     
     
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput(); // Retain input values
        }

    
        $uploadedImages = [];

        if ($request->hasFile('profile_photo')) {
            foreach ($request->file('profile_photo') as $file) {
                if ($file->isValid()) {
                    $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                    $filePath = 'uploads/' . $fileName;
                    $file->move(public_path('uploads'), $fileName);
                    $uploadedImages[] = $filePath;
                }
            }
        }
        
        $session_id = bin2hex(random_bytes(16));
        $signup = new Signup();
        $signup->name = $request->name;
        $signup->email = $request->email;
        $signup->password = bcrypt($request->password);
        $signup->profile_photo = json_encode($uploadedImages);
        $signup->remember_token = Str::random(60);
        $signup->session_id = $session_id;
        $signup->save();

        session(['recent_signup_email' => $signup->email]);

        session(['signup_session_id' => $session_id]);
    \Log::info('Session ID stored during signup', ['signup_session_id' => session('signup_session_id')]);
    
        return redirect()->route('logins',)->with('success', 'Signup successful! You can now log in.');
    }
}
