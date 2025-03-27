<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class GoogleController extends Controller
{
    /**
     * Redirect the user to Google's authentication page.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle the callback from Google authentication.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            Log::info('Google User Data', [
                'name'      => $googleUser->getName(),
                'email'     => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'avatar'    => $googleUser->getAvatar(),
            ]);
            dd($googleUser);
            // 🔹 Check if user already exists in database
            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                // 🔹 Create new user if not exists
                $user = User::create([
                    'name'      => $googleUser->getName(),
                    'email'     => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password'  => bcrypt(uniqid()), // Generate random password for security
                    'avatar'    => $googleUser->getAvatar(),
                ]);

                Log::info('✅ New Google user created.');
            } else {
                // 🔹 Update Google avatar if missing
                if (!$user->avatar) {
                    $user->update(['avatar' => $googleUser->getAvatar()]);
                }

                // 🔹 Ensure Google ID is updated for existing users
                if (!$user->google_id) {
                    $user->update(['google_id' => $googleUser->getId()]);
                }

                Log::info('✅ Existing Google user logged in.');
            }

            // 🔹 Log in the user
            Auth::login($user);

            // 🔹 Encrypt user ID before redirecting
            $encryptedId = encrypt($user->id);

            // 🔹 Redirect to dashboard with encrypted ID
            return redirect()->route('dashboard', ['encryptedId' => $encryptedId])
                             ->with('success', 'Logged in successfully with Google.');

        } catch (\Exception $e) {
            Log::error('❌ Google Sign-In Error: ' . $e->getMessage());
            return redirect('/signup')->with('error', 'Google Sign-In failed.');
        }
    }

    /**
     * Logout user from the application.
     */
    public function logout()
    {
        Auth::logout();
        return redirect('/')->with('success', 'You have been logged out.');
    }



}
