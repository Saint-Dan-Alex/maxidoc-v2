<?php

namespace App\Listeners;

use App\Events\TacheConsulted;
use App\Notifications\TacheNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class SendTacheConsultedNotification implements ShouldQueue
{
    public function handle(TacheConsulted $event)
    {
        $message = "L'agent {$event->agent->prenom} {$event->agent->nom} a consulté la tâche : \"{$event->tache->titre}\"";
        
        // Envoyer la notification à tous les agents concernés sauf à l'agent qui a consulté
        $agentsANotifier = $event->agentsConcernes->reject(function ($agent) use ($event) {
            return $agent->id === $event->agent->id;
        });

        if ($agentsANotifier->isNotEmpty()) {
            Notification::send(
                $agentsANotifier, 
                new TacheNotification($event->tache, $message, $event->agent)
            );
        }
    }
}