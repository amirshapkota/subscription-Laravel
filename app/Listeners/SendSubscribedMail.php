<?php

namespace App\Listeners;

use App\Events\SubscribedEvent;
use App\Mail\UserSubscribedMessage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendSubscribedMail implements ShouldQueue
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
    public function handle(SubscribedEvent $event)
    {
    
        Mail::to($event->user->email)->send(new UserSubscribedMessage($event->user, $event->website));

    }
}
