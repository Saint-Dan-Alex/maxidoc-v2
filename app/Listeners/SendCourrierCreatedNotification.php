<?php

namespace App\Listeners;

use App\Events\CourrierCreated;
use App\Models\Subscription;
use App\Models\User;
use App\Notifications\CourrierNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Minishlink\WebPush\WebPush;

class SendCourrierCreatedNotification
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
     * @param  \App\Events\CourrierCreated  $event
     * @return void
     */
    public function handle(CourrierCreated $event)
    {
 
         Notification::send(
             $event->agents, 
             new CourrierNotification(
                 $event->courrier, 
                 Auth::user()->agent, 
                 $event->message
             )
         );

        // $webPush = new WebPush([
        //     'VAPID' => [
        //         'subject' => env('APP_URL'),
        //         'publicKey' => env('VAPID_PUBLIC_KEY'),
        //         'privateKey' => env('VAPID_PRIVATE_KEY'),
        //     ],
        // ]);

        // foreach(Auth::user()->subscriptions as $subscription) {
        //     $webPush->queueNotification(
        //         Subscription::create([
        //             'endpoint' => $subscription->endpoint,
        //             'publicKey' => $subscription->public_key,
        //             'authToken' => $subscription->auth_token,
        //         ]),
        //         json_encode([
        //             'message' => $event->message,
        //             'title' => Auth::user()->agent->prenom.' '.Auth::user()->agent->nom.' '.Auth::user()->agent->post_nom
        //         ])
        //     );
        // }

        // foreach ($webPush->flush() as $report) {
        //     $endpoint = $report->getRequest()->getUri()->__toString();
        //     if ($report->isSuccess()) {
        //         Log::info("[v] Le message bien été envoyé {$endpoint}.");
        //     } else {
        //         Log::info("[x] Impossible d'envoyer le message {$endpoint}: {$report->getReason()}");
        //     }
        // }

    }
}
