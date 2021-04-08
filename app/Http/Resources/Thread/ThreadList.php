<?php

namespace App\Http\Resources\Thread;

use Illuminate\Http\Resources\Json\JsonResource;

class ThreadList extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return array_merge(parent::toArray($request), [
            'user' => $this->user,
            'time' => $this->created_at->diffForHumans(),
            'upvotedBy' => $this->upVotedBy(),
//            'downVotedBy' => $this->downVotedBy(),
            'votes' => $this->votes
        ]);
    }
}
