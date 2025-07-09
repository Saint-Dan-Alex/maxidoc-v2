<?php

namespace App\Http\Livewire\Admin\Classeurs;
use App\Models\Document;
use App\Models\Classeur;
use App\Models\Departement;
use App\Models\Division;
use DateTime;
use Livewire\Component;
use Livewire\WithPagination;
use TCG\Voyager\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class Classeurs extends Component
{
    use WithPagination;
    protected $paginationTheme ="bootstrap";
    public $document;
    public $details=[''],$name='',$reference,$description='',$description_second,$datecrea,$ids,$cree,$acces,$cut_description,$role,$niveau_id,$division,$division_id,$departement,$departement_id;
    public $departements=[''],$deps;
    public $divisions=[''];
    public $classeurs=[''];
    public $roles=[''];
    public $classeur=[''],$update;
    public function mount(){
        $this->departement_all = Departement::where('deleted_at', null)->get();
        $this->deps = Departement::where('deleted_at',null)->get();

        $this->roles= Role::all();
        $this->document= Document::where('deleted_at', null)->orderby('id','DESC')->where('role',auth()->user()->role->id)->orwhere('role',4)->get();
        if (Auth::user()->id == 2) {
            $this->classeurs = Classeur::where('deleted_at', null)->orderby('id','DESC')->get();

        } else if(Auth::user()->id == 3) {
            $this->classeurs = Classeur::where('deleted_at', null)->orderby('id','DESC')->where('niveau',auth()->user()->role->id)->orwhere('niveau',4)->get();

        }else{
            $this->classeurs = Classeur::where('deleted_at', null)->orderby('id','DESC')->where('niveau',auth()->user()->role->id)->get();
        }
        $this->divisions= Division::where('deleted_at', null)->get(['id', 'denomination']);
    }
    public function edite($id){
        $this->ids=$id;

        $this->details = Classeur::where('id',$id)->first();
        $this->name =  $this->details->name;
        $this->reference =  $this->details->reference;
        $this->description = Str::substr($this->details->description,0,40);
        $this->description_second = Str::substr($this->details->description,40,40);

        $this->niveau_id=$this->details->role->id ??'Autorisé';
        $this->datecrea =  $this->details->created_at;
        $this->division =  $this->details->division->denomination ?? 'Selectionner une division';
        // dd($this->division);
        $this->division_id = $this->details->division_id;
        $this->departement =  $this->details->departement->nom ?? 'Selectionner un département ';
        $this->departement_id =  $this->details->departement_id;
        $this->cree =  $this->details->personnel->nom ??'Inconnu';
        $this->acces =  $this->details->role->name ??'Autorisé';

    }

    public function render()
    {
        return view('livewire.admin.classeurs.classeurs');
    }
}
