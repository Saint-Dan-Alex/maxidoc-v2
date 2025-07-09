<?php

namespace App\Http\Livewire\Notification;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NotificationIcon extends Component
{
    public $notifications;

    public function render()
    {
        $this->fetchNotif();
        return view('livewire.notification.notification-icon');
    }

    public function fetchNotif()
    {
        $this->notifications = Auth::user()->agent->unreadNotifications()->take(10)->get();
    }
}
