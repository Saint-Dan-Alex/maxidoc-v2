<?php

namespace App\Http\Livewire\Courrier;

use App\Models\CourriersAnnotation;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AnnotationModal extends Component
{
    public $courrier;
    public $annotation;
    public $stat = [
        'note' => ''
    ];

    protected $listeners = [
        'editAnnotation' => 'editNote'
    ];

    public function mount($courrier) {
        $this->courrier = $courrier;
        $this->annotation = null; // Pas d'annotation sélectionnée par défaut
    }

    public function render()
    {
        return view('livewire.courrier.annotation-modal');
    }

    public function editNote($id) {
        // Trouver l'annotation par son ID
        $this->annotation = CourriersAnnotation::find($id);
        if ($this->annotation) {
            $this->stat['note'] = $this->annotation->note;
        }
    }

    public function saveNote() {
        if ($this->annotation) {
            // Mise à jour de l'annotation existante
            $this->annotation->note = $this->stat['note'];
            $this->annotation->save();
        } else {
            // Création d'une nouvelle annotation
            $annotation = new CourriersAnnotation();
            $annotation->user_id = Auth::user()->id;
            $annotation->courrier_id = $this->courrier->id;
            $annotation->note = $this->stat['note'];
            $annotation->save();
        }

        $this->emit('annotationSaved');
        $this->reset('stat');
        $this->annotation = null; // Réinitialiser l'annotation après sauvegarde
    }
}
