<?php

namespace App\Http\Livewire\Admin\Personnel;

use Livewire\Component;
use App\Models\Departement;
use App\Models\Division;
use App\Models\Etat;
use App\Models\Personel;

use App\Models\Genre;
use App\Models\PersonelStatut;
use Illuminate\Pagination\Paginator;
use App\Models\User;
use Livewire\WithPagination;
use TCG\Voyager\Models\Role;

class Personnel extends Component
{

    use WithPagination;
    protected $paginationTheme="bootstrap";
    public $personnels=[''];
    public $id_personnel ,
    $nom ,
    $postnom ,
    $telephone ,
    $fonction ,
    $fonction_id ,
    $date_naissance ,
    $sexe ,
    $nationalite ,
    $etat_civil ,
    $adresse ,
    $email ,
    $etat ,
    $created ,
    $division ,
    $division_id ,
    $departement ,
    $departement_id ,
    $lieu,$matricule,
    $date_creation,
    $description ;
    public $id_depart,$divisions=[''];
    public function mount(){


        // $this->personnels = User::all();
        $this->departements = Departement::all();


    }
    public function edite($id){


        $this->personnels = Personel::where('id',$id)->first();
        $this->id_personnel = $this->personnels->id ?? 'Non renseigné';
        $this->nom =  $this->personnels->nom ?? '';
        $this->postnom = $this->personnels->postnom ?? '';
        $this->telephone = $this->personnels->telephone ?? 'Non renseigné';
        $this->fonction = $this->personnels->fonction->name ?? 'Non renseigné';
        $this->fonction_id = $this->personnels->fonction->id ?? 'Non renseigné';
        $this->date_naissance = $this->personnels->date_naissance ?? 'Non renseigné';
        $this->lieu =$this->personnels->lieu_naissance ?? 'Non renseigné';
        $this->sexe = $this->personnels->genre->name ?? 'Non renseigné';
        $this->nationalite = $this->personnels->nationalite ?? 'Non renseigné';
        $this->etat_civil = $this->personnels->etat_civil ?? 'Non renseigné';
        $this->adresse = $this->personnels->adresse ?? 'Non renseigné';
        $this->email = $this->personnels->email ?? 'Non renseigné';
        $this->etat = $this->personnels->statut->name ?? 'Non renseigné';
        $this->departement = $this->personnels->departement->nom ?? 'Non renseigné';
        $this->departement_id = $this->personnels->departement?->id ?? 'Non renseigné';
        $this->division = $this->personnels->division->denomination ?? 'Non renseigné';
        $this->division_id = $this->personnels->division->id ?? 'Non renseigné';
        $this->date_creation =$this->personnels->created_at ?? 'Non renseigné';
        $this->created = $this->personnels->creator->name ?? 'Non renseigné';
        $this->description = $this->personnels->description ?? 'Non renseigné';
        $this->matricule = $this->personnels->user->matricule ?? 'Non renseigné';

        // $this->counter_agent = $this->division->agents ?? 'Non renseigné';
    }
    public function render()
    {
        $pers =Personel::where('id','>',2)->orderby('id','DESC')->paginate(10);
        $fonctions = Role::where('id','>',2)->get();
        $sexes= Genre::all();
        $departements = Departement::all();
        $divisions_all = Division::all();
        $etats = PersonelStatut::all();
        return view('livewire.humanres.personnel.personnel',[
            'pers'=>$pers,'fonctions'=>$fonctions,'sexes'=>$sexes,
            'divisions_all'=>$divisions_all,'departements'=>$departements,'etats'=>$etats
        ]);
    }
}
