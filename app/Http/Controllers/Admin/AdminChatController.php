<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChatMessage;

class AdminChatController extends Controller
{
    // Display paginated chat messages
    public function index()
    {
        // Use paginate to enable links() and firstItem()
        $chats = ChatMessage::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.chat.index', compact('chats'));
    }

    // Handle admin reply to a chat message
    public function reply(Request $request, $id)
    {
        $request->validate([
            'admin_reply' => 'required|string|max:1000',
        ]);

        $chat = ChatMessage::findOrFail($id);
        $chat->admin_reply = $request->admin_reply;
        $chat->save();

        return redirect()->route('admin.chat.index')->with('success', 'Reply sent successfully!');
    }

    // Delete a chat message
    public function delete($id)
    {
        $chat = ChatMessage::findOrFail($id);
        $chat->delete();

        return redirect()->route('admin.chat.index')->with('success', 'Chat message deleted.');
    }
}