<?php

namespace App\Http\Controllers;

use App\Models\Thread;

class CommentController extends Controller
{
    public function allComments()
    {
        if (!request()->query('thread_id'))
            abort('403', 'Thread id is not provided');
        $thread = Thread::findOrFail(request()->query('thread_id'));

        $page = request()->query('page', 1);
        $limit = request()->query('limit', 10);
        
        return $thread->nestedComments($page, $limit);
    }
}
