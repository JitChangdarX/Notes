<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use App\Models\Signup;

class LoginController extends Controller
{
    public function login()
    {
        \Log::info('Login page accessed. Session success: ' . session('success', 'none'));
        return view('login');
    }

    public function loginactions(Request $request)
{
    \Log::info('Login attempt', $request->except(['password'])); // Avoid logging password

    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = Signup::where('email', $request->email)->first();

    if (!$user) {
        // Check if any user exists with this password (just for logic, not recommended in real apps)
        $checkPassword = Signup::whereRaw('1=1')->get()->filter(function ($u) use ($request) {
            return Hash::check($request->password, $u->password);
        })->isNotEmpty();

        if ($checkPassword) {
            return back()->withErrors(['email' => 'Email was wrong.']);
        } else {
            return redirect()->route('signup')->with('error', 'Both  sign up First.');
        }
    }

    if (!Hash::check($request->password, $user->password)) {
        return back()->withErrors(['password' => 'Password is incorrect.']);
    }

    // Already online check
    if ($user->online_user == 1) {
        \Log::warning('User already online', ['email' => $request->email, 'user_id' => $user->id]);
        return back()->withErrors(['login_error' => 'You are already logged in from another device.']);
    }

    // Log user in
    Auth::guard('signup')->login($user, $request->has('remember'));

    // Update user status
    try {
        $newToken = Str::random(60);
        $updated = $user->update([
            'remember_token' => $newToken,
            'online_user' => 1,
        ]);

        if (!$updated) {
            \Log::error('Failed to update user fields', ['user_id' => $user->id]);
            return back()->withErrors(['login_error' => 'Failed to update user status.']);
        }
    } catch (\Exception $e) {
        \Log::error('Exception during user update', [
            'user_id' => $user->id,
            'error' => $e->getMessage(),
        ]);
        return back()->withErrors(['login_error' => 'An error occurred during login.']);
    }

    Session::put('user_id', Auth::guard('signup')->id());
    Session::save();

    \Log::info('Session saved', ['session' => Session::all()]);

    return redirect()->route('dashboard');
}


}