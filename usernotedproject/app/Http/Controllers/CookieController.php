<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class CookieController extends Controller
{
    // ✅ 1. Accept Cookies (Set Cookie for 30 Days)
    public function acceptCookies(Request $request)
    {
        // Store the cookie for 30 days (60 minutes * 24 hours * 30 days)
        Cookie::queue('user_accepted_cookies', 'true', 60 * 24 * 30);
    
        return response()->json([
            'message' => 'Cookie preferences saved',
            'cookie_value' => Cookie::get('user_accepted_cookies') // Check if it's set
        ]);
    }

    // ✅ 2. Get Cookies (Check if the user accepted cookies)
    public function getCookies()
    {
        $cookieValue = Cookie::get('user_accepted_cookies');
        return response()->json(['user_accepted_cookies' => $cookieValue]);
    }

    // ✅ 3. Delete Cookies (For Logout or Reset)
    public function deleteCookies()
    {
        Cookie::queue(Cookie::forget('user_accepted_cookies'));

        return response()->json(['message' => 'Cookie deleted']);
    }
}
