<?php

namespace App\Http\Controllers;

use App\Http\Requests\Vote\VoteRequest;
use App\Models\Comment;
use App\Models\Thread;
use App\Notifications\VoteNotification;

class VoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Create up vote
     * @param VoteRequest $request
     */
    public function upVote(VoteRequest $request)
    {

        if ($request->resource_type == 'thread') {
            $thread = Thread::find($request->resource_id);

            $previousVote = Thread::firstVoteByCurrentUser($request->resource_id);

            if ($previousVote) {
                if ($previousVote->type == 'UP') $previousVote->delete();
                if ($previousVote->type == 'DOWN') {
                    $previousVote->update(['type' => 'UP']);
                }
            } else {
                Thread::createUpVote($request->resource_id);
                if ($thread->user->id != auth()->id()) {
                    $thread->user->notify(new VoteNotification('up', 'thread', auth()->user(), $thread->title, $request->resource_id));
                }
            }

        }

        if ($request->resource_type == 'comment') {
            $comment = Comment::find($request->resource_id);
            $previousVote = Comment::firstVoteByCurrentUser($request->resource_id);

            if ($previousVote) {
                if ($previousVote->type == 'UP') $previousVote->delete();
                if ($previousVote->type == 'DOWN') {
                    $previousVote->update(['type' => 'UP']);
                }
            } else {
                Comment::createUpVote($request->resource_id);
                if ($comment->user->id != auth()->id()) {
                    $comment->user->notify(new VoteNotification('up', 'comment', auth()->user(), $comment->text, $request->resource_id));
                }
            }

        }

        return response()->noContent();
    }

    /**
     * Create down vote
     * @param VoteRequest $request
     * @return \Illuminate\Http\Response
     */
    public function downVote(VoteRequest $request)
    {
        if ($request->resource_type == 'thread') {
            $thread = Thread::find($request->resource_id);
            $previousVote = Thread::firstVoteByCurrentUser($request->resource_id);

            if ($previousVote) {
                if ($previousVote->type == 'DOWN') $previousVote->delete();
                if ($previousVote->type == 'UP') {
                    $previousVote->update(['type' => 'DOWN']);
                }
            } else {
                Thread::createDownVote($request->resource_id);
                if ($thread->user->id != auth()->id()) {
                    $thread->user->notify(new VoteNotification('down', 'thread', auth()->user(), $thread->title, $request->resource_id));
                }
            }
        }

        if ($request->resource_type == 'comment') {
            $comment = Comment::find($request->resource_id);
            $previousVote = Comment::firstVoteByCurrentUser($request->resource_id);

            if ($previousVote) {
                if ($previousVote->type == 'DOWN') $previousVote->delete();
                if ($previousVote->type == 'UP') {
                    $previousVote->update(['type' => 'DOWN']);
                }
            } else {
                Comment::createDownVote($request->resource_id);
                if ($comment->user->id != auth()->id()) {
                    $comment->user->notify(new VoteNotification('down', 'comment', auth()->user(), $comment->text, $request->resource_id));
                }
            }
        }
        return response()->noContent();
    }
}
