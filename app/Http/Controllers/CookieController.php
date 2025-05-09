<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class CookieController extends Controller
{
    public function acceptCookies(Request $request)
    {
        $minutes = 60 * 24 * 30; // 30 days
        Cookie::queue('user_cookie_consent', 'accepted', $minutes);

        return response()->json(['message' => 'Cookie accepted']);
    }

    public function getCookies(Request $request)
    {
        $cookie = $request->cookie('user_cookie_consent');
        return response()->json(['cookie' => $cookie]);
    }

    public function deleteCookies(Request $request)
    {
        Cookie::queue(Cookie::forget('user_cookie_consent'));
        return response()->json(['message' => 'Cookie deleted']);
    }
}
