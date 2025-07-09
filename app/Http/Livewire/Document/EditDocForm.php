<?php

namespace App\Http\Livewire\Document;

use App\Models\Agent;
use App\Models\CourrierCategory;
use App\Models\CourrierTypesTraitement;
use App\Models\DocumentType;
use App\Models\Priorite;
use Livewire\Component;

class EditDocForm extends Component
{
    public $types;
    public $natures;
    // public $departements;
    public $agents;
    public $agentSelected;
    public $followers;
    public $priorites;
    public $destination;
    public $copies;
    public $isConfidentiel;
    public $dg;
    public $categories;
    public $traitements;
    public $dossier_id;
    public $document;

    // public function mount()
    // {
    //     # code...
    // }

    public function render()
    {
        $this->dossier_id = $this->document->dossier->id;
        $this->priorites = Priorite::all();
        $this->followers = $this->agents->where('id', '!=', $this->agentSelected);
        $this->dg = Agent::whereHas('fonctions', function ($query)
        {
            $query->where('fonctions.id', 1)->where('pivot_agent_fonctions.statut_id', 1);
        })->first();
        $this->categories = CourrierCategory::all();
        $this->traitements = CourrierTypesTraitement::all();

        $this->types = DocumentType::select('id','titre')->get();

        return view('livewire.document.edit-doc-form');
    }
}
