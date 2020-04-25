<?php

namespace App\Listeners;

use App\Events\Subscribed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendSubscriptionEmailVerificationNotification
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
     * @param  Subscribed  $event
     * @return void
     */
    public function handle(Subscribed $event)
    {
        //
    }
}
