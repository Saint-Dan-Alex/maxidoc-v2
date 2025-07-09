<?php

namespace App\Http\Livewire\Admin;
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

class DossierCategorie extends Component
{
    use WithPagination;
    protected $paginationTheme ="bootstrap";
    public $document;
    public $details=[''],$name='',$reference,$description='',$description_second,$datecrea,$ids,$cree,$acces,$cut_description,$role,$niveau_id,$division,$division_id,$departement,$departement_id;
    public $departements=[''];
    public $divisions=[''];
    public $dossiers=[''];
    public $roles=[''],$classer_id,$classeur_name;
    public $Dossier=[''],$update;
    public function mount($classer_id){

        $classeurs = Classeur::where('id',$classer_id)->get();
        $dossiers = Dossier::where('classeur_id',$classer_id)->paginate(6);
        // get the name of classeur
        $classeur_name_all = Classeur::where('id',$classer_id)->first();
        $classeur_name=$classeur_name_all->name;
        // end
        $departements=Departement::where('deleted_at',null)->get();
        $roles = Role::where('deleted_at',null)->get();
        $this->classer_id =$classer_id;
        $classeur_find = Classeur::where('id',$this->classer_id)->first();
        $this->classeur_name = $classeur_find->name;
        $this->departements = Departement::where('deleted_at',null)->get();
        $this->roles= Role::where('deleted_at',null)->get();
        if (Auth::user()->id == 2) {
            $this->dossiers = Dossier::where('classeur_id',$classer_id)->orderby('id','DESC')->get();
            $this->document= Document::where('classeur_id',$classer_id)->orderby('id','DESC')->get();
            $this->divisions= Division::where('deleted_at', null)->get(['id', 'denomination']);
        }elseif(Auth::user()->id == 3){
            $this->document= Document::orderby('id','DESC')->where('role',auth()->user()->role->id)->orwhere('role',4)->get();
            $this->divisions= Division::where('deleted_at', null)->get(['id', 'denomination']);
            $this->dossiers = Dossier::orderby('id','DESC')->where('role',auth()->user()->role->id)->orwhere('role',4)->get();
        }else{
            $this->document= Document::orderby('id','DESC')->where('role',auth()->user()->role->id)->orwhere('role',4)->get();
            $this->divisions= Division::where('deleted_at', null)->get(['id', 'denomination']);
            $this->dossiers = Dossier::orderby('id','DESC')->where('role',auth()->user()->role->id)->orwhere('role',4)->get();
        }

    }
    public function edite($id){

        $this->ids=$id;
        $this->details = Dossier::where('id',$id)->where('niveau',auth()->user()->role->id)->orwhere('niveau',4)->first();
        $this->name =  $this->details->name;
        $this->reference =  $this->details->reference;
        $this->description = Str::substr($this->details->description,0,40);
        $this->description_second = Str::substr($this->details->description,40,40);
        // $this->niveau_id=$this->details->role->id ??'Autorisé';
        $this->datecrea =  $this->details->created_at;
        $this->division =  $this->details->division->denomination ??'';
        $this->division_id = $this->details->division_id;
        $this->departement =  $this->details->departement->nom ?? 'Selectionner un département ';
        $this->departement_id =  $this->details->departement_id;
        $this->cree =  $this->details->personnel->nom ??'Inconnu';
        $this->acces =  $this->details->role->name ??'Autorisé';

    }

    public function render()
    {
        return view('livewire.humanres.dossier-categorie');
    }
}
