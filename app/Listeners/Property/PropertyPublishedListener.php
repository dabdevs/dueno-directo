<?php

namespace App\Listeners\Property;

use App\Events\PropertyPublishedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PropertyPublishedListener
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
     * @param  \App\Events\PropertyPublishedEvent  $event
     * @return void
     */
    public function handle(PropertyPublishedEvent $event)
    {
        //
    }
}
