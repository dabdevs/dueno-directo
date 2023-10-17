<?php

namespace App\Providers;

use App\Events\Property\PropertyPublishedEvent;
use App\Events\User\UserCreatedEvent;
use App\Listeners\Property\PropertyPublishedListener;
use App\Listeners\User\UserCreatedListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        UserCreatedEvent::class => [
            UserCreatedListener::class,
        ],
        PropertyPublishedEvent::class => [
            PropertyPublishedListener::class
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
