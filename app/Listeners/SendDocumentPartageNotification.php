<?php

namespace App\Listeners;

use App\Events\CourrierPartage;
use App\Events\DocumentPartage;
use App\Models\Agent;
use App\Notifications\CourrierPartageNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendDocumentPartageNotification
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
     * @param  \App\Events\CourrierPartage  $event
     * @return void
     */
    public function handle(DocumentPartage $event)
    {
        $agents = Agent::find($event->partage->agent_id);
        Notification::send($agents, new CourrierPartageNotification($event->partage, $event->message));
    }
}
