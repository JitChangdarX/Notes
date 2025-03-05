<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class logoutcontroller extends Controller
{
    public function logout(Request $request)
    {
        Session::forget('user_id'); // Remove user session
        Session::flush(); // Clear all session data
    
        return redirect('/login')->with('success', 'You have been logged out.');
    }
}
