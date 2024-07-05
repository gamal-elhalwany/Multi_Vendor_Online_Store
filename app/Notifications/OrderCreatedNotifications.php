<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCreatedNotifications extends Notification
{
    protected $order;
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database', 'broadcast'];
        $channels = ['database']; // this the default channel which I chose to receive the notifications.

        if ($notifiable->notification_list['order_created']['sms'] ?? false) {
            $channels[] = 'vonage';
        }
        if ($notifiable->notification_list['order_created']['mail'] ?? false) {
            $channels[] = 'mail';
        }
        if ($notifiable->notification_list['order_created']['broadcast'] ?? false) {
            $channels[] = 'broadcast';
        }
        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $addr = $this->order->billingAddress;
        return (new MailMessage)
                    ->subject("New Order #{$this->order->number}")
                    ->greeting("Hello {$notifiable->name}")
                    ->line("A new order has been created (#{$this->order->number}) by " . $addr->first_name . $addr->last_name . " from {$addr->country}")
                    ->action('View Order', url('/dashboard'))
                    ->line('Thank you for using our application!');
                    // ->view(); // this line is for using a custom template if you want and here is the normal function view to use this custom template and path any data throw it as usual.
    }

    public function toDatabase($notifiable)
    {
        $addr = $this->order->billingAddress;
        return [
            'body' => "A new order has been created (#{$this->order->number}) by " . $addr->first_name . $addr->last_name . " from {$addr->country}",
            'icon' => 'fas fa-envelope',
            'url' => url('/dashboard'),
            'order_id' => $this->order->id,
        ];
    }

    public function toBroadcast($notifiable)
    {
        $addr = $this->order->billingAddress;
        return [
            'body' => "A new order has been created (#{$this->order->number}) by " . $addr->first_name . $addr->last_name . " from {$addr->country}",
            'icon' => 'fas fa-envelope',
            'url' => url('/dashboard'),
            'order_id' => $this->order->id,
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
