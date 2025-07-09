<?php

namespace App\Listeners;

use App\Events\DocumentCreated;
use App\Models\User;
use App\Notifications\DocumentNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendDocumentCreatedNotification
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
     * @param  \App\Events\DocumentCreated  $event
     * @return void
     */
    public function handle(DocumentCreated $event)
    {
        $agent = User::where('role_id', 1)->get()->map(function ($user) {
            return $user->agent;
        });
        Notification::send($agent, new DocumentNotification($event->document, $event->message));
    }
}
