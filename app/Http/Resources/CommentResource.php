<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'text' => $this->text,
            'user' => new UserResource($this->user),
            'replies' => CommentResource::collection($this->replies),
            'upVotedBy' => $this->upVotedBy(),
            'downVotedBy' => $this->downVotedBy(),
            'voteScores' => $this->voteScores(),
            'created_at' => $this->created_at
        ];
    }
}
