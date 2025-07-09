<?php

namespace App\Http\Livewire\Courrier;

use App\Models\Agent;
use App\Models\CourrierCategory;
use App\Models\CourrierTypesTraitement;
use App\Models\Document;
use App\Models\Priorite;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreateCourrierForm extends Component
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
    public $dga;
    public $categories;
    public $traitements;
    public $selectedDoc;

    protected $listeners = ['selectDoc'];

    public function render()
    {
        // $this->priorites = Priorite::all();
        // $this->agents = $this->agents->where('id', '!=', Auth::user()->agent->id);

        // $this->dg = Agent::whereHas('fonctions', function ($query)
        // {
        //     $query->where('fonctions.id', 1)->where('pivot_agent_fonctions.statut_id', 1);
        // })->first();
        // $this->dga = Agent::whereHas('fonctions', function ($query)
        // {
        //     $query->where('fonctions.id', 2)->where('pivot_agent_fonctions.statut_id', 1);
        // })->first();

        // $this->followers = $this->agents->where('id', '!=', $this->dg)->where('id', '!=', $this->dga)->where('id', '!=', Auth::user()->agent->id);

        // $this->categories = CourrierCategory::all();
        // $this->traitements = CourrierTypesTraitement::all();

        return view('livewire.courrier.create-courrier-form');
    }

    public function selectDoc($doc_id)
    {
        $this->selectedDoc = Document::find($doc_id);
    }
}
