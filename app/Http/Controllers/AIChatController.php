<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AIChatController extends Controller
{
    public function chat(Request $request)
    {
        // Validate user input
        $request->validate([
            'message' => 'required|string',
        ]);

        $userMessage = $request->message;

        try {
            // Send request to OpenRouter
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('OPENROUTER_API_KEY'),
                'Content-Type' => 'application/json',
            ])->post('https://openrouter.ai/api/v1/chat/completions', [
                'model' => 'mistralai/mistral-7b-instruct:free',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are a helpful assistant for PAG Kenya Church.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $userMessage
                    ]
                ],
                'temperature' => 0.7,
            ]);

            // Check for valid response
            if ($response->successful() && isset($response['choices'][0]['message']['content'])) {
                $reply = $response['choices'][0]['message']['content'];
            } else {
                $reply = "Sorry, the assistant could not respond at the moment.";
            }
        } catch (\Exception $e) {
            // Catch network errors or unexpected responses
            $reply = "Error: " . $e->getMessage();
        }

        return response()->json(['reply' => $reply]);
    }
}