<?php

namespace App\Providers;

use App\Events\NewCommentCreated;
use App\Events\NewThreadCreated;
use App\Listeners\BroadcastNewThread;
use App\Listeners\SendCommentNotification;
use App\Listeners\SendVoteNotification;
use App\Listeners\UpVoteMyOwnComment;
use App\Listeners\UpVoteMyOwnThread;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        NewThreadCreated::class => [
            UpVoteMyOwnThread::class,
            BroadcastNewThread::class
        ],
        NewCommentCreated::class => [
            UpVoteMyOwnComment::class,
            SendVoteNotification::class,
            SendCommentNotification::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
