<?php

namespace App\Http\Livewire\Taches;

use App\Events\TacheCreated;
use App\Models\Agent;
use App\Models\TacheObjectif;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AddTacheParticipantModal extends Component
{
    public $tache;
    public $agents;
    public $agent_id;
    public $libelle;
    protected $listeners = ['reloadModal' => '$refresh'];
    protected $rules = [
        'agent_id' => 'required',
        'libelle' => 'required',
    ];
    public function mount($tache)
    {
        $this->tache = $tache;
        $this->agents = Agent::whereHas('direction.responsable', function ($q) {
            $q->whereColumn('agents.id', 'directions.responsable_id');
        })->get();
    }


    public function ajouterParticipant()
    {
        $this->validate();

        try {
            // Vérifiez si $this->tache existe avant de le stocker en session
            //code...
            $tache = $this->tache;
            $agent_id = $this->agent_id;
            $libelle = $this->libelle;

            TacheObjectif::create([
                'libelle' => $this->libelle,
                'tache_id' => $this->tache->id,
                'agent_id' => $this->agent_id,
                'user_id' => Auth::id(),
                'statut' => 0,
            ]);

            if (!in_array($this->agent_id,$tache->agents->pluck('id')->toArray())) {
                $tache->agents()->attach($this->agent_id);
            }

            $this->reset();
            $this->emit('reloadComponent');
            $this->emit('reloadPane');
            $this->emit('reloadInfo');
            $this->mount($tache);
            $this->emit('alert', 'success', 'Nouvel objectif assigné');
            event(new TacheCreated($tache, $agent_id, 'Vous a envoyé un nouvel objectif < ' . $libelle . ' > pour la tâche ' . $tache->titre));
        } catch (\Throwable $th) {
            // throw $th;
            $this->emit('alert', 'error', 'Echec de l\'opération, Réessayez svp ou Recharger la page ');
        }
    }


    public function render()
    {
        return view('livewire.taches.add-tache-participant-modal');
    }
}