<?php

namespace App\Listeners\User;

use App\Events\User\UserCreatedEvent;
use App\Mail\WelcomeEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class UserCreatedListener
{
    use InteractsWithQueue;

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
     * @param  \App\Events\UserCreatedEvent  $event
     * @return void
     */
    public function handle(UserCreatedEvent $event)
    {
        $user = $event->user; 

        // Dispatch the WelcomeEmail Mailable to the queue
        Mail::to($user->email)->queue(new WelcomeEmail($user));
    }
}
