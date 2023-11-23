<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;
use App\Notifications\OrderCreatedNotifications;
use Illuminate\Support\Facades\Notification;

class SendOrderCreatedNotification
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
    public function handle(OrderCreated $event)
    {
        $order = $event->order;
        $user = User::where('store_id', $order->store_id)->first();
        if ($user) {
            $user->notifyNow(new OrderCreatedNotifications($order));
        }
        return redirect()->route('home')->with('success', 'Order Created Successfully!');

        // this is used when you want to send a multiple notifications for multiple users.
        $users = User::where('store_id', $order->store_id)->get();
        if ($users) {
            Notification::send($users, new OrderCreatedNotifications($order));
        }
        return redirect()->route('home')->with('success', 'Order Created Successfully!');
    }
}
