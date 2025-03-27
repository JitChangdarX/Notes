<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Models\Signup;

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
        if (!$recaptchaData['success']) {
            return redirect()->back()->withErrors(['captcha' => 'reCAPTCHA verification failed'])->withInput();
        }

        // Fetch user manually from the database
        $user = DB::table('signup_account')->where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return redirect()->back()->withErrors(['email' => 'Invalid credentials'])->withInput();
        }

        // Store user ID in session (if required)
        Session::put('user_id', $user->id);
        $encryptedUserId = Crypt::encrypt($user->id);
        echo $encryptedUserId;
        // Redirect to dashboard with user ID
        return redirect()->route('dashboard', ['id' => $user->id]);
    }
}
