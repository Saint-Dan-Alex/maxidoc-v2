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

        // Compute counts (same logic as Sidebar component)
        $inboxCount = Courrier::where('statut_id', 1)
            ->whereDoesntHave('views', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->get()
            ->filter(function ($courrier) use ($user) {
                return $user->can('view', $courrier);
            })
            ->count();

        $tasksCount = Tache::getTachesForCurrentUser()
            ->where('tache_statut_id', '!=', 3)
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
        } else {
            // Pour Documents, Archives, et tout autre libellé: pas de badge
            $count = 0;
        }

        return view('livewire.sidebar.badge', compact('count', 'bg'));
    }
}
