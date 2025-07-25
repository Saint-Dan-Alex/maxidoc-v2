<?php

namespace App\Http\Livewire\Courrier;

use App\Models\Agent;
use App\Models\Courrier;
use App\Models\CourrierCategory;
use App\Models\CourrierNature;
use App\Models\CourrierType;
use App\Models\CourrierTypesTraitement;
use App\Models\Direction;
use App\Models\Priorite;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CompleteForm extends Component
{
    public $courrierId;
    public $courrier;
    public $types;
    public $natures;
    public $categories;
    public $services;
    public $directions;
    public $agents;
    public $priorites;
    public $traitements;
    public $selectedDoc = false;
    public $newDoc = false;
    public $textSelected = '';
    public $fileName = '';
    public $type = [];
    public $isConfidentiel = false;
    public $isFormValid = true;

    protected $listeners = ['documentSelected' => 'handleDocumentSelected'];

    public function mount($types, $natures, $services, $agents, $newDoc = false, $textSelected = '', $fileName = '', $type = null)
    {
        $this->types = $types;
        $this->natures = $natures;
        $this->services = $services;
        $this->agents = $agents;
        $this->newDoc = $newDoc;
        $this->textSelected = $textSelected;
        $this->fileName = $fileName;
        $this->type = $type ?? [];
        
        // Initialisation des autres propriétés si nécessaire
        $this->categories = CourrierCategory::all();
        $this->directions = Direction::all();
        $this->priorites = Priorite::all();
        $this->traitements = CourrierTypesTraitement::all();
    }

    public function handleDocumentSelected($text, $fileName)
    {
        $this->textSelected = $text;
        $this->fileName = $fileName;
        $this->selectedDoc = true;
    }

    public function render()
    {
        return view('livewire.courrier.complete-form');
    }
}
