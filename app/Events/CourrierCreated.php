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

    public $courrier;
    public $agents;
    public $message;

    /**
     * Create a new event instance.
     *
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
