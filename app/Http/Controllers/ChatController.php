<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {
        
        // Validate incoming request
        $request->validate([
            'content' => 'required|string|max:1000', // Limit input length for safety
        ]);

        // Get API key from .env
        $apiKey = env('GROK_GPT_KEY');
        if (!$apiKey) {
            Log::error('GROK_GPT_KEY is not set in .env');
            return response()->json(['error' => 'Server configuration error'], 500);
        }

        try {
            // Send request to xAI API
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => "Bearer $apiKey",
            ])->timeout(30)->post('https://api.x.ai/v1/chat/completions', [
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are Grok, a helpful AI assistant created by xAI.',
                    ],
                    [
                        'role' => 'user',
                        'content' => $request->content,
                    ],
                ],
                'model' => 'grok-3-latest',
                'stream' => false,
                'temperature' => 0,
            ]);

            // Check if response is successful
            if ($response->successful()) {
                $data = $response->json();
                // Verify response structure
                if (isset($data['choices'][0]['message']['content'])) {
                    return $data['choices'][0]['message']['content'];
                }
                Log::error('Unexpected xAI API response structure', ['response' => $data]);
                return response()->json(['error' => 'Invalid response from Grok AI'], 500);
            }

            // Log error details
            Log::error('xAI API Error', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            return response()->json([
                'error' => $response->json()['error']['message'] ?? 'Failed to communicate with Grok AI',
            ], $response->status());

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('xAI API Connection Error', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Network error connecting to Grok AI'], 503);
        } catch (\Exception $e) {
            Log::error('ChatController Error', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Server error: ' . $e->getMessage()], 500);
        }
    }
}