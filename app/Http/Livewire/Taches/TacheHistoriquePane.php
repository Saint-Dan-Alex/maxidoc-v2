<?php

namespace App\Http\Livewire\Taches;

use App\Models\Tache;
use Livewire\Component;

class TacheHistoriquePane extends Component
{
    public $tache_id;

    protected $listeners = ['refreshHistory' => '$refresh'];

    public function render()
    {
        $tache = Tache::with(['historiques.user.agent.poste'])->findOrFail($this->tache_id);
        $historiques_list = $tache->historiques()->orderBy('created_at', 'desc')->get()->groupBy('user_id');

        return view('livewire.taches.tache-historique-pane', compact('historiques_list', 'tache'));
    }
}
