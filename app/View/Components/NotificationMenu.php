<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class NotificationMenu extends Component
{
    public $notifications;
    public $unreadNotifications;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $user = Auth::user();
        $this->notifications = $user->notifications()->get();
        $this->unreadNotifications = $user->unreadnotifications()->count();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.notification-menu');
    }
}
