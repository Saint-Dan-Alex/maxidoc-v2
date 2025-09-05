<?php

namespace App\Http\Livewire\Courrier;

use Livewire\Component;
use App\Models\CourriersAnnotation;
use Illuminate\Support\Facades\Auth;
use App\Models\Historique;
use App\Models\Courrier;

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

        $this->emit('annotationSaved');
        $this->reset('stat');
        $this->annotation = null; // Réinitialiser l'annotation après sauvegarde
    }
}
