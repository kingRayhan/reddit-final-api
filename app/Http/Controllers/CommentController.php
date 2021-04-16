<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Pagination\LengthAwarePaginator;

class CommentController extends Controller
{
    public function allComments()
    {
        $page = request()->query('page', 1);
        $limit = request()->query('limit', 10);
        $thread_id = request()->query('thread_id');

        if (!$thread_id)
            abort('403', 'Thread id is not provided');

        $comments = Comment::nestedComments($thread_id, $page, $limit);
        $count = Comment::where('thread_id', $thread_id)->whereNull('parent_id')->count();
        
        return new LengthAwarePaginator($comments, $count, $limit, $page);
    }
}
