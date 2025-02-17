<?php

namespace App\Listeners;

use App\Events\TravelOrderStatusUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\TravelOrderStatusChanged;

class SendTravelOrderStatusNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TravelOrderStatusUpdated $event): void
    {
        //
        if (in_array($event->travelOrder->status, ['approved', 'canceled'])) {
            Notification::send($event->travelOrder->user, new TravelOrderStatusChanged($event->travelOrder));
        }
    }
}
