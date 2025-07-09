<?php

namespace App\Http\Livewire\Admin;
use App\Models\Document;
use App\Models\Classeur;
use App\Models\Departement;
use App\Models\Division;
use Livewire\Component;
use Livewire\WithPagination;
use TCG\Voyager\Models\Role;
use Illuminate\Support\Str;


class Classeurs extends Component
{
    use WithPagination;
    protected $paginationTheme ="bootstrap";
    public $document;
    public $details=[''],$name='',$reference,$description='',$description_second,$datecrea,$ids,$cree,$acces,$cut_description,$role,$niveau_id,$division,$division_id,$departement,$departement_id;
    public $departements=[''];
    public $divisions=[''];
    public $classeurs=[''];
    public $roles=[''];
    public $classeur=[''],$update;
    public function mount(){
        $this->departements = Departement::all();
        $this->roles= Role::all();
        $this->document= Document::orderby('id','DESC')->where('role',auth()->user()->role->id)->orwhere('role',4)->get();
        $this->classeurs = Classeur::orderby('id','DESC')->where('niveau',auth()->user()->role->id)->orwhere('niveau',4)->get();
        $this->divisions= Division::where('deleted_at', null)->get(['id', 'denomination']);
    }
    public function edite($id){
        $this->ids=$id;
        $this->details = Classeur::where('id',$id)->where('niveau',auth()->user()->role->id)->orwhere('niveau',4)->first();
        $this->name =  $this->details->name;
        $this->reference =  $this->details->reference;
        $this->description = Str::substr($this->details->description,0,40);
        $this->description_second = Str::substr($this->details->description,40,40);

        $this->niveau_id=$this->details->role->id ??'Autorisé';
        $this->datecrea =  $this->details->created_at;
        $this->division =  $this->details->division->denomination ??'';
        // dd($this->division);
        $this->division_id = $this->details->division_id;
        $this->departement =  $this->details->departement->denomination ?? 'Selectionner un département ';
        $this->departement_id =  $this->details->departement_id;
        $this->cree =  $this->details->personnel->nom ??'Inconnu';
        $this->acces =  $this->details->role->name ??'Autorisé';

    }

    public function render()
    {
        return view('livewire.admin.classeurs');
    }

}
