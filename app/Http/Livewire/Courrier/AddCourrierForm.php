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

    protected $listeners = ['selectDoc'];

    public function mount()
    {
        $lastNum = Courrier::whereIn('service_id', Direction::find(1)->services->pluck('id')->toArray())
            ->orWhereNull('service_id')
            ->where('reference_interne', 'LIKE', '%' . $this->abbreviateTitle(Auth::user()->agent->direction?->lieu?->titre) . '-%')
            ->count();
        $this->num = (int) $lastNum;
        $this->num += 1;
        $this->num = Str::padLeft($this->num, 4, '0');
        $this->num = $this->abbreviateTitle(Auth::user()->agent->direction?->lieu?->titre) . '-' . $this->num . '-' . substr($this->type == 1 ? 'ENTRANT' : ($this->type == 2 ? "SORTANT" : "INTERNE"), 0, 3);
    }
 
    public function changeNumRef()
    {
        $lastNum = Courrier::whereIn('service_id', Direction::find(1)->services->pluck('id')->toArray())
            ->orWhereNull('service_id')->where('type_id','=',$this->type)
            ->where('reference_interne', 'LIKE', '%' . $this->abbreviateTitle(Auth::user()->agent->direction?->lieu?->titre) . '-%')
            ->count();
        
        $this->num = (int) $lastNum;
        $this->num += 1;
        $this->num = Str::padLeft($this->num, 4, '0');
        $this->num = $this->abbreviateTitle(Auth::user()->agent->direction?->lieu?->titre) . '-' . $this->num . '-' . substr($this->type == 1 ? 'ENTRANT' : ($this->type == 2 ? "SORTANT" : "INTERNE"), 0, 3);
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
                return Auth::user()->can('Enregistrer un courrier sortant');
            } elseif ($type->id == 1) {
                return Auth::user()->can('Enregistrer un courrier entrant');
            } else {
                return Auth::user()->can('Enregistrer un courrier interne');
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

