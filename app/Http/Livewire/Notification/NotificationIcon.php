<?php

namespace App\Http\Livewire\Notification;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Collection;

class NotificationIcon extends Component
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
        $this->fetchNotif();
        return view('livewire.notification.notification-icon');
    }

    /**
     * Récupère les notifications non lues
     */
    public function fetchNotif()
    {
        $user = Auth::user();
        $this->notifications = collect();
        
        // Pour l'utilisateur super admin (id=1)
        if ($user->id === 1) {
            $this->notifications = $this->getUserNotifications($user);
        } 
        // Pour les autres utilisateurs avec un agent
        elseif ($user->agent) {
            $this->notifications = $this->getUserNotifications($user->agent);
        }
    }
    
    /**
     * Récupère les notifications d'un modèle (User ou Agent)
     */
    protected function getUserNotifications($model)
    {
        if (!method_exists($model, 'unreadNotifications')) {
            return collect();
        }
        
        try {
            return $model->unreadNotifications()
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();
        } catch (\Exception $e) {
            logger()->error('Erreur lors de la récupération des notifications: ' . $e->getMessage());
            return collect();
        }
    }
}
