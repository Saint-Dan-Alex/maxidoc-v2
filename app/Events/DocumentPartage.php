<?php

namespace App\Events;

use App\Models\CourriersPartage;
use App\Models\DocumentFollower;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DocumentPartage
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $partage;
    public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(DocumentFollower $partage, string $message)
    {
        $this->partage = $partage;
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
