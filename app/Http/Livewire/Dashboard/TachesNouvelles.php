<?php

namespace App\Http\Livewire\Dashboard;

// use App\Models\PivotUserTache;
use App\Models\Tache;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TachesNouvelles extends Component
{
    public function render()
    {
        $agentId = Auth::user()->agent->id;
        $userId = Auth::user()->id;

        $taches = Tache::with(['pivotusertaches', 'user', 'tache_statut', 'priorite', 'documents'])
            ->whereHas('pivotusertaches', function ($query) use ($agentId) {
                $query->where('agent_id', $agentId);
            })
            ->orWhere('user_id', $userId)
            ->where('tache_statut_id', 1)
            ->take(9) // Limiter les résultats directement au niveau de la requête
            ->get();

        return view('livewire.dashboard.taches-nouvelles', compact('taches'));
    }
}
