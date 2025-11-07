<?php

namespace App\Http\Livewire\Taches;

use App\Events\TacheCreated;
use App\Models\Commentaire;
use App\Models\Tache;
use App\Models\Historique;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TacheCommentairePane extends Component
{
    public $tache;
    public $message;
    public $active = true;
    protected $rules = [
        'message' => 'required|string',
    ];

    protected $listeners = [
        'reload' => 'reload',
    ];

    public function mount($tache_id)
    {
        $this->tache = Tache::find($tache_id);
    }

    public function reload()
    {
        $this->mount($this->tache->id);
    }

    public function addCommentaire()
    {
        if ($this->message) {
            try {
                //code...
                $this->validate([
                    'message' => 'required',
                    // Ajoutez ici les règles de validation pour le champ 'message'
                ]);
                # code...
                Commentaire::create([
                    'tache_id' => $this->tache->id,
                    'user_id' => Auth::id(),
                    'message' => $this->message,
                ]);

                // Historique de commentaire
                Historique::create([
                    "key" => "Ajout d'un commentaire",
                    "historiquecable_id" => $this->tache->id,
                    "historiquecable_type" => Tache::class,
                    "description" => Auth::user()->agent->nom . " " . Auth::user()->agent->prenom . " a ajouté un commentaire à la tâche.",
                    "user_id" => Auth::user()->id,
                ]);

                // Notifications: propriétaire + agents assignés (hors auteur)
                $auteurId = Auth::user()->agent->id;
                $message = 'Nouveau commentaire de ' . Auth::user()->agent->nom . ' ' . Auth::user()->agent->prenom . ' sur la tâche \"' . $this->tache->titre . '\"';

                // Notifier le propriétaire si différent de l'auteur
                if ($this->tache->user && $this->tache->user->agent && $this->tache->user->agent->id != $auteurId) {
                    event(new TacheCreated($this->tache, $this->tache->user->agent->id, $message));
                }

                // Notifier les agents assignés
                $agentsAssignes = $this->tache->agents()->get();
                foreach ($agentsAssignes as $agent) {
                    if ($agent->id != $auteurId) {
                        event(new TacheCreated($this->tache, $agent->id, $message));
                    }
                }

                $this->message = '';

                $this->emit('reload');
                // $this->pan = 2;
                $this->emit('alert', 'success', 'Commentaire a été ajouté à la tâche');
            } catch (\Throwable $th) {
                //throw $th;
                $this->emit('alert', 'error', 'Echec de l\`opération');
            }
        }
    }

    public function render()
    {
        if ($this->message != '' && $this->message != null) {
            $this->active = false;
        }
        $commentaires = $this->tache->commentaires()->orderBy('created_at', 'desc')->get();
        return view('livewire.taches.tache-commentaire-pane', [
            'commentaires' => $commentaires,
        ]);
    }
}
