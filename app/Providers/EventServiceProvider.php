<?php

namespace App\Providers;

use App\Events\User\UserCreated;
use App\Listeners\SendVerificationNotification;
use App\Listeners\User\SendRegistrationMessage;
use App\Listeners\UserCreatedListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendVerificationNotification::class,
        ],
        UserCreated::class => [
            SendRegistrationMessage::class,
            UserCreatedListener::class, 
        ],
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
