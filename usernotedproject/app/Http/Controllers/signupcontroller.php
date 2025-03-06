<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use App\Models\Signup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SignupController extends Controller
{
    public function signup()
    {
        return view('signup');
    }

    public function hiden_div()
    {
        return view('hidden_div');
    }

    public function signupactions(Request $request)
    {
        // Validation Rules
        $rule = [
            'name' => 'required|max:50|min:3',
            'email' => 'required|email',
            'password' => 'required|max:15|min:6',
            'confirmpassword' => 'required|same:password',
            'profile_photo' => 'required|array', // Ensure input is an array
            'profile_photo.*' => 'image|mimes:jpg,jpeg,gif,png,avif|max:2048', // Allow multiple images
        ];

        $validator = Validator::make($request->all(), $rule);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();  // Retain old input values
        }

        // Ensure Uploads Directory Exists
        $uploadPath = public_path('uploads');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        // Image Upload Handling
        $uploadedImages = [];

        if ($request->hasFile('profile_photo')) {
            foreach ($request->file('profile_photo') as $file) {
                if ($file->isValid()) { // Ensure file is valid
                    $fileName = time() . rand(1, 9999) . '.' . $file->getClientOriginalExtension();
                    $file->move($uploadPath, $fileName);
                    $uploadedImages[] = 'uploads/' . $fileName; // Store relative path
                }
            }
        }

        // Store User Data
        $signup = new Signup();
        $signup->name = $request->name;
        $signup->email = $request->email;
        $signup->password = bcrypt($request->password); // Hash password
        $signup->profile_photo = json_encode($uploadedImages); // Store as JSON array in DB
        $signup->save();

        return redirect()->route('login')->with('success', 'Signup successful!');
    }
}