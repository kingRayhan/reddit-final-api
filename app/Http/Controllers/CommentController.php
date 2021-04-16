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

        return $thread->nestedComments();
//        return CommentList::collection($thread->nestedComments());
    }
}
