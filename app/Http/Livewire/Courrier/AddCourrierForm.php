<?php

namespace App\Http\Livewire\Courrier;

use App\Models\Agent;
use App\Models\Courrier;
use App\Models\CourrierCategory;
use App\Models\CourrierTypesTraitement;
use App\Models\Direction;
use App\Models\Document;
use App\Models\Priorite;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class AddCourrierForm extends Component
{
    use WithFileUploads;

    public $types;
    public $natures;
    public $services;
    public $agents;
    public $agentSelected;
    public $followers;
    public $priorites;
    public $destination;
    public $copies;
    public $isConfidentiel = 0;
    public $dg;
    public $dga;
    public $categories;
    public $traitements;
    public $selectedDoc;
    public $uploadedFile;
    public $newDoc;
    public $textSelected;
    public $fileName;
    public $directions;
    public $service_init;
    public $ref;
    public $type = 1;
    public $num;
    public $isFormValid = false;
    public $isDestinateur;
    public $title = '';

    protected $listeners = ['selectDoc'];
    
    public function updatedTitle($value)
    {
        $this->isFormValid = !empty(trim($value));
    }
    
    public function updatedType($value)
    {
        $this->changeNumRef(); // Mettre à jour la référence
        $this->loadCategories(); // Recharger les catégories
    }
    
    protected function loadCategories()
    {
        $this->categories = CourrierCategory::where('type_id', $this->type)
            ->orWhereNull('type_id')
            ->select('id', 'title')
            ->orderBy('title')
            ->get();
            
        // Log pour débogage
        Log::info('Catégories chargées:', [
            'type_id' => $this->type,
            'count' => $this->categories->count()
        ]);
    }

    public function mount()
    {
        return $this->changeNumRef();
        // $services = Direction::find(1)->services->pluck('id')->toArray();
        $prefix = $this->abbreviateTitle(Auth::user()->agent->direction?->lieu?->titre);
        
        // Log pour débogage
        Log::info('mount - Paramètres:', [
            'services' => $services,
            'type' => $this->type,
            'prefix' => $prefix
        ]);
        
        $lastNum = Courrier::where(function($query) use ($services) {
                $query->whereIn('service_id', $services)
                      ->orWhereNull('service_id');
            })
            ->where('type_id', '=', $this->type)
            ->where('reference_interne', 'LIKE', $prefix . '-%')
            ->count();
            
        // Log du résultat du comptage

            
        $this->num = (int) $lastNum;
        $this->num += 1;
        $this->num = Str::padLeft($this->num, 4, '0');
        
        // Déterminer le suffixe en fonction du type
        $suffix = match((int)$this->type) {
            1 => 'ENT',  // Entrant
            2 => 'SOR',  // Sortant
            default => 'INT'  // Interne
        };
        
        $this->num = $prefix . '-' . $this->num . '-' . $suffix;
    }
 
    public function changeNumRef()
    {
        // S'assurer que le type est défini, sinon utiliser 1 par défaut (entrant)
        $type = $this->type ?? 1;
        $agent = Auth::user()->agent;
        $direction = $agent->direction;
        
        // Récupérer l'abréviation de la direction (Priorité au code, sinon abréviation du titre)
        if ($direction && !empty($direction->code)) {
            $prefix = strtoupper($direction->code);
        } else {
            $prefix = $this->abbreviateTitle($direction?->titre ?? $agent->lieu?->titre ?? 'DOC');
        }

        // Déterminer le suffixe en fonction du type
        $suffix = match((int)$type) {
            1 => 'ENT',  // Entrant
            2 => 'SOR',  // Sortant
            3 => 'INT',  // Interne
            default => 'INT'
        };

        // Récupérer la dernière référence pour ce préfixe et ce suffixe
        $lastRef = Courrier::where('reference_interne', 'LIKE', $prefix . '-%-' . $suffix)
            ->orderBy('reference_interne', 'desc')
            ->value('reference_interne');
            
        $nextNum = 1;
        
        if ($lastRef) {
            // Extraire le numéro de la dernière référence (ex: DG-0042-ENT -> 0042)
            if (preg_match('/-([0-9]+)-[A-Z]+$/', $lastRef, $matches)) {
                $nextNum = (int)$matches[1] + 1;
            }
        }
        
        $this->num = Str::padLeft($nextNum, 4, '0');
        $this->num = $prefix . '-' . $this->num . '-' . $suffix;
        
        // Log pour débogage
        Log::info('changeNumRef - Nouvelle référence:', [
            'type' => $type,
            'prefix' => $prefix,
            'suffix' => $suffix,
            'num' => $this->num
        ]);
    }

    public function changeServiceInit($id)
    {
        $this->service_init = $id;
        $service = Service::find($this->service_init);
        $direction = $service->direction;

        //  dd($this->type == 3);

        $this->num = Str::padLeft((Courrier::where('service_id', $service->id)->count() + 1), 4, '0');
        if ($direction) {
            if ($direction->code) {
                if ($this->type == 2) {
                    $this->ref = ($direction->code != 'DG' ? 'DG/' : '') . Str::upper($direction->code) . '/' . $this->num . '/' . date('Y');
                } elseif ($this->type == 3) {
                    $this->ref = Str::upper($direction->code) . '/' . $this->num . '/' . date('Y');
                }
            } else {
                $this->ref = '';
            }
        } else {
            $this->ref = '';
        }
    }

    public function selectDoc($doc_id)
    {
        $this->selectedDoc = Document::find($doc_id);
    }

    public function abbreviateTitle($title)
    {
        // Divise le titre en mots
        $words = explode(' ', $title);

        // Initialise une variable pour stocker l'abréviation
        $abbreviation = '';

        // Parcourt chaque mot et prend la première lettre
        foreach ($words as $word) {
            $abbreviation .= strtoupper($word[0]);
        }

        return $abbreviation;
    }

    public function render()
    {
        $this->selectedDoc = $this->newDoc; //Document::find($this->newDoc);
        $this->priorites = Priorite::select('id', 'titre')->get();
        $this->types = $this->types->filter(function ($type) {
            if ($type->id == 2) {
                return true; // Vérification des autorisations gérée par les middlewares
            } elseif ($type->id == 1) {
                return true; // Vérification des autorisations gérée par les middlewares
            } else {
                return true; // Vérification des autorisations gérée par les middlewares
            }
        });
        // $this->agents = $this->agents->where('id', '!=', Auth::user()->agent->id);
        $this->directions = Direction::select('id', 'titre')->get();
        $this->services = Service::select('id', 'titre')->get();
        
        $this->followers = $this->directions; //Direction::select('id','titre')->get();
        // $this->followers = Agent::actif()
        // ->select('id','user_id','direction_id','nom','post_nom','prenom','division_id','service_id','fonction_id')
        // ->where('id', '!=', Auth::user()->agent->id)
        // ->get();
        // $this->followers = $this->agents->where('id', '!=', Auth::user()->agent->id);//->where('id', '!=', $this->dg)->where('id', '!=', $this->dga)->where('id', '!=', Auth::user()->agent->id);

        $this->categories = CourrierCategory::select('id', 'title')->get();
        $this->traitements = CourrierTypesTraitement::select('id', 'titre')->get();

        return view('livewire.courrier.add-courrier-form');
    }

}

