<?php

namespace App\Http\Controllers;

use App\Http\Requests\NotificationPreviewRequest;
use App\Http\Resources\CommentResource;
use App\Http\Resources\Thread\ThreadList;
use App\Models\Comment;
use App\Models\Thread;
use Illuminate\Http\Request;

class NotificationPreviewController extends Controller
{
    public function preview(NotificationPreviewRequest $request)
    {
        if ($request->type == 'thread')
        {
            return new ThreadList(Thread::findOrFail($request->resource_id));
        }

        if ($request->type == 'comment')
        {
            return new CommentResource(Comment::findOrFail($request->resource_id));
        }
    }
}
