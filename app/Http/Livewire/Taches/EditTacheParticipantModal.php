<?php

namespace App\Http\Livewire\Taches;

use App\Models\Agent;
use App\Models\TacheObjectif;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class EditTacheParticipantModal extends Component
{
    public $objectif;
    public $objectifs = [];
    protected $listeners = [
        'reloadModal' => '$refresh',
        'editParticipant' => 'loadObjectif'
    ];
    
    protected $rules = [
        'objectif.libelle' => 'required|string|max:255',
    ];

    public function mount($objectif = null)
    {
        if ($objectif) {
            $this->loadObjectif($objectif->id);
        }
    }
    
    public function loadObjectif($objectifId)
    {
        try {
            // Charger l'objectif avec ses relations
            $this->objectif = TacheObjectif::with(['agent', 'tache'])->findOrFail($objectifId);
            
            // Charger uniquement les objectifs de cet agent pour cette tâche spécifique
            if ($this->objectif->agent && $this->objectif->tache) {
                $this->objectifs = TacheObjectif::where('agent_id', $this->objectif->agent_id)
                    ->where('tache_id', $this->objectif->tache_id)
                    ->get();
            } else {
                $this->objectifs = [];
            }
            
            // Déclencher un rendu pour mettre à jour l'interface utilisateur
            $this->emitSelf('$refresh');
            
            // Forcer la mise à jour du DOM
            $this->dispatchBrowserEvent('contentChanged');
            
        } catch (\Exception $e) {
            $this->emit('alert', 'error', 'Erreur lors du chargement des données du participant');
            \Illuminate\Support\Facades\Log::error('Erreur lors du chargement de l\'objectif: ' . $e->getMessage());
        }
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

    public function deleteParticipant($id)
    {
        try {
            $objectif = TacheObjectif::findOrFail($id);
            $tacheId = $objectif->tache_id;
            
            // Supprimer l'objectif
            $objectif->delete();
            
            // Émettre un événement pour rafraîchir les composants parents
            $this->emit('participantUpdated');
            $this->emit('refreshTacheInfo');
            $this->emit('alert', 'success', 'Participant supprimé avec succès');
            
            // Fermer la modale
            $this->dispatchBrowserEvent('close-modal', ['modalId' => 'modal-edit-participants-' . $id]);
            
            // Recharger la page après un court délai pour s'assurer que tout est synchronisé
            $this->dispatchBrowserEvent('reload-page', ['delay' => 500]);
            
        } catch (\Exception $e) {
            $this->emit('alert', 'error', 'Erreur lors de la suppression du participant: ' . $e->getMessage());
            \Illuminate\Support\Facades\Log::error('Erreur lors de la suppression du participant: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.taches.edit-tache-participant-modal');
    }
}
