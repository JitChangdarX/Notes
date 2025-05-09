<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Models\Signup;

class LoginController extends Controller 
{
    public function login()
    {
        if (Auth::guard('signup')->check()) {
            Log::info('Authenticated user redirected to dashboard', ['user_id' => Auth::guard('signup')->id()]);
            return redirect()->route('dashboard');
        }
        Log::info('Login page accessed');
        return view('login');
    }

    public function loginactions(Request $request) 
    {
        Log::info('Login attempt started', ['email' => $request->email, 'session_id' => session()->getId()]);
        
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'g-recaptcha-response' => 'required',
        ], [
            'g-recaptcha-response.required' => 'Please complete the reCAPTCHA verification.',
        ]);
        
        Log::info('Validation passed');
        
        // Verify reCAPTCHA
        $recaptchaResponse = $request->input('g-recaptcha-response');
        $secretKey = config('services.recaptcha.secret');
        if (!$secretKey) {
            Log::error('reCAPTCHA secret key missing');
            return back()->withErrors(['g-recaptcha-response' => 'reCAPTCHA configuration error.']);
        }
        
        try {
            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => $secretKey,
                'response' => $recaptchaResponse,
                'remoteip' => $request->ip(),
            ])->json();
            
            if (!$response['success']) {
                Log::warning('reCAPTCHA verification failed', [
                    'errors' => $response['error-codes'] ?? [],
                    'hostname' => $response['hostname'] ?? null
                ]);
                return back()->withErrors(['g-recaptcha-response' => 'reCAPTCHA verification failed: ' . implode(', ', $response['error-codes'] ?? ['Unknown error'])]);
            }
        } catch (\Exception $e) {
            Log::error('reCAPTCHA verification error', ['error' => $e->getMessage()]);
            return back()->withErrors(['g-recaptcha-response' => 'Error verifying reCAPTCHA: ' . $e->getMessage()]);
        }
        
        Log::info('reCAPTCHA verification passed');
        
        $user = Signup::where('email', $request->email)->first();
        
        if (!$user || !Hash::check($request->password, $user->password)) {
            Log::warning('Invalid credentials', ['email' => $request->email]);
            return back()->withErrors(['login_error' => 'Invalid credentials. Please try again.']);
        }
        
        Log::info('User authenticated', ['user_id' => $user->id]);
        
        Auth::guard('signup')->login($user);
        Log::info('User logged in via signup guard', [
            'user_id' => $user->id,
            'auth_check' => Auth::guard('signup')->check(),
            'session_id' => session()->getId()
        ]);
        
        Log::info('Redirecting to dashboard', ['route' => route('dashboard')]);
        return redirect()->route('dashboard')->with('success', 'You have been logged in.');
    }
    
    public function logout()
    {
        $user = Auth::guard('signup')->user();
        Auth::guard('signup')->logout();
        
        Log::info('User logged out', ['user_id' => $user ? $user->id : null]);
        return redirect()->route('login')->with('success', 'You have been logged out.');
    }
}