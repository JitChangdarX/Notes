<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class DashbordController extends Controller
{

    public function dashbordaction()
{
    $user_id = Session::get('user_id');

    if (!$user_id && auth()->check()) {
        $user_id = auth()->id();
    }

    if (!$user_id) {
        return redirect()->route('logins')->with('error', 'Unauthorized access');
    }

    // Get user from signup_account or google_users based on auth_type
    $user = DB::table('signup_account')->where('id', $user_id)->first();

    if (!$user) {
        abort(404);
    }

    $profilePhoto = null;

    if ($user->auth_type == 'google') {
        // For Google login, fetch user data from google_users table
        $googleUser = DB::table('google_users')->where('email', $user->email)->first();
        $profilePhoto = $googleUser->avatar ? 'storage/' . $googleUser->avatar : 'images/default-profile.png';
    } else {
        // For manual signup, fetch user data from signup_account table
        $profilePhoto = $user->profile_photo ? 'storage/' . $user->profile_photo : 'images/default-profile.png';
    }

    return view('dashbord', compact('user', 'profilePhoto'));
}

}
