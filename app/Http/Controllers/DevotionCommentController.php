<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Devotion;
use App\Models\Comment;

class DevotionCommentController extends Controller
{
    public function store(Request $request, $devotionId)
    {
        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        $devotion = Devotion::findOrFail($devotionId);

        Comment::create([
            'devotion_id' => $devotion->id,
            'user_id' => $request->user()->id,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Comment posted successfully!');
    }
}