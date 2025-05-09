<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function ContactAction(Request $request)
    {
        Log::info('Contact form submission started.', [
            'ip' => $request->ip(),
            'email' => $request->input('email', 'not provided'),
            'data' => $request->all(),
        ]);

        // Rate limit
        $key = 'contact-submit:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            Log::warning('Rate limit exceeded for IP: ' . $request->ip());
            return response()->json(['error' => 'Too many submissions. Please try again later.'], 429);
        }
        RateLimiter::hit($key, 60);

        // Validate input
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'message' => 'required|string|max:1000',
            ], [
                'name.required' => 'Name is required.',
                'email.required' => 'Email is required.',
                'email.email' => 'Please enter a valid email address.',
                'message.required' => 'Message cannot be empty.',
            ]);
            Log::debug('Validation passed.', ['validated' => $validated]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed: ' . $e->getMessage(), ['errors' => $e->errors()]);
            return response()->json(['error' => 'Validation failed: ' . implode(', ', $e->errors())], 422);
        }

        try {
            // Test database connection
            Log::debug('Testing database connection...');
            \DB::connection()->getPdo();
            Log::debug('Database connection successful.');

            // Store in database
            Log::debug('Attempting database insertion...');
            Contact::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'message' => $validated['message'],
            ]);
            Log::debug('Database insertion successful.');

            // Send email
            Log::debug('Attempting to send email...');
            Mail::mailer('smtp')->to('jitchangdar@gmail.com')->send(new ContactMail($validated));
            Log::info('Contact email sent successfully from ' . $validated['email']);

            return response()->json(['success' => 'Your message has been sent successfully.']);
        } catch (\Exception $e) {
            Log::error('Contact form processing failed: ' . $e->getMessage(), [
                'exception' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json(['error' => 'Failed to process your message: ' . $e->getMessage()], 500);
        }
    }
}
