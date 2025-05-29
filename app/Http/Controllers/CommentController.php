<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CommentController extends Controller
{
    use AuthorizesRequests;
    public function store(Request $request, $taskId)
    {
        $request->validate(['content' => 'required|string']);

        Comment::create([
            'task_id' => $taskId,
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return redirect()->back()->with('success', 'Comment added.');
    }

    public function edit(Comment $comment)
    {
        return view('comments.edit', compact('comment'));
    }

    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment); // Optional: use policy

        $request->validate(['content' => 'required|string']);
        $comment->update(['content' => $request->content]);

        return redirect()->route('tasks.show', $comment->task_id)->with('success', 'Comment updated.');
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment); // Optional: use policy
        $comment->delete();

        return redirect()->back()->with('success', 'Comment deleted.');
    }
}
