<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

class logoutcontroller extends Controller
{
    public function logout(Request $request) {
        Auth::logout(); // Logout the user
        
        // Clear session data completely
        Session::flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
        // Redirect to login page with a message
        return redirect('/login')->with('message', 'Logged out successfully');
    }
}
