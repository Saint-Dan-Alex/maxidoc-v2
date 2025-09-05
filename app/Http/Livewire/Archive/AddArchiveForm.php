<?php

namespace App\Http\Livewire\Archive;

use Livewire\Component;
use App\Models\CourrierFollower;

class AddArchiveForm extends Component
{
    public $types;
    public $natures;
    public $services;
    public $agents;
    public $sec;
    public $isDestinateur;
    public $newDoc;
    public $textSelected;
    public $fileName;

    public $followers;
    public $type;
    public $num;
    public $isFormValid = false;
    public $selectedDoc = false;
    public $isConfidentiel = false;
    public $ref;

    public function mount($types, $natures, $services, $agents, $sec, $isDestinateur, $newDoc, $textSelected, $fileName)
    {
        $this->types = $types;
        $this->natures = $natures;
        $this->services = $services;
        $this->agents = $agents;
        $this->sec = $sec;
        $this->isDestinateur = $isDestinateur;
        $this->newDoc = $newDoc;
        $this->textSelected = $textSelected;
        $this->fileName = $fileName;
        $this->followers = CourrierFollower::all();
        $this->type = $types->first()->id ?? 1;
        $this->changeNumRef();
        if ($this->newDoc) {
            $this->selectedDoc = true;
        }
    }

    public function changeNumRef()
    {
        $this->num = uniqid('doc-');
    }

    public function render()
    {
        return view('livewire.archive.add-archive-form');
    }

    public function changeServiceInit($id)
    {
        //
    }
}
