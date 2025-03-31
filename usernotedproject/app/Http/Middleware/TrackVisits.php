<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\PageVisit;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;

class TrackVisits
{
    public function handle(Request $request, Closure $next)
    {
        $agent = new Agent();

        PageVisit::create([
            'user_id'    => Auth::check() ? Auth::id() : null,
            'ip_address' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
            'url'        => $request->fullUrl(),
            'referrer'   => $request->headers->get('referer') ?? 'Direct Visit',
            'browser'    => $agent->browser(),
            'device_type'=> $agent->isMobile() ? 'Mobile' : ($agent->isTablet() ? 'Tablet' : 'Desktop'),
        ]);

        return $next($request);
    }
}
