<?php

namespace App\Listeners;

use App\Events\TacheCreated;
use App\Models\Agent;
use App\Notifications\TacheNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendTacheCreatedNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\TacheCreated  $event
     * @return void
     */
    public function handle(TacheCreated $event)
    {
        $agents = Agent::find($event->agents);
        $agentQuiADemarre = auth()->user()->agent;
        
        // Si le message contient "est en cours de traitement", on l'ajoute au début
        if (str_contains($event->message, 'est en cours de traitement')) {
            $message = "L'agent " . $agentQuiADemarre->prenom . ' ' . $agentQuiADemarre->nom . " a démarré le traitement de la tâche : \"" . $event->tache->titre . "\"";
        } else {
            // Ajouter le nom de la tâche au message existant
            $message = $event->message . " : \"" . $event->tache->titre . "\"";
        }
        
        Notification::send($agents, new TacheNotification($event->tache, $message, $agentQuiADemarre));
    }
}