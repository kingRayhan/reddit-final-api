<?php

namespace App\Events;

use App\Models\Comment;
use App\Models\Thread;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VoteUpdated implements ShouldQueue, ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $votable_models = [
        'thread' => Thread::class,
        'comment' => Comment::class
    ];

    private $resource_type;
    private $resource_id;
    private $actor_id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($resource_type, $resource_id, $actor_id)
    {
        $this->resource_type = $resource_type;
        $this->resource_id = $resource_id;
        $this->actor_id = $actor_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel("votes.$this->resource_type.$this->resource_id");
    }

    public function broadcastWith()
    {
        return [
            "voteScores" => $this->votable_models[$this->resource_type]::find($this->resource_id)->voteScores(),
            "actor_id" => $this->actor_id
        ];
    }
}
