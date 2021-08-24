<?php

namespace App\Listeners;

use App\Models\Thread;
use App\Models\Vote;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpVoteMyOwnThread
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
            'voteable_type' => 'App\\Models\\Thread',
            'voteable_id' => $event->thread->id,
            'type' => 'UP'
        ]);
    }
}
