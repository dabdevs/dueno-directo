<?php

namespace App\Listeners;

use App\Events\User\UserCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UserCreatedListener
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
     */
    public function handle(UserCreated $event)
    {
        $user = $event->user; 
        $user->assignRole($user->role);
    }
}
