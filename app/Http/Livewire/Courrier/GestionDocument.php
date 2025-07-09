<?php

namespace App\Http\Livewire\Courrier;

use Livewire\Component;

class GestionDocument extends Component
{
    public $courrier;
    public $selectedDoc;
    public $selectedDocName;

    public function mount($courrier) {
        $this->courrier = $courrier;
        $this->selectedDoc = $courrier->document?->document ?? null;
        $this->selectedDocName = files($courrier->document?->document)->name;
    }

    public function switchDoc($url) {
        $this->selectedDoc = $url;
        $this->emit('documentSwitch');
    }

    public function render()
    {
        return view('livewire.courrier.gestion-document');
    }
}
