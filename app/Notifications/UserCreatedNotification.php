<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UserCreatedNotification extends Notification
{
    protected $user;
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database', 'broadcast'];
        $channels = ['database'];

        if ($notifiable->notification_list['user_created']['sms'] ?? false) {
            $channels[] = 'vonage';
        }
        if ($notifiable->notification_list['user_created']['mail'] ?? false) {
            $channels[] = 'mail';
        }
        if ($notifiable->notification_list['user_created']['broadcast'] ?? false) {
            $channels[] = 'broadcast';
        }
        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        if ($notifiable->stores) {
            return (new MailMessage)
                ->subject("a new merchant is registered.")
                ->greeting("Hello {$this->user->hasAnyRole('Owner')}")
                ->line("A new user has registered ({$notifiable->name})")
                ->action('View the new user', url('/dashboard'))
                ->line('Do what you have to do!');
            // ->view(); // this line is for using a custom template if you want and here is the normal function view to use this custom template and path any data throw it as usual.
        }
    }

    // public function toDatabase($notifiable)
    // {
    //     $addr = $this->order->billingAddress;
    //     return [
    //         'body' => "A new order has been created (#{$this->order->number}) by " . $addr->first_name . $addr->last_name . " from {$addr->country}",
    //         'icon' => 'fas fa-envelope',
    //         'url' => url('/dashboard'),
    //         'order_id' => $this->order->id,
    //     ];
    // }

    // public function toBroadcast($notifiable)
    // {
    //     $addr = $this->order->billingAddress;
    //     return [
    //         'body' => "A new order has been created (#{$this->order->number}) by " . $addr->first_name . $addr->last_name . " from {$addr->country}",
    //         'icon' => 'fas fa-envelope',
    //         'url' => url('/dashboard'),
    //         'order_id' => $this->order->id,
    //     ];
    // }

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
