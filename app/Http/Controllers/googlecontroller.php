<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\GoogleUser;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Models\Signup;
use Illuminate\Support\Facades\Session;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        try {
            return Socialite::driver('google')
                ->scopes(['profile', 'email'])
                ->redirect();
        } catch (\Exception $e) {
            Log::error('Google Redirect Error: ' . $e->getMessage());
            return redirect()->route('logins')->with('error', 'Failed to redirect to Google: ' . $e->getMessage());
        }
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            if (!$googleUser) {
                Log::error('Google authentication failed: No user data received.');
                return redirect()->route('logins')->with('error', 'Google login failed: No user data.');
            }

            Log::info('Google User Data:', [
                'name'      => $googleUser->getName(),
                'email'     => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'avatar'    => $googleUser->getAvatar(),
            ]);

            $user = GoogleUser::where('google_id', $googleUser->getId())
                            ->orWhere('email', $googleUser->getEmail())
                            ->first();

            if ($user) {
                if (!$user->google_id) {
                    $user->update(['google_id' => $googleUser->getId()]);
                }
            } else {
                $avatarPath = null;
                try {
                    $avatarUrl = $googleUser->getAvatar();
                    // Avatar processing code...
                    // (keeping it for brevity)
                    if ($avatarUrl && filter_var($avatarUrl, FILTER_VALIDATE_URL)) {
                        $avatarUrl = strpos($avatarUrl, '?') === false ? $avatarUrl . '?sz=150' : $avatarUrl . '&sz=150';
                        $avatarName = 'avatars/' . Str::random(40) . '.jpg';
                        $response = Http::timeout(15)->get($avatarUrl);
                        if ($response->successful() && strpos($response->header('Content-Type'), 'image/') === 0) {
                            $imageContent = $response->body();
                            if (strlen($imageContent) > 1000) {
                                if (Storage::disk('public')->put($avatarName, $imageContent)) {
                                    if (Storage::disk('public')->exists($avatarName)) {
                                        $avatarPath = $avatarName;
                                    }
                                }
                            }
                        }
                    }
                } catch (\Exception $e) {
                    Log::error('Avatar processing error: ' . $e->getMessage());
                }

                $user = GoogleUser::create([
                    'name'      => $googleUser->getName(),
                    'email'     => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar'    => $avatarPath,
                ]);
                
                // Also create entry in signup_account if using that table for user management
                $signupUser = DB::table('signup_account')->where('email', $googleUser->getEmail())->first();
                if (!$signupUser) {
                    DB::table('signup_account')->insert([
                        'name' => $googleUser->getName(),
                        'email' => $googleUser->getEmail(),
                        'auth_type' => 'google',
                        'online_user' => 1,
                        'email_verified_at' => now(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            // Store user ID in session
            Session::put('user_id', $user->id);
            Session::put('auth_type', 'google');
            
            // Login the user
            Auth::guard('web')->login($user, true);
            
            // Redirect to user dashboard (different route to avoid infinite loop)
            return redirect()->to('/user-dashboard')->with('success', 'Logged in successfully with Google.');

        } catch (\Exception $e) {
            Log::error('❌ Google Sign-In Error: ' . $e->getMessage());
            return redirect()->route('logins')->with('error', 'Google Sign-In failed: ' . $e->getMessage());
        }
        
    }

    public function logout(Request $request)
    {
        $userId = Auth::id(); // Get the currently logged-in user's ID
    
        if ($userId) {
            // Set online_user to 0 before logout
            DB::table('signup_account')->where('id', $userId)->update([
                'online_user' => 0,
                'remember_token' => null,
                'updated_at' => now()
            ]);
        }
    
        Auth::guard('web')->logout(); // Logout the user
        Session::forget('user_id'); // Clear session
        Session::forget('auth_type');
        
        $request->session()->invalidate(); // Invalidate the session
        $request->session()->regenerateToken(); // Regenerate CSRF token
    
        return redirect()->route('logins')->with('success', 'You have been logged out.');
    }
}