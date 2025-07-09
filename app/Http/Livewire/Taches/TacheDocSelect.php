<?php

namespace App\Http\Livewire\Taches;

use Livewire\Component;

class TacheDocSelect extends Component
{
    public $tache;
    public $document;
    public $doc;
    public $selected;


    public function mount($tache, $doc)
    {
        $this->tache = $tache;
        $this->doc = $doc;
        $this->selectDoc($this->doc->document);
        // if ($this->tache->documents->count()) {
        //     if ($this->tache->documents->last()) {
        //         # code...
        //         $this->selectDoc($this->tache->documents->last());
        //     }else {
        //         $this->selectDoc($this->tache->documents?->first());
        //     }
        // } else {
        //     $this->selectDoc($this->tache->document->first());
        // }

    }

    public function render()
    {
        return view('livewire.taches.tache-doc-select');
    }

    public function selectDoc($document)
    {
        $this->document = $document;
        $this->selected = files($this->document)->name;
        $this->emit('documentChanged', ['doc' => files($this->document)->link]);
    }
}
