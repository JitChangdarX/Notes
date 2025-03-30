<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function showSessions()
    {
        // Fetch all active sessions
        $sessions = DB::table('sessions')->get();

        // Return a view with session data
        return view('index', compact('sessions'));
    }
}
