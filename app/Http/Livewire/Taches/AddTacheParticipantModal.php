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
            // Récupération des données nécessaires
            $tache = $this->tache;
            $agentId = $this->agent_id;
            $libelle = $this->libelle;
            $currentUserId = Auth::id();

            // Création de l'objectif de la tâche
            $objectif = TacheObjectif::create([
                'libelle' => $libelle,
                'tache_id' => $tache->id,
                'agent_id' => $agentId,
                'user_id' => $currentUserId,
                'statut' => 0,
            ]);

            // Lier l'agent à la tâche s'il ne l'est pas déjà
            if (!$tache->agents->contains($agentId)) {
                $tache->agents()->attach($agentId, [
                    'type' => 'App\Models\Agent',
                    'type_id' => $agentId,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            // Rafraîchir les relations
            $tache->load('agents');

            // Émettre les événements nécessaires
            $this->emit('participantAdded');
            $this->emit('refreshTacheInfo');
            $this->emit('reloadComponent');
            $this->emit('reloadPane');
            $this->emit('reloadInfo');
            
            // Réinitialiser le formulaire
            $this->reset(['agent_id', 'libelle']);
            
            // Émettre l'événement de création de tâche
            event(new TacheCreated($tache, $agentId, 'Vous a envoyé un nouvel objectif < ' . $libelle . ' > pour la tâche ' . $tache->titre));
            
            // Message de succès
            $this->emit('alert', 'success', 'Participant et objectif ajoutés avec succès');
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