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

class CompleteCourrierForm extends Component
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
    public $isFormValid = true;

    public function mount($id)
    {
        $this->courrierId = $id;

        $this->courrier = Courrier::with([
            'document', 
            'type', 
            'nature', 
            'categorie',
            'expediteur',
            'externExpediteur',
            'externDestinateur',
            'priorite',
            'service',
            'destinateurs'
        ])->findOrFail($id);

        if ($this->courrier->etape !== 'en_attente') {
            session()->flash('session', json_encode([
                'name' => 'Courrier',
                'statut' => 'error',
                'message' => 'Ce document a déjà été traité',
            ]));

            return redirect()->route('regidoc.courriers.index');
        }

        $this->loadFormData();
    }

    public function loadFormData()
    {
        $this->types = CourrierType::select('id', 'titre')->get();
        $this->natures = CourrierNature::select('id', 'titre')->get();
        $this->categories = CourrierCategory::select('id', 'title')->get();
        $this->services = Service::select('id', 'titre', 'responsable_id')->get();
        $this->directions = Direction::select('id', 'titre')->get();
        $this->agents = Agent::actif()->select('id', 'user_id', 'direction_id', 'nom', 'post_nom', 'prenom', 'division_id', 'service_id', 'fonction_id')->get();
        $this->priorites = Priorite::select('id', 'titre')->get();
        $this->traitements = CourrierTypesTraitement::select('id', 'titre')->get();
    }

    public function render()
    {
        return view('livewire.courrier.complete-courrier-form');
    }
}

