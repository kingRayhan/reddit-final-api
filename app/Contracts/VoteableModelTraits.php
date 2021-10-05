<?php

namespace App\Contracts;

use App\Models\Vote;

trait VoteableModelTraits
{
    public function votes()
    {
        return $this->morphMany(Vote::class, 'voteable');
    }

    public function upVotedBy()
    {
        return $this->votes->where('type', 'UP')->pluck('user_id');
    }

    public function downVotedBy()
    {
        return $this->votes->where('type', 'DOWN')->pluck('user_id');
    }


    public static function createUpVote($thread_id)
    {
        return Vote::create([
            'user_id' => auth()->id(),
            'voteable_type' => self::class,
            'voteable_id' => $thread_id,
            'type' => 'UP'
        ]);
    }

    public static function createDownVote($thread_id)
    {
        return Vote::create([
            'user_id' => auth()->id(),
            'voteable_type' => self::class,
            'voteable_id' => $thread_id,
            'type' => 'DOWN'
        ]);
    }

    public static function firstVoteByCurrentUser($thread_id)
    {
        return auth()->user()
            ->votes()
            ->where('voteable_type', self::class)
            ->where('voteable_id', $thread_id)->first();
    }

    public function voteScores()
    {
        return $this->upVotedBy()->count() - $this->downVotedBy()->count();
    }
}
