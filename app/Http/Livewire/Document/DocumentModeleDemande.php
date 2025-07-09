<?php

namespace App\Http\Livewire\Document;

use Livewire\Component;

class DocumentModeleDemande extends Component
{

    public function addRow()
    {
        $this->emit('addRow');
    }
    public function render()
    {
        return view('livewire.document.document-modele-demande');
    }

}
