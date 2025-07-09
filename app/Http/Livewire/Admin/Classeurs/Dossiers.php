<?php

namespace App\Http\Livewire\Admin\Classeurs;

use App\Models\Document;
use App\Models\Departement;
use App\Models\Division;
use App\Models\Classeur;
use App\Models\Dossier;
use Livewire\WithPagination;
use TCG\Voyager\Models\Role;
use Illuminate\Support\Str;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
class Dossiers extends Component
{
    use WithPagination;
    protected $paginationTheme ="bootstrap";
    public $document;
    public $details=[''],$name='',$reference,$description='',$description_second,$datecrea,$ids,$cree,$acces,$cut_description,$role,$niveau_id,$division,$division_id,$departement,$departement_id;
    public $departements=[''];
    public $divisions=[''];
    public $dossiers=[''];
    public $roles=[''],$classer_id,$classeur_name;
    public $dossier=[''],$update,$descriptions;
    public function mount($classer_id){
        $this->dossiers = Dossier::where('classeur_id',$classer_id)->orderby('name','ASC')->get();
        $this->classer_id =$classer_id;
        $classeur_find = Classeur::where('id',$this->classer_id)->first();
        $this->classeur_name = $classeur_find->name;
        $this->departements = Departement::where('deleted_at', null)->get();
        $this->roles=Role::all();
        $this->divisions= Division::where('deleted_at', null)->get(['id', 'denomination']);
    }
    public function edite($id){

        $this->ids=$id;
        $this->details = Dossier::where('id',$id)->first();
        $this->name =  $this->details->name;
        $this->reference =  $this->details->reference;
        $this->descriptions = $this->details->description;
        $this->description = Str::substr($this->details->description,0,40);
        $this->description_second = Str::substr($this->details->description,40,40);
        $this->niveau_id=$this->details->role->id ??'Autorisé';
        $this->datecrea =  $this->details->created_at;
        // $this->division =  $this->details->division->denomination ??'';
        $this->division_id = $this->details->division_id;
        $this->departement =  $this->details->departement->nom ?? 'Selectionner un département ';
        $this->departement_id =  $this->details->departement_id;
        $this->cree =  $this->details->personnel->nom ??'Inconnu';
        $this->acces =  $this->details->role->name ??'Autorisé';

    }
    public function render()
    {
        return view('livewire.admin.classeurs.dossiers');
    }
}
