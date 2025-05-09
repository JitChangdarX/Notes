<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class logoutController extends Controller
{
    /**
     * Handle user logout (for POST /logout).
     */
    public function logout(Request $request)
    {
        try {
            // Ensure JSON response
            $request->headers->set('Accept', 'application/json');

            // Log out the user
            Auth::logout();

            // Invalidate session and regenerate CSRF token
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return response()->json([
                'success' => true,
                'message' => 'Logged out successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to log out: ' . $e->getMessage()
            ], 500);
        }
    }
}