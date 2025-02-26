<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OtpController extends Controller
{public function sendOtp(Request $request)
    {
        // Validate the email field
        $request->validate([
            'email' => 'required|email'
        ]);
    
        $otp = rand(1000, 9999);
    
        Mail::send('emails.otp', ['otp' => $otp], function ($message) use ($request) {
            $email = $request->input('email');
    
            if (!$email) {
                return response()->json(['error' => 'Email is required'], 400);
            }
    
            $message->to($email)->subject('Your OTP');
        });
    
        return response()->json(['message' => 'OTP sent successfully']);
    }
}
