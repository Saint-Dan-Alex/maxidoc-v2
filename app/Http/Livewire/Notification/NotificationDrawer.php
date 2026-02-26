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
        
        // Initialiser une collection vide
        $notifications = collect();
        
        // Récupérer les notifications de l'utilisateur (User)
        if (method_exists($user, 'unreadNotifications')) {
            $notifications = $notifications->merge($user->unreadNotifications()->take(10)->get());
        }
        
        // Récupérer les notifications de l'agent associé (Agent)
        if ($user->agent && method_exists($user->agent, 'unreadNotifications')) {
            $notifications = $notifications->merge($user->agent->unreadNotifications()->take(10)->get());
        }
        
        // Trier par date et limiter à 10
        $this->notifications = $notifications->sortByDesc('created_at')->take(10);

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
        
        // Chercher et marquer dans les deux modèles par sécurité
        if ($user->agent && method_exists($user->agent, 'unreadNotifications')) {
            $user->agent->unreadNotifications()->where('id', $id)->first()?->markAsRead();
        }
        
        if (method_exists($user, 'unreadNotifications')) {
            $user->unreadNotifications()->where('id', $id)->first()?->markAsRead();
        }
    }

    /**
     * Supprime toutes les notifications de l'utilisateur connecté
     */
    public function clearAllNotifications()
    {
        $user = Auth::user();
        
        // Marquer tout comme lu pour l'agent
        if ($user->agent && method_exists($user->agent, 'unreadNotifications')) {
            $user->agent->unreadNotifications()->update(['read_at' => now()]);
        }
        
        // Marquer tout comme lu pour l'utilisateur
        if (method_exists($user, 'unreadNotifications')) {
            $user->unreadNotifications()->update(['read_at' => now()]);
        }
        
        $this->notifications = collect();
    }
}
