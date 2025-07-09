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
        Notification::send($agents, new TacheNotification($event->tache, $event->message));
    }
}
