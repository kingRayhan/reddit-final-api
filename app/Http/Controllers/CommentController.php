<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comment\StoreCommentRequest;
use App\Http\Requests\Comment\UpdateCommentRequest;
use App\Models\Comment;
use App\Models\Thread;
use Illuminate\Pagination\LengthAwarePaginator;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except('index');
    }
    public function index(Thread $thread)
    {
        $page = request()->query('page', 1);
        $limit = request()->query('limit', 10);

        $comments = Comment::nestedComments($thread->id, $page, $limit);
        $count = Comment::where('thread_id', $thread->id)->whereNull('parent_id')->count();

        return new LengthAwarePaginator($comments, $count, $limit, $page);
    }

    public function store(StoreCommentRequest $request, Thread $thread)
    {
        return $thread->comments()->create(
            array_merge(
                $request->all(),
                [
                    'user_id' => auth()->id(),
                    'parent_id' => $request->query('reply_to')
                ]
            )
        );
    }

    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $comment->update($request->all());
        return response()->json([
            'message' => 'Updated successfully',
            'data' => $comment
        ]);
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();
        return response()->json([
            'message' => 'Deleted successfully'
        ]);
    }
}
