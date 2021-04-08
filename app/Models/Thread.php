<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Thread extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function votes()
    {
        return $this->morphMany(Vote::class, 'voteable');
    }

    public static function createUpVote($thread_id)
    {
        return Vote::create([
            'user_id' => auth()->id(),
            'voteable_type' => 'App/Models/Thread',
            'voteable_id' => $thread_id,
            'type' => 'UP'
        ]);
    }

    public static function createDownVote($thread_id)
    {
        return Vote::create([
            'user_id' => auth()->id(),
            'voteable_type' => 'App/Models/Thread',
            'voteable_id' => $thread_id,
            'type' => 'DOWN'
        ]);
    }

    public static function firstVoteByCurrentUser($thread_id)
    {
        return auth()->user()
            ->votes()
            ->where('voteable_type', 'App/Models/Thread')
            ->where('voteable_id', $thread_id)->first();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($thread) {
            $thread->slug = Str::slug($thread->title) . '-' . Str::random(6);
        });
    }
}
