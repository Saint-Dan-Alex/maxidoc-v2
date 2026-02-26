<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Tache;
use App\Helpers\DelegationHelper;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TachesNouvelles extends Component
{
    public function render()
    {
        $userIds = DelegationHelper::getUserIds();
        [$agentId, $dgAgentId] = DelegationHelper::getAgentIds();
        $agentIds = array_filter([$agentId, $dgAgentId]);

        $taches = Tache::with(['pivotusertaches', 'user', 'tache_statut', 'priorite', 'documents'])
            ->where(function($q) use ($agentIds, $userIds) {
                $q->whereHas('pivotusertaches', function ($query) use ($agentIds) {
                    $query->whereIn('agent_id', $agentIds);
                })
                ->orWhereIn('user_id', $userIds);
            })
            ->where('tache_statut_id', 1)
            ->take(9)
            ->get();

        return view('livewire.dashboard.taches-nouvelles', compact('taches'));
    }
}
