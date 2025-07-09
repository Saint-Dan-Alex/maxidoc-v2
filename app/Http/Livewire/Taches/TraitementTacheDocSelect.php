<?php

namespace App\Http\Livewire\Taches;

use Livewire\Component;

class TraitementTacheDocSelect extends Component
{
    public $courrier;
    public $document;
    public $selected;


    public function mount($courrier) {
        $this->courrier = $courrier;
        if ($this->courrier->traitements->count()) {
            if ($this->courrier->traitements->last()->document_url) {
                # code...
                $this->selectDoc($this->courrier->traitements->last()->document_url);
            }else {
                $this->selectDoc($this->courrier->document?->document);
            }
        } else {
            $this->selectDoc($this->courrier->document?->document);
        }

    }

    public function render()
    {
        return view('livewire.courrier.traitement-doc-select');
    }

    public function selectDoc($document) {
        $this->document = $document;
        $this->selected = files($this->document)->name;
        $this->emit('documentChanged', ['doc' => files($this->document)->link]);
    }
}
