<?php

namespace App\Http\Controllers;

use App\Http\Requests\Vote\VoteRequest;
use App\Models\Thread;

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
            $previousVote = Thread::firstVoteByCurrentUser($request->resource_id);

            if ($previousVote) {
                if ($previousVote->type == 'UP') $previousVote->delete();
                if ($previousVote->type == 'DOWN') {
                    $previousVote->update(['type' => 'UP']);
                }
            } else {
                Thread::createUpVote($request->resource_id);
            }
        }

        return response()->noContent();
    }

    /**
     * Create down vote
     * @param VoteRequest $request
     */
    public function downVote(VoteRequest $request)
    {
        if ($request->resource_type == 'thread') {
            $previousVote = Thread::firstVoteByCurrentUser($request->resource_id);

            if ($previousVote) {
                if ($previousVote->type == 'DOWN') $previousVote->delete();
                if ($previousVote->type == 'UP') {
                    $previousVote->update(['type' => 'DOWN']);
                }
            } else {
                Thread::createDownVote($request->resource_id);
            }
        }
        return response()->noContent();
    }
}
