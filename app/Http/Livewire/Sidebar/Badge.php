<?php

namespace App\Http\Livewire\Sidebar;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Courrier;
use App\Models\Tache;
use App\Models\Document;

class Badge extends Component
{
    public string $label = '';

    public function render()
    {
        $user = Auth::user();
        if (!$user->agent) {
             return view('livewire.sidebar.badge', ['count' => 0, 'bg' => 'secondary']);
        }

        $userIds = \App\Helpers\DelegationHelper::getUserIds();
        [$agentId, $dgAgentId] = \App\Helpers\DelegationHelper::getAgentIds();
        $agentIds = array_filter([$agentId, $dgAgentId]);

        // Compte Inbox : non lus (Moi + DG)
        $inboxCount = Courrier::where('statut_id', 1)
            ->whereDoesntHave('views', function ($q) use ($userIds) {
                $q->whereIn('user_id', $userIds);
            })
            ->where(function ($q) use ($agentIds) {
                $q->whereIn('created_by', $agentIds)
                  ->orWhereHas('destinateurs', function ($sq) use ($agentIds) {
                      $sq->whereIn('agent_id', $agentIds);
                  })
                  ->orWhereHas('followers', function ($sq) use ($agentIds) {
                      $sq->whereIn('agent_id', $agentIds);
                  })
                  ->orWhereHas('partages', function ($sq) use ($agentIds) {
                      $sq->whereIn('agent_id', $agentIds);
                  });
            })
            ->count();

        // Compte Tâches : Initiales (Moi + DG)
        $tasksCount = Tache::where('tache_statut_id', 1)
            ->where(function($q) use ($agentIds, $userIds) {
                $q->whereHas('agents', function ($sq) use ($agentIds) {
                    $sq->whereIn('agent_id', $agentIds)
                       ->where('type', 'App\Models\Agent');
                })
                ->orWhereIn('user_id', $userIds);
            })
            ->count();

        // Ne plus afficher de badge pour Documents et Archives
        $t = Str::lower($this->label);
        $count = 0;
        $bg = 'secondary';

        if (Str::contains($t, ['boite', 'boîte'])) {
            $count = $inboxCount;
            $bg = 'danger';
        } elseif (Str::contains($t, ['tache', 'tâche'])) {
            $count = $tasksCount;
            $bg = 'danger';
        } elseif (Str::contains($t, ['suggestions reçues'])) {
            if ($user->hasRole('Super Admin') || $user->hasRole('Administrateur système')) {
                $count = \App\Models\Suggestion::where('status', 'ouvert')->count();
                $bg = 'warning';
            } else {
                $count = 0;
            }
        } else {
            // Pour Documents, Archives, et tout autre libellé: pas de badge
            $count = 0;
        }

        return view('livewire.sidebar.badge', compact('count', 'bg'));
    }
}
