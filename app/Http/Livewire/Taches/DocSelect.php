<?php

namespace App\Http\Livewire\Taches;

use Livewire\Component;

class DocSelect extends Component
{
    public $tache;
    public $courrier;
    public $document;
    public $selected;
    public $is_original;

    public function mount($tache) {
        $this->tache = $tache;
        if($this->tache->documents->document->count()){
             if($this->tache->documents->last()->document){
                $this->selectDoc($this->tache->documents->last()->document_url, $this->courrier->traitements->last()->id);
                 $this->is_original = false;
             } else {
                $this->selectDoc($this->tache->documents?->document, $this->tache->documents?->id);
                $this->is_original = true;
             }
        } else {
                $this->selectDoc($this->tache->documents?->document, $this->tache->documents?->id);
                $this->is_original = true;
        }
        // if ($this->courrier->traitements->count()) {
        //     if ($this->courrier->traitements->last()->document_url) {
        //         $this->selectDoc($this->courrier->traitements->last()->document_url, $this->courrier->traitements->last()->id);
        //         $this->is_original = false;
        //     }else {
        //         $this->selectDoc($this->courrier->document?->document, $this->courrier->document?->id);
        //         $this->is_original = true;
        //     }
        // } else {
        //     $this->selectDoc($this->courrier->document?->document, $this->courrier->document?->id);
        //     $this->is_original = true;
        // }

    }

    public function selectDoc($document, $id, $is_original = false) {
        $this->document = $document;
        $this->selected = files($this->document)->link == files($this->tache->documents?->document)->link ? files($this->document)->name.' (original)' : files($this->document)->name;
        $this->is_original = $is_original;
        $this->emit('documentChanged', [
            'doc' => files($this->document)->link,
            'doc_id' => $id,
            'is_original' => $this->is_original,
            'tache_id' => $this->tache->id,
        ]);
    }

    public function render()
    {
        return view('livewire.taches.doc-select');
    }
}
