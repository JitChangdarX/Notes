<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function verifyTurnstile(Request $request)
    {
        $response = Http::asForm()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
            'secret' => env('TURNSTILE_SECRET_KEY'),
            'response' => $request->input('cf-turnstile-response'),
            'remoteip' => $request->ip(),
        ]);

        $data = $response->json();

        if (!$data['success']) {
            return back()->withErrors(['turnstile' => 'Verification failed. Try again!']);
        }

        return redirect()->route('home')->with('success', 'Verified!');
    }
}

