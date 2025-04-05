<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class LogoutController extends Controller
{
    public function logout(Request $request) {
        $userId = Session::get('user_id');

        if ($userId) {
            // ✅ Set `online_user = 0` on logout
            DB::table('signup_account')->where('id', $userId)->update([
                'remember_token' => null,
                'online_user' => 0
            ]);
        }

        // ✅ Log the user out properly
        if (Auth::check()) {
            Auth::logout();
        }

        // ✅ Destroy session
        Session::flush();
        Session::regenerate();

        return redirect('/login')->with('success', 'Logged out successfully.');
    }
}
