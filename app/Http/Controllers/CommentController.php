<?php

namespace App\Http\Controllers;

use App\Models\Comment;

class CommentController extends Controller
{
    public function allComments()
    {
        $page = request()->query('page', 1);
        $limit = request()->query('limit', 10);
        $thread_id = request()->query('thread_id');

        if (!$thread_id)
            abort('403', 'Thread id is not provided');

        return Comment::nestedComments($thread_id, $page, $limit);
    }
}
