<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class GoogleController extends Controller
{
    /**
     * Redirect to Google
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google Callback
     */
    public function handleGoogleCallback()
    {
        try {
            // Get user details from Google
            $googleUser = Socialite::driver('google')->user();

            // Log Google User Data
            \Log::info('Google User Data', [
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
            ]);

            // Check if user already exists
            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                // Create a new user
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password' => bcrypt(uniqid()), // Generate a random password
                ]);

                \Log::info('User created successfully!');
            } else {
                \Log::info('User already exists.');
            }

            // Log the user in
            Auth::login($user);

            // Redirect to dashboard
            return redirect()->route('dashboard')->with('success', 'Logged in successfully with Google');

        } catch (\Exception $e) {
            \Log::error('Google Sign-In Error: ' . $e->getMessage());
            return redirect('/signup')->with('error', 'Google Sign-In failed.');
        }
    }
}
