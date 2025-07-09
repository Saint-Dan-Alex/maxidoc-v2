<?php

namespace App\Http\Livewire\Admin\Fonction;

use Livewire\Component;
use App\Models\Departement;
use App\Models\Division;
use App\Models\Personel;
use App\Models\User;
use App\Models\Fonction;
use TCG\Voyager\Models\Role;
class ShowFonction extends Component
{
    public $personnels,$nom,$update,$created,$created_at,$description,$ids,$counter_agent,$number_personal=0,$number_fonction,$chef_id,$departements,$departement,$departement_id,$departement_name ;
    public $id_fonction,$fonctions=[''];
    public function mount(){
        $this->fonctions=Fonction::where('id','>',2)->where('deleted_at', null)->orderby('id','DESC')->get();
        $this->id_fonction = $this->ids;
        $this->personnels = User::all();
        $this->departements = Departement::all();


    }
    public function edite($id){

        $this->fonction =Fonction::where('id',$id)->first();
        $this->id_fonction = $this->fonction->id ?? '';
        $number_pers=Personel::where('fonction_id',$id)->get();

        $this->number_personal = count($number_pers);
        $this->nom = $this->fonction->name ?? '';
        $this->description = $this->fonction->details ?? '';

        $this->chef = $this->fonction->divChef->name ?? 'Pas de chef';
        $this->chef_id = $this->fonction->divChef->id ?? '';

        $this->created = $this->fonction->creator->name ?? '';
        $this->created_at = $this->fonction->created_at->format('d-m-Y');
        $this->update = $this->fonction->updator->nom ?? '';
        // $this->counter_agent = $this->division->agents ?? '';
    }
    public function render()
    {

        return view('livewire.humanres.fonction.show-fonction');
    }
}
