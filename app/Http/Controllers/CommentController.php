<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Car;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Car $car)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (($car->status !== 'Live' || $car->moderation_status !== 'published') && (!$user || !$user->hasAnyRole(['admin', 'editor']))) {
            abort(403, 'This specimen is currently under classification and not yet public.');
        }

        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $car->comments()->create([
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return back()->with('success', 'Transmission received: Comment deployed to tactical log.');
    }

    public function destroy(Comment $comment)
    {
        if (Auth::id() !== $comment->user_id) {
            abort(403);
        }

        $comment->delete();
        return back()->with('success', 'Transmission terminated: Comment purged.');
    }
}
