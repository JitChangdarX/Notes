<?php

namespace App\Http\Controllers;

use App\Models\PageVisit;
use Illuminate\Http\Request;

class PageVisitController extends Controller
{
    public function index()
    {
        // Fetch the page visits (or use pagination for large data)
        $pageVisits = PageVisit::latest()->get();

        return view('page-visits', compact('pageVisits'));
    }

    public function store(Request $request)
    {
        // Debugging: Check if request data is coming correctly
        dd($request->all());

        PageVisit::create([
            'user_id' => auth()->id(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
            'url' => $request->url,
            'referrer' => $request->referrer,
            'browser' => $request->browser,
            'device_type' => $request->device_type,
            'country' => $request->country,
            'country_code' => $request->country_code,
            'region' => $request->region,
            'city' => $request->city,
            'zip_code' => $request->zip_code,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'state_name' => $request->state_name,
            'timezone' => $request->timezone
        ]);

        return response()->json(['message' => 'Page visit recorded successfully!']);
    }
}
