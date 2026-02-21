<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatMessage;

class ChatController extends Controller
{
    // Fetch messages (for real-time updates)
    public function fetch()
    {
        $messages = ChatMessage::orderBy('created_at', 'asc')->get();
        return response()->json($messages);
    }

    // Send new message
    public function send(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'nullable|email',
            'message' => 'required|string',
        ]);

        $chat = ChatMessage::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
        ]);

        return response()->json(['success' => true, 'chat' => $chat]);
    }
}