<?php

namespace App\Listeners;

use App\Models\Comment;
use App\Notifications\CommentNotification;
use App\Notifications\ReplyNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendCommentNotification
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
     * @param object $event
     * @return void
     */
    public function handle($event)
    {
        $comment = $event->comment;

        if ($comment->parent_id) {
            // it's a reply
            if ($comment->thread->user->id != auth()->id()) {

                $comment->thread->user->notify(new CommentNotification($comment));

                $parentComment = Comment::find($comment->parent_id);
                $parentComment->user->notify(new ReplyNotification($comment));
            }
        } else {
            // it's immediate reply
            if ($comment->thread->user->id != auth()->id()) {
                $comment->thread->user->notify(new CommentNotification($comment));
            }// TODO: make better
        }
    }
}
