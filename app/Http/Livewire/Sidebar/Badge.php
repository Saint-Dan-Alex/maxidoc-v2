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
             $inboxCount = 0;
             $tasksCount = 0;
        } else {
            $agentId = $user->agent->id;

            $inboxCount = Courrier::where('statut_id', 1)
                ->whereDoesntHave('views', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                })
                ->where(function ($q) use ($agentId) {
                    $q->where('created_by', $agentId)
                      ->orWhereHas('destinateurs', function ($sq) use ($agentId) {
                          $sq->where('agent_id', $agentId);
                      })
                      ->orWhereHas('followers', function ($sq) use ($agentId) {
                          $sq->where('agent_id', $agentId);
                      })
                      ->orWhereHas('partages', function ($sq) use ($agentId) {
                          $sq->where('agent_id', $agentId);
                      });
                })
                ->count();

            $tasksCount = Tache::where('tache_statut_id', '!=', 3)
                ->where(function ($q) use ($user, $agentId) {
                    $q->where('user_id', $user->id) // Taches created by user
                      ->orWhereHas('agents', function ($sq) use ($agentId) {
                          $sq->where('agents.id', $agentId); // Taches assigned to agent
                      });
                })
                ->count();
        }

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
        } else {
            // Pour Documents, Archives, et tout autre libellé: pas de badge
            $count = 0;
        }

        return view('livewire.sidebar.badge', compact('count', 'bg'));
    }
}
