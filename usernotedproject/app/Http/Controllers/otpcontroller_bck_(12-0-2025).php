<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use App\Mail\OtpMail;
use App\Models\OtpCode;
use App\Models\Signup;

class OTPController extends Controller
{
    public function showEmailForm()
    {
        return view('email-form');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // Optional check if user must be signed up first
        // if (!Signup::where('email', $request->email)->exists()) {
        //     return redirect('/signup')->withErrors(['email' => 'Email not found. Please sign up first.']);
        // }

        $otp = rand(100000, 999999);

        OtpCode::updateOrCreate(
            ['email' => $request->email],
            [
                'token' => encrypt($otp),
                'created_at' => now(),
                'expires_at' => now()->addMinutes(30),
            ]
        );

        Mail::to($request->email)->send(new OtpMail($otp, $request->email));

        return redirect()->route('otp.email.form')->with([
            'success' => 'OTP sent to your email.',
            'otp_sent' => true,
            'email' => $request->email,
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $otpRecords = OtpCode::where('expires_at', '>=', now())->get();

        $otpRecord = $otpRecords->first(function ($record) use ($request) {
            try {
                return decrypt($record->token) == $request->otp;
            } catch (\Exception $e) {
                return false;
            }
        });

        if (!$otpRecord) {
            return back()->withErrors(['otp' => 'Invalid or expired OTP.'])->with('otp_sent', true);
        }

        OtpCode::where('email', $otpRecord->email)->delete();

        return redirect()->route('otp.email.form')->with([
            'otp_sent' => true,
            'success' => 'OTP verified successfully!',
            'email' => $otpRecord->email,
            'otp_verified' => true, 
        ]);
    }

    public function showOtpForm()
    {
        return view('verify-otp');
    }
}
