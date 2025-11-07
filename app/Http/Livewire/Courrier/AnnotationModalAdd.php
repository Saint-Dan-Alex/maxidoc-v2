<?php

namespace App\Http\Livewire\Courrier;

use Livewire\Component;
use App\Models\CourriersAnnotation;
use Illuminate\Support\Facades\Auth;
use App\Models\Historique;
use App\Models\Courrier;
use App\Models\Tache;
use App\Events\TacheCreated;

class AnnotationModalAdd extends Component
{
    public $courrier;
    public $annotation;
    public $stat = [
        'note' => ''
    ];

    protected $listeners = [
        'addAnnotation' => 'addNote'
    ];

    public function mount($courrier) {
        $this->courrier = $courrier;
        $this->annotation = null; // Pas d'annotation sélectionnée par défaut
    }

    public function render()
    {
        return view('livewire.courrier.annotation-modal-add');
    }

     public function addNote($id) {
        // Trouver l'annotation par son ID
        $this->annotation = null;
        $this->stat['note'] = null;
    }

    public function saveNote() { 
            // Création d'une nouvelle annotation
            $annotation = new CourriersAnnotation();
            $annotation->user_id = Auth::user()->id;
            $annotation->courrier_id = $this->courrier->id;
            $annotation->note = $this->stat['note'];
            $annotation->save(); 

            Historique::create([
                "key" => "Annotation",
                "historiquecable_id" => $this->courrier->id,
                "historiquecable_type" => Courrier::class,
                "description" => Auth::user()->name.' a ajouté une nouvelle annotation à ce document.',
                "user_id" => Auth::user()->id,
            ]);

            // Répercuter sur les tâches liées au courrier
            $tachesLiees = Tache::where('courrier_id', $this->courrier->id)->get();
            if ($tachesLiees->isNotEmpty()) {
                $auteurId = Auth::user()->agent->id;
                $msg = 'Nouvelle annotation de ' . Auth::user()->agent->nom . ' ' . Auth::user()->agent->prenom . ' liée à la tâche \"%s\"';
                foreach ($tachesLiees as $tache) {
                    // Historique sur la tâche
                    Historique::create([
                        "key" => "Annotation",
                        "historiquecable_id" => $tache->id,
                        "historiquecable_type" => Tache::class,
                        "description" => Auth::user()->agent->nom . " " . Auth::user()->agent->prenom . " a ajouté une annotation liée au courrier.",
                        "user_id" => Auth::user()->id,
                    ]);

                    $message = sprintf($msg, $tache->titre);
                    // Notifier le propriétaire de la tâche
                    if ($tache->user && $tache->user->agent && $tache->user->agent->id != $auteurId) {
                        event(new TacheCreated($tache, $tache->user->agent->id, $message));
                    }
                    // Notifier les agents assignés
                    $agentsAssignes = $tache->agents()->get();
                    foreach ($agentsAssignes as $agent) {
                        if ($agent->id != $auteurId) {
                            event(new TacheCreated($tache, $agent->id, $message));
                        }
                    }
                }
            }

        $this->emit('annotationSaved');
        $this->reset('stat');
        $this->annotation = null; // Réinitialiser l'annotation après sauvegarde
    }
}
