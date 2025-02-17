<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\TravelOrderModel;

class TravelOrderStatusChanged extends Notification
{
    use Queueable;

    protected $travelOrder;

    public function __construct(TravelOrderModel $travelOrder)
    {
        $this->travelOrder = $travelOrder;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('Your travel order status has been updated.')
                    ->line('New status: ' . $this->travelOrder->status)
                    ->action('View Travel Order', url('/travel-orders/' . $this->travelOrder->id))
                    ->line('Thank you for using our application!');
    }
}
