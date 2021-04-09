<?php

namespace App\Http\Resources\Thread;

use Illuminate\Http\Resources\Json\JsonResource;

class ThreadList extends JsonResource
{

    public function upVotedBy()
    {
        return $this->votes->where('type', 'UP')->pluck('user_id');
    }

    public function downVotedBy()
    {
        return $this->votes->where('type', 'DOWN')->pluck('user_id');
    }

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
            'upVotedBy' => $this->upVotedBy(),
            'downVotedBy' => $this->downVotedBy(),
            'voteScores' => $this->upVotedBy()->count() - $this->downVotedBy()->count()
        ]);
    }
}
