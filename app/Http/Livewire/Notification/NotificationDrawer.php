<?php

namespace App\Http\Livewire\Notification;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NotificationDrawer extends Component
{
    public $notifications;

    public function render()
    {
        $this->notifications = Auth::user()->agent->unreadNotifications->take(10);

        return view('livewire.notification.notification-drawer');
    }

    public function redirectClick($route, $id, $notification_id)
    {
        // dd($id);
        $notif = Auth::user()->agent->notifications->where('id', $notification_id)->markAsRead();
        return redirect()->route($route, $id);
    }

    public function remouveNitif($id)
    {
        $this->notifications->where('id', $id)->markAsRead();
        // Notification::find($id)->delete();
    }
}
