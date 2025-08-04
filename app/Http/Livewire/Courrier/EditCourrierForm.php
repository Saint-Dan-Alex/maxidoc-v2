<?php

namespace App\Http\Livewire\Courrier;

use App\Models\Agent;
use App\Models\CourrierCategory;
use App\Models\CourrierTypesTraitement;
use App\Models\Document;
use App\Models\Priorite;
use Livewire\Component;

class EditCourrierForm extends Component
{
    public $types;
    public $natures;
    public $services;
    public $agents;
    public $agentSelected;
    public $followers;
    public $priorites;
    public $destination;
    public $copies;
    public $isConfidentiel = false;
    public $dg = null;
    public $categories;
    public $traitements;
    public $selectedDoc = null;
    public $courrier;
    public $dga = null;
    public $isFormValid = false;

    protected $listeners = ['selectDoc'];

    public function mount($courrier, $types, $natures, $services, $agents)
    {
        $this->courrier = $courrier;
        $this->types = $types;
        $this->natures = $natures;
        $this->services = $services;
        $this->agents = $agents;
        $this->agentSelected = auth()->user()->agent_id;
    }

    public function render()
    {
        $this->isConfidentiel = $this->courrier->confidentiel ?? false;
        $this->priorites = Priorite::all();
        $this->followers = $this->agents->where('id', '!=', $this->agentSelected);
        
        // Récupération du DG (Directeur Général)
        $this->dg = Agent::whereHas('fonctions', function ($query) {
            $query->where('fonctions.id', 1)
                  ->where('pivot_agent_fonctions.statut_id', 1);
        })->first();

        // Récupération du DGA (Directeur Général Adjoint)
        $this->dga = Agent::whereHas('fonctions', function ($query) {
            $query->where('fonctions.id', 2)
                  ->where('pivot_agent_fonctions.statut_id', 1);
        })->first();

        $this->categories = CourrierCategory::all();
        $this->traitements = CourrierTypesTraitement::all();

        return view('livewire.courrier.edit-courrier-form');
    }

    public function selectDoc($doc_id)
    {
        // dd($doc_id);
        $this->selectedDoc = Document::find($doc_id);
    }
}
