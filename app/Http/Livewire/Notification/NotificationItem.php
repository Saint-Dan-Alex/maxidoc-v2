<?php

namespace App\Http\Livewire\Notification;

use App\Notifications\CourrierNotification;
use App\Notifications\CourrierPartageNotification;
use App\Notifications\DocumentNotification;
use App\Notifications\TacheNotification;
use Livewire\Component;

class NotificationItem extends Component
{
    public $notification;

    public function mount($notification)
    {
        $this->notification = $notification;
    }
    public function render()
    {
        return view('livewire.notification.notification-item');
    }

    public function markAsRead()
    {
        $this->notification->markAsRead();
    }

    public function open()
    {
        $url = '';
        $id = '';
        if ($this->notification->type == DocumentNotification::class) {
            $url = 'regidoc.documents.show';
            $id = $this->notification->data['data']['object']['id'];
        } elseif ($this->notification->type == CourrierNotification::class) {
            $url = 'regidoc.courriers.show';
            $id = $this->notification->data['data']['courrier']['id'];
        } elseif ($this->notification->type == TacheNotification::class) {
            $url = 'regidoc.taches.index';
            $id = '';
        }elseif ($this->notification->type == CourrierPartageNotification::class) {
            $url = 'regidoc.courriers.show';
            $id = $this->notification->data['data']['courrier']['id'];
        }

        if(empty($id) || empty($url)) {
            return;
        }

        $this->markAsRead();

        return redirect()->route($url, $id);
    }
}
