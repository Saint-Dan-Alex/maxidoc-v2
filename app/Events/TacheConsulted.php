<?php

namespace App\Events;

use App\Models\Tache;
use App\Models\Agent;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TacheConsulted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $tache;
    public $agent;
    public $agentsConcernes;

    public function __construct(Tache $tache, Agent $agent, $agentsConcernes)
    {
        $this->tache = $tache;
        $this->agent = $agent;
        $this->agentsConcernes = $agentsConcernes;
    }

    public function broadcastOn()
    {
        return [];
    }
}
