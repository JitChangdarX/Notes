<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\RateLimiter;
use App\Mail\OtpMail;
use App\Models\OtpCode;
use App\Models\Signup;
use App\Models\PasswordUpdateLog;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class OTPController extends Controller
{
    public function showForm()
    {
        if (!session('otp_sent') && !session('otp_verified')) {
            session()->forget(['otp_sent', 'email', 'otp_verified']);
        }
        return view('email-form');
    }

    public function sendOtp(Request $request)
    {
        Log::info('sendOtp called with email: ' . $request->email);

        $key = 'otp-send:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            Log::warning('Rate limit exceeded for IP: ' . $request->ip());
            return $request->expectsJson()
                ? response()->json(['success' => false, 'message' => 'Too many attempts. Try again later.'], 429)
                : back()->withErrors(['email' => 'Too many attempts. Try again later.']);
        }
        RateLimiter::hit($key, 60);

        $email = trim($request->email);

        $signup = Signup::where('email', $email)->first();
        if (!$signup) {
            Log::warning('Email not found in signup_account table: ' . $email);
            return back()->withErrors(['email' => 'This email is not registered. Please sign up first.']);
        }

        $request->validate([
            'email' => 'required|email',
        ], [
            'email.email' => 'Please enter a valid email address.',
        ]);

        $otp = rand(100000, 999999);
        try {
            OtpCode::updateOrCreate(
                ['email' => $email],
                [
                    'token' => Crypt::encryptString($otp),
                    'created_at' => now(),
                    'expires_at' => now()->addMinutes(5),
                ]
            );

            try {
                Mail::to($email)->send(new OtpMail($otp, $email));
            } catch (\Exception $e) {
                Log::error('Failed to send OTP email: ' . $e->getMessage());
                return $request->expectsJson()
                    ? response()->json(['success' => false, 'message' => 'Failed to send OTP. Please try again.'], 500)
                    : back()->withErrors(['email' => 'Failed to send OTP. Please try again.']);
            }
        } catch (\Exception $e) {
            Log::error('Failed to store OTP: ' . $e->getMessage());
            return $request->expectsJson()
                ? response()->json(['success' => false, 'message' => 'An error occurred. Please try again.'], 500)
                : back()->withErrors(['email' => 'An error occurred. Please try again.']);
        }

        session([
            'otp_sent' => true,
            'email' => $email,
            'otp_verified' => false,
        ]);

        return $request->expectsJson()
            ? response()->json(['success' => true, 'message' => 'OTP sent to your email.'])
            : redirect()->route('otp.form')->with('success', 'OTP sent to your email.');
    }

    public function verifyOtp(Request $request)
    {
        Log::info('verifyOtp called with OTP: ' . $request->otp);

        $key = 'otp-verify:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 10)) {
            Log::warning('Rate limit exceeded for IP: ' . $request->ip());
            session()->forget(['otp_sent', 'email', 'otp_verified']);
            return back()->withErrors(['otp' => 'Too many attempts. Please start over.']);
        }
        RateLimiter::hit($key, 60);

        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $otpRecord = OtpCode::where('email', session('email'))
            ->where('expires_at', '>=', now())
            ->first();

        if (!$otpRecord) {
            Log::warning('No valid OTP record found for email: ' . session('email'));
            session()->forget(['otp_sent', 'email', 'otp_verified']);
            return back()->withErrors(['otp' => 'OTP has expired or is invalid. Please start over.']);
        }

        try {
            if (Crypt::decryptString($otpRecord->token) == $request->otp) {
                session(['otp_verified' => true]);
                OtpCode::where('email', $otpRecord->email)->delete();
                RateLimiter::clear($key);
                Log::info('OTP verified successfully for email: ' . $otpRecord->email);
                return redirect()->route('otp.form')->with('success', 'OTP verified successfully!');
            } else {
                Log::warning('Invalid OTP entered for email: ' . session('email'));
                return back()->withErrors(['otp' => 'Invalid OTP.'])->with('otp_sent', true);
            }
        } catch (\Exception $e) {
            Log::error('OTP decryption failed: ' . $e->getMessage());
            return back()->withErrors(['otp' => 'Invalid OTP.'])->with('otp_sent', true);
        }
    }

    public function updatePassword(Request $request)
    {
        Log::info('updatePassword called with email: ' . $request->email);

        if (!session('otp_verified') || !session('email')) {
            Log::warning('Session validation failed: otp_verified=' . json_encode(session('otp_verified')) . ', email=' . session('email'));
            session()->forget(['otp_sent', 'email', 'otp_verified']);
            return redirect()->route('otp.form')->withErrors(['error' => 'Unauthorized access. Please start over.']);
        }

        $request->validate([
            'email' => 'required|email',
            'new_password' => 'required|min:8|confirmed',
        ], [
            'email.email' => 'Please enter a valid email address.',
            'new_password.min' => 'The password must be at least 8 characters.',
            'new_password.confirmed' => 'The password confirmation does not match.',
        ]);

        $email = trim($request->email);
        if ($email !== session('email')) {
            Log::warning('Email mismatch: request=' . $email . ', session=' . session('email'));
            session()->forget(['otp_sent', 'email', 'otp_verified']);
            return redirect()->route('otp.form')->withErrors(['error' => 'Invalid session. Please start over.']);
        }

        $signup = Signup::where('email', $email)->first();
        if (!$signup) {
            Log::warning('Signup not found for email: ' . $email);
            return back()->withErrors(['email' => 'This email is not registered.'])->withInput();
        }

        try {
            Log::info('Attempting to update password for email: ' . $email);
            $signup->password = $request->new_password;
            $signup->save();

            $updatedSignup = Signup::where('email', $email)->first();
            if (!Hash::check($request->new_password, $updatedSignup->password)) {
                Log::error('Password verification failed after update for email: ' . $email);
                return back()->withErrors(['error' => 'Failed to verify password update. Please try again.'])->withInput();
            }

            // Log password update
            PasswordUpdateLog::create([
                'user_id' => $signup->id,
                'email' => $signup->email,
                'updated_at' => now(),
            ]);

            // Count updates
            $updateCount = PasswordUpdateLog::where('user_id', $signup->id)->count();
            $ordinal = $this->getOrdinal($updateCount);

            Log::info('Password updated successfully for email: ' . $email . '. Update count: ' . $updateCount);
            session()->forget(['otp_sent', 'email', 'otp_verified']);
            return redirect()->route('logins')->with('success', "Your password has been reset successfully. This is your {$ordinal} time updating your password. Please log in with your new password.");
        } catch (\Exception $e) {
            Log::error('Password update failed for email: ' . $email . '. Error: ' . $e->getMessage() . ' | Trace: ' . $e->getTraceAsString());
            return back()->withErrors(['error' => 'Failed to update password. Please try again.'])->withInput();
        }
    }

    private function getOrdinal($number)
    {
        $ends = ['th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th'];
        if ((($number % 100) >= 11) && (($number % 100) <= 13)) {
            return $number . 'th';
        }
        return $number . $ends[$number % 10];
    }
}