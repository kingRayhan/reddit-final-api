<?php

namespace App\Http\Resources\Thread;

use App\Http\Resources\UserResource;
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
//        parent::toArray($request),
        return [
            'id' => $this->id,
            "title" => $this->title,
            'slug' => $this->slug,
            'link' => $this->link,
            'image' => $this->image,
            'text' => $this->text,
            'type' => $this->type,
            'user' => new UserResource($this->user),
            'time' => $this->created_at->diffForHumans(),
            'upVotedBy' => $this->upVotedBy(),
            'downVotedBy' => $this->downVotedBy(),
            'voteScores' => $this->upVotedBy()->count() - $this->downVotedBy()->count(),
            'comments_count' => $this->comments()->count()
        ];
    }
}
