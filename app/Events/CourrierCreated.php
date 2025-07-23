<?php

namespace App\Events;

use App\Models\Courrier;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
// use Illuminate\Broadcasting\PresenceChannel;
// use Illuminate\Broadcasting\PrivateChannel;
// use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable; 
use Illuminate\Queue\SerializesModels;

class CourrierCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Le courrier créé
     *
     * @var \App\Models\Courrier
     */
    public $courrier;

    /**
     * La collection d'agents à notifier
     *
     * @var \Illuminate\Database\Eloquent\Collection|\App\Models\Agent[]
     */
    public $agents;

    /**
     * Le message de notification
     *
     * @var string
     */
    public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    /**
     * Créer une nouvelle instance de l'événement.
     *
     * @param  \App\Models\Courrier  $courrier
     * @param  \Illuminate\Database\Eloquent\Collection|\App\Models\Agent[]  $agents
     * @param  string  $message
     * @return void
     */
    public function __construct(Courrier $courrier, $agents, $message)
    {
        $this->courrier = $courrier;
        $this->agents = $agents;
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('addedcourriers');
    }
}
