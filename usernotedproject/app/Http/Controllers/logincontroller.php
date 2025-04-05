<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use App\Models\Signup; 

class LoginController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function loginactions(Request $request)
{
    Log::info('🔹 Login attempt', $request->all());

    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);
    $user = Signup::where('email', $request->email)->first();

    if (!$user) {
        Log::error('User not found: ' . $request->email);
        return back()->withErrors(['email' => 'Invalid email or password.']);
    }

    if (!Hash::check($request->password, $user->password)) {
        Log::error('Password mismatch for user: ' . $request->email);
        return back()->withErrors(['password' => 'Invalid email or password.']);
    }
    if ($user->online_user == 1) {
        Log::warning('User already online: ' . $request->email);
        return back()->withErrors(['login_error' => 'You are already logged in from another device.']);
    }
    
    $remember = $request->has('remember');

    if ($remember) {
        $rememberToken = Str::random(60);

        
        Log::info('🔹 Generated Remember Token: ' . $rememberToken);

     
        $user->remember_token = $rememberToken;

    
        if ($user->save()) {
            Log::info('User with Remember Token saved: ', ['user' => $user]);
        } else {
            Log::error(' Failed to save remember token');
        }
    }


    Auth::guard('web')->login($user, $remember);
    Log::info(' User logged in: ' . $user->email . ($remember ? ' (Remembered)' : ''));


    Session::put('user_id', Auth::id());
    Session::save();

    Log::info(' Session saved:', Session::all());
    $newToken = Str::random(60);
     DB::table('signup_account')->where('id', $user->id)->update([
        'remember_token' => $newToken,
        'online_user' => 1
    ]);
    return redirect()->route('dashboard')->with('success', 'Login successful!');
}
public function logout()
{
    $userId = Auth::id();
    Log::info('🔹 Logging out user: ' . $userId);

    if ($userId) {
        $updated = DB::table('signup_account')->where('id', $userId)->update([
            'remember_token' => null,
            'online_user' => 0
        ]);

        Log::info('🔹 Database Update Status: ' . $updated);
    }

    if (Auth::guard('web')->check()) {
        Auth::guard('web')->logout();
    }

    Session::flush();

    return redirect('/login')->with('success', 'Logged out successfully.');
}

}
