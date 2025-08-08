<?php

namespace App\Http\Livewire\Notification;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Collection;

class NotificationDrawer extends Component
{
    /**
     * Les notifications non lues
     *
     * @var Collection
     */
    public $notifications;

    /**
     * Initialisation du composant
     */
    public function mount()
    {
        $this->notifications = collect();
    }

    /**
     * Rendu du composant
     */
    public function render()
    {
        $user = Auth::user();
        
        // Initialiser une collection vide par défaut
        $this->notifications = collect();
        
        // Vérifier si l'utilisateur a un agent avec des notifications
        if ($user->agent && $user->agent->unreadNotifications) {
            $this->notifications = $user->agent->unreadNotifications->take(10);
        }
        // Pour l'utilisateur super admin (id=1), on peut récupérer les notifications directement
        elseif ($user->id === 1 && method_exists($user, 'unreadNotifications')) {
            $this->notifications = $user->unreadNotifications->take(10);
        }

        return view('livewire.notification.notification-drawer');
    }

    /**
     * Redirige vers une route et marque la notification comme lue
     */
    public function redirectClick($route, $id, $notification_id)
    {
        $user = Auth::user();
        
        // Marquer la notification comme lue si l'utilisateur a un agent
        if ($user->agent && $user->agent->notifications) {
            $user->agent->notifications
                ->where('id', $notification_id)
                ->markAsRead();
        }
        // Pour l'utilisateur super admin, marquer directement depuis l'utilisateur
        elseif ($user->id === 1 && method_exists($user, 'notifications')) {
            $user->notifications
                ->where('id', $notification_id)
                ->markAsRead();
        }

        return redirect()->route($route, $id);
    }

    /**
     * Marque une notification comme lue
     */
    public function remouveNitif($id)
    {
        $user = Auth::user();
        
        // Marquer la notification comme lue si l'utilisateur a un agent
        if ($user->agent && $user->agent->notifications) {
            $user->agent->notifications
                ->where('id', $id)
                ->markAsRead();
        }
        // Pour l'utilisateur super admin, marquer directement depuis l'utilisateur
        elseif ($user->id === 1 && method_exists($user, 'notifications')) {
            $user->notifications
                ->where('id', $id)
                ->markAsRead();
        }
    }
}
