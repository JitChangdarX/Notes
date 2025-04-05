<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\PageVisit;
use Jenssegers\Agent\Agent;
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TrackVisits
{
    public function handle(Request $request, Closure $next)
    {
        $ip = $request->ip();
        $location = Location::get($ip);
        $agent = new Agent();

        // Log IP and Location data for debugging
        Log::info("IP Address: $ip");
        Log::info("Location Data: ", (array) $location);

        $data = [
            'user_id'    => Auth::check() ? Auth::id() : null,
            'ip_address' => $ip,
            'user_agent' => $request->header('User-Agent'),
            'url'        => $request->fullUrl(),
            'referrer'   => $request->headers->get('referer') ?? 'Direct Visit',
            'browser'    => $agent->browser(),
            'device_type'=> $agent->isMobile() ? 'Mobile' : ($agent->isTablet() ? 'Tablet' : 'Desktop'),
        ];

        // Add location-based fields if available
        if ($location) {
            $data['country'] = $location->countryName ?? null;
            $data['country_code'] = $location->countryCode ?? null;
            $data['region'] = $location->regionName ?? null;
            $data['city'] = $location->cityName ?? null;
            $data['zip_code'] = $location->zipCode ?? null;
            $data['latitude'] = $location->latitude ?? null;
            $data['longitude'] = $location->longitude ?? null;
        }

        // Log the final data array before inserting into the database
        Log::info("PageVisit Data to Insert: ", $data);

        // Try inserting data and catch errors
        try {
            PageVisit::create($data);
            Log::info("PageVisit data saved successfully!");
        } catch (\Exception $e) {
            Log::error("Error saving PageVisit data: " . $e->getMessage());
        }

        return $next($request);
    }
}
