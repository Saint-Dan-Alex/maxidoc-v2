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
    public $selectedCategorieId = null;
    public $expediteurs = [];

    protected $listeners = [
        'documentSelected' => 'handleDocumentSelected',
        'categorieSelected' => 'loadExpediteursByCategorie'
    ];

    public function loadExpediteursByCategorie($categorieId)
    {
        $this->selectedCategorieId = $categorieId;
        
        // Si aucune catégorie n'est sélectionnée, on réinitialise la liste des expéditeurs
        if (empty($categorieId)) {
            $this->expediteurs = [];
            $this->emit('expediteursUpdated', []);
            return;
        }

        // Chargement des expéditeurs en fonction de la catégorie sélectionnée
        $this->expediteurs = \App\Models\CourrierExpediteur::where('category_id', $categorieId)
            ->get()
            ->map(function($expediteur) {
                return [
                    'id' => $expediteur->id,
                    'text' => $expediteur->nom,
                    'category_id' => $expediteur->category_id
                ];
            })->toArray();
            
        $this->emit('expediteursUpdated', $this->expediteurs);
    }

    public function mount($courrier, $types, $natures, $categories, $services, $directions, $agents, $priorites, $traitements, $newDoc = false, $textSelected = '', $fileName = '', $type = null)
    {
        $this->courrier = $courrier;
        $this->courrierId = $courrier->id;
        $this->types = $types;
        $this->natures = $natures;
        $this->categories = $categories;
        $this->services = $services;
        $this->directions = $directions;
        $this->agents = $agents;
        $this->priorites = $priorites;
        $this->traitements = $traitements;
        $this->newDoc = $newDoc;
        $this->textSelected = $textSelected;
        $this->fileName = $fileName;
        $this->type = $type ?? [];
        
        // Initialisation des valeurs par défaut depuis le courrier
        if ($this->courrier) {
            $this->isConfidentiel = $this->courrier->confidentiel ?? false;
        }
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
        // Récupérer les données nécessaires pour les sélecteurs
        $followers = Agent::actif()
            ->where('id', '!=', auth()->user()->agent->id ?? null)
            ->get()
            ->map(function($agent) {
                return [
                    'id' => $agent->id,
                    'titre' => $agent->prenom . ' ' . $agent->nom . ($agent->service ? ' (' . $agent->service->titre . ')' : '')
                ];
            });

        return view('livewire.courrier.complete-form', [
            'courrier' => $this->courrier,
            'followers' => $followers,
            'isConfidentiel' => $this->isConfidentiel,
            'isFormValid' => $this->isFormValid,
            'type' => $this->type,
        ]);
    }
}
