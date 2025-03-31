<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class CookieController extends Controller
{
    
    public function acceptCookies(Request $request)
    {
        
        Cookie::queue('user_accepted_cookies', 'true', 60 * 24 * 30);
    
        return response()->json([
            'message' => 'Cookie preferences saved',
            'cookie_value' => Cookie::get('user_accepted_cookies') // Check if it's set
        ]);
    }

    public function getCookies()
    {
        $cookieValue = Cookie::get('user_accepted_cookies');
        return response()->json(['user_accepted_cookies' => $cookieValue]);
    }

    public function deleteCookies()
    {
        Cookie::queue(Cookie::forget('user_accepted_cookies'));

        return response()->json(['message' => 'Cookie deleted']);
    }
}
