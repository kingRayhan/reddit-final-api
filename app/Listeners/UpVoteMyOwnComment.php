<?php

namespace App\Listeners;

use App\Models\Vote;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpVoteMyOwnComment
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        return Vote::create([
            'user_id' => auth()->id(),
            'voteable_type' => 'App\\Models\\Comment',
            'voteable_id' => $event->comment->id,
            'type' => 'UP'
        ]);
    }
}
