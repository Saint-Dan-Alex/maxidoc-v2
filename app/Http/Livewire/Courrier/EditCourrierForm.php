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
    public $isConfidentiel;
    public $dg;
    public $categories;
    public $traitements;
    public $selectedDoc;
    public $courrier;
    public $dga;

    protected $listeners = ['selectDoc'];

    // public function FunctionName(Type $var = null)
    // {
    //     # code...
    // }

    public function render()
    {
        $this->isConfidentiel = $this->courrier->confidentiel;
        $this->priorites = Priorite::all();
        $this->followers = $this->agents->where('id', '!=', $this->agentSelected);
        $this->dg = Agent::whereHas('fonctions', function ($query)
        {
            $query->where('fonctions.id', 1)->where('pivot_agent_fonctions.statut_id', 1);
        })->first();

        $this->dga = Agent::whereHas('fonctions', function ($query)
        {
            $query->where('fonctions.id', 2)->where('pivot_agent_fonctions.statut_id', 1);
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
