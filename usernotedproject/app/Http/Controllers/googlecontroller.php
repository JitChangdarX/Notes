<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\GoogleUser;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            if (!$googleUser) {
                Log::error('Google authentication failed: No user data received.');
                return redirect('/login')->with('error', 'Google login failed.');
            }

            Log::info('Google User Data:', [
                'name'      => $googleUser->getName(),
                'email'     => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'avatar'    => $googleUser->getAvatar(),
            ]);

            // Check if user exists in google_users table
            $user = GoogleUser::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                // Download and store avatar
                $avatarUrl = $googleUser->getAvatar();
                $avatarName = 'avatars/' . Str::random(40) . '.jpg';
                Storage::put('public/' . $avatarName, Http::get($avatarUrl)->body());

                // Create a new user
                $user = GoogleUser::create([
                    'name'      => $googleUser->getName(),
                    'email'     => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password'  => bcrypt(uniqid()),
                    'avatar'    => $avatarName, // Store avatar path
                ]);

                Log::info('✅ New Google user created.');
            }

            // Log in the user
            Auth::login($user);
            Session::put('user_id', $user->id);
            Session::save();

            Log::info('✅ User logged in successfully.');

            // Redirect to dashboard
            return redirect()->route('dashboard')->with('success', 'Logged in successfully with Google.');

        } catch (\Exception $e) {
            Log::error('❌ Google Sign-In Error: ' . $e->getMessage());
            return redirect('/logins')->with('error', 'Google Sign-In failed.');
        }
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect('/logins')->with('success', 'You have been logged out.');
    }
}