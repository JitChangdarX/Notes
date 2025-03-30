<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function loginactions(Request $request)
    {
        Log::info('Login function called');
        Log::info('Request Data:', $request->all());

        // Validate request including reCAPTCHA
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'g-recaptcha-response' => 'required'
        ]);

        // Verify reCAPTCHA
        $recaptchaSecret = config('services.recaptcha.secret');
        $recaptchaResponse = $request->input('g-recaptcha-response');
        
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $recaptchaSecret,
            'response' => $recaptchaResponse,
            'remoteip' => $request->ip()
        ]);

        $recaptchaData = $response->json();
        if (!$recaptchaData['success']) {
            Log::error('reCAPTCHA verification failed', $recaptchaData);
            return back()->withErrors(['g-recaptcha-response' => 'reCAPTCHA verification failed.'])->withInput();
        }

        // Log email
        Log::info('User email:', ['email' => $request->email]);

        // Check if user exists
        $user = DB::table('signup_account')->where('email', $request->email)->first();

        if (!$user) {
            Log::error('User not found: ' . $request->email);
            return back()->withErrors(['email' => 'Invalid email or password.'])->withInput();
        }

        // Check password
        if (!Hash::check($request->password, $user->password)) {
            Log::error('Password mismatch for user: ' . $request->email);
            return back()->withErrors(['password' => 'Invalid email or password.'])->withInput();
        }

        // Log user info
        Log::info('User found:', ['id' => $user->id, 'email' => $user->email]);

        // Set session data
        Session::put('user_id', $user->id);
        Session::save();

        Log::info('Session saved:', Session::all());
        
        // Update remember token
        $newToken = Str::random(60);
        DB::table('signup_account')->where('id', $user->id)->update(['remember_token' => $newToken]);
        
        // Redirect
        return redirect()->route('dashboard')->with('success', 'Login successful!');
    }

    public function logout()
    {
        // Clear remember token before logout
        DB::table('signup_account')->where('id', Session::get('user_id'))->update(['remember_token' => null]);

        // Destroy session
        Session::flush();
        return redirect('/login')->with('success', 'Logged out successfully.');
    }
}
