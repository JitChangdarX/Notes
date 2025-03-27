<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;

class AuthCheck
{
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has('user_id')) { // ✅ Use session instead of Auth::check()
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        return $next($request);
    }
}
