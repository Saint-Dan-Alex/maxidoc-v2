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
     * Nombre de notifications non lues (pour le son)
     */
    public $unreadCount = 0;

    /**
     * Détermine si le son doit être joué (après l'initialisation)
     */
    public $initialized = false;

    /**
     * Initialisation du composant
     */
    /**
     * Indique si l'utilisateur est un secrétaire du DG
     *
     * @var bool
     */
    public $isSecretaireDG = false;

    /**
     * Initialisation du composant
     */
    public function mount()
    {
        $this->notifications = collect();
        
        // Vérifier si l'utilisateur est un secrétaire du DG
        $user = Auth::user();
        if ($user && $user->agent) {
            $this->isSecretaireDG = \App\Models\Secretariat::where('responsable_id', $user->agent->id)
                ->where('for_dg', true)
                ->exists();
        }

        // Initialiser le compteur pour éviter de jouer le son au chargement
        $this->fetchNotif(true);
        $this->unreadCount = $this->notifications->count();
        $this->initialized = true;
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
    public function fetchNotif($initial = false)
    {
        $user = Auth::user();
        if (!$user) return;
        
        $prevCount = $this->notifications ? $this->notifications->count() : 0;
        $this->notifications = collect();
        
        // Pour l'utilisateur super admin (id=1)
        if ($user->id === 1) {
            $this->notifications = $this->getUserNotifications($user);
        } 
        // Pour les autres utilisateurs avec un agent
        elseif ($user->agent) {
            $this->notifications = $this->getUserNotifications($user->agent);
        }

        $newCount = $this->notifications->count();

        // Si le nombre a augmenté et qu'on est déjà initialisé, on joue le son
        if (!$initial && $this->initialized && $newCount > $this->unreadCount) {
            $this->dispatchBrowserEvent('play-notification-sound');
        }

        $this->unreadCount = $newCount;
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
