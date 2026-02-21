<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;

class AdminCommentController extends Controller
{
    /**
     * Display all comments for moderation.
     */
    public function index()
    {
        // Fetch all comments with user and devotion relations, newest first
        $comments = Comment::with(['user', 'devotion'])->orderBy('id', 'desc')->get();

        // Pass to Blade view
        return view('admin.comments.index', compact('comments'));
    }

    /**
     * Store or update admin response for a comment.
     */
    public function respond(Request $request, $id)
    {
        $request->validate([
            'admin_response' => 'required|string|max:1000',
        ]);

        $comment = Comment::findOrFail($id);
        $comment->admin_response = $request->admin_response;
        $comment->save();

        return redirect()->route('admin.comments.index')
                         ->with('success', 'Response saved successfully!');
    }

    /**
     * Delete a comment.
     */
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return redirect()->route('admin.comments.index')
                         ->with('success', 'Comment deleted successfully!');
    }
}