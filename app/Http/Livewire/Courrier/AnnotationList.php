<?php

namespace App\Http\Livewire\Courrier;

use App\Models\Courrier;
use App\Models\CourriersAnnotation;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AnnotationList extends Component
{
    public $courrier;
    public $annoteCount = 0;

    protected $listeners = [
        'annotationSaved' => 'refreshAnnotationList'
    ];

    public function mount($courrier) {
        $this->courrier = $courrier;
        $this->annoteCount = $this->courrier->annotations->count() ?? 0;
    }

    public function render()
    {
        return view('livewire.courrier.annotation-list');
    }

    public function refreshAnnotationList() {
        $id = $this->courrier->id;
        $this->reset('courrier');
        $this->courrier = Courrier::find($id);
        $this->mount($this->courrier);
    }

     public function editAnnotation() {
         $this->emit('editAnnotation', $this->courrier->id);
     }

     public function addAnnotation(){
        $this->emit('addAnnotation');
     }

    

    public function deleteAnnotation($id) {
        $courrier_id = $this->courrier->id;
        $annotation = CourriersAnnotation::find($id);
        $annotation->delete();
        $this->courrier = Courrier::find($courrier_id);
        $this->emit('annotationDeleted', $this->courrier->annotations->count() ?? 0);
    }

    public function markAsDone($id) {
        $courrier_id = $this->courrier->id;
        $annotation = CourriersAnnotation::find($id);
        $annotation->is_done = 1;
        $annotation->done_by = Auth::user()->id;
        $annotation->save();
        $this->courrier = Courrier::find($courrier_id);
        $this->refreshAnnotationList();
    }
}
