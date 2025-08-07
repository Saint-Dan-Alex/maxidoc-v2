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
        $params = [];
        
        if ($this->notification->type == DocumentNotification::class) {
            // Pour les documents
            $document = $this->notification->data['data']['object'];
            if (isset($document['dossier_id'])) {
                $url = 'regidoc.documents.details';
                $params = ['dossier' => $document['dossier_id'], 'document' => $document['id']];
            } else {
                $url = 'regidoc.documents.show';
                $params = $document['id'];
            }
        } 
        elseif ($this->notification->type == CourrierNotification::class || $this->notification->type == CourrierPartageNotification::class) {
            // Pour les courriers
            $courrier = $this->notification->data['data']['courrier'];
            $url = 'regidoc.courriers.show';
            $params = $courrier['id'];
        } 
        elseif ($this->notification->type == TacheNotification::class) {
            // Pour les tâches
            $tache = $this->notification->data['data']['tache'] ?? null;
            if ($tache) {
                $url = 'regidoc.taches.index';
                // Ajouter un paramètre pour ouvrir directement la tâche
                $params = ['#tache-' . $tache['id']];
            } else {
                $url = 'regidoc.taches.index';
            }
        }

        if (empty($url)) {
            return;
        }

        $this->markAsRead();

        if (is_array($params)) {
            return redirect()->route($url, $params);
        }
        
        return redirect()->route($url, $params);
    }
}
