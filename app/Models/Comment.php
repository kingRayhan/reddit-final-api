<?php

namespace App\Models;

use App\NestableComment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory, NestableComment;

    protected $fillable = ['text', 'user_id', 'parent_id'];

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

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
            'voteable_type' => 'App\\Models\\Comment',
            'voteable_id' => $thread_id,
            'type' => 'UP'
        ]);
    }

    public static function createDownVote($thread_id)
    {
        return Vote::create([
            'user_id' => auth()->id(),
            'voteable_type' => 'App\\Models\\Comment',
            'voteable_id' => $thread_id,
            'type' => 'DOWN'
        ]);
    }

    public static function firstVoteByCurrentUser($thread_id)
    {
        return auth()->user()
            ->votes()
            ->where('voteable_type', 'App\\Models\\Comment')
            ->where('voteable_id', $thread_id)->first();
    }
}
