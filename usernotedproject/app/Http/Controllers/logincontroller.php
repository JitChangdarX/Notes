<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;

class LoginController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function loginactions(Request $request)
    {
        Log::info('Login attempt for email: ' . $request->email);

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'g-recaptcha-response' => 'required'
        ]);

        // Verify Google reCAPTCHA
        $recaptchaSecret = env('NOCAPTCHA_SECRET');
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret'   => $recaptchaSecret,
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip()
        ]);

        $recaptchaData = $response->json();
        if (!isset($recaptchaData['success']) || !$recaptchaData['success']) {
            return redirect()->back()->withErrors(['captcha' => 'reCAPTCHA verification failed'])->withInput();
        }

        // Fetch user from the database
        $user = DB::table('signup_account')->where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // Store session data
            Session::put('user_id', $user->id);
            Session::put('user_email', $user->email);
            Session::put('user_name', $user->name);

            return redirect()->route('dashboard'); // ✅ Remove encryptedId from redirect
        } else {
            return back()->with('error', 'Invalid email or password');
        }
    }

    // Logout method
    public function logout()
    {
        Session::flush();
        return redirect('/login')->with('success', 'Logged out successfully.');
    }
}
