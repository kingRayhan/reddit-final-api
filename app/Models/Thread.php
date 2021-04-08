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

    public function upVotedBy()
    {
        $votes = $this->votes()->where('type', 'UP')->get();
        return $votes->map(function ($vote) {
            return $vote->user_id;
        });
    }

    public function downVotedBy()
    {
        $votes = $this->votes()->where('type', 'DOWN')->get();
        return $votes->map(function ($vote) {
            return $vote->user_id;
        });
    }

    public function getVoteCountAttribute()
    {
        $upVoteCount = $this->votes->where('type', 'UP')->count();
        $downVoteCount = $this->votes->where('type', 'DOWN')->count();
        return $upVoteCount - $downVoteCount;
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
