<?php

namespace App\Models;

use App\Contracts\VoteableModelTraits;
use App\NestableComment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Thread extends Model
{
    use HasFactory, NestableComment, VoteableModelTraits;

    protected $guarded = ['id'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($thread) {
            $thread->slug = Str::slug($thread->title) . '-' . Str::random(6);
        });
    }
}
