<?php

namespace App\Http\Livewire\Taches;

use App\Models\Agent;
use App\Models\TacheObjectif;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EditTacheParticipantModal extends Component
{
    public $objectif;
    public $objectifs;
    protected $listeners = ['reloadModal' => '$refresh'];

    public function mount($objectif)
    {
        $this->objectif = $objectif;
        $this->objectifs = $objectif->agent->objectifs;
    }

    // public function modifierParticipant()
    // {
    //     $agent_id = $this->objectif->agent_id;
    //     $tache_id = $this->objectif->tache_id;
    //     try {
    //         TacheObjectif::create([
    //             'libelle' => $this->libelle,
    //             'tache_id' => $tache_id,
    //             'agent_id' => $agent_id,
    //             'user_id' => Auth::id(),
    //             'statut' => 0,
    //         ]);
    //         $this->reset();
    //         $this->emit('reloadComponent');
    //         $this->mount($this->objectif);
    //         $this->emit('alert', 'success', 'Nouvel objectif assigné');
    //     } catch (\Throwable $th) {
    //         throw $th;
    //         $this->emit('alert', 'error', 'Echec de l\'opération, Réessayez svp ou Recharger la page ');
    //     }
    // }

    // public function deleteParticipant($id)
    // {
    //     $objectif = TacheObjectif::findOrFail($id);
    //     $objectif->delete();
    //     $this->emit('reloadModal');
    //     $this->emit('reloadComponent');

    // }

    public function render()
    {
        return view('livewire.taches.edit-tache-participant-modal');
    }
}
