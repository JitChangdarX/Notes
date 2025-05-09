<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class forgetcontroller extends Controller
{
   public function forgetemail(){
    return view('email');
   }

   public function sendResetLink(Request $request)
{
    $request->validate([
        'email' => 'required|email|exists:users,email',
    ]);

    $token = Str::random(64);

    DB::table('password_resets')->insert([
        'email' => $request->email,
        'token' => $token,
        'created_at' => now(),
    ]);

    Mail::send('emails.reset', ['token' => $token], function($message) use($request) {
        $message->to($request->email);
        $message->subject('Password Reset Request');
    });

    return back()->with('success', 'Reset link sent! Check your email.');
}
} 
