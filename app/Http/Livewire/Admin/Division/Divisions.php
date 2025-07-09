<?php

namespace App\Http\Livewire\Admin\Division;
use App\Models\Departement;
use App\Models\Division as Division;
use App\Models\Personel;
use Livewire\Component;
use App\Models\User;

class Divisions extends Component
{
    public $personnels,$nom,$chef,$created,$created_at,$description,$ids,$counter_agent,$number_personal=0,$number_division,$chef_id,$id_departement ;
    public $id_depart,$departements=[''];
    public function mount(){
        $this->departements=Departement::where('deleted_at', null)->orderby('id','DESC')->get();
        $this->id_depart = $this->ids;
        $this->personnels = User::all();


    }
    public function edite($id){

        $this->departement = Departement::where('id',$id)->first();
        $this->id_departement = $this->departement?->id?? '';
        $number_div=Division::where('departement_id',$id)->get();

        $this->number_division = count($number_div);
        $number_pers=Personel::where('departement_id',$id)->get();
        $this->number_personal = count($number_pers);
        $this->nom = $this->departement->nom ?? '';
        $this->description = $this->departement->description ?? '';

        $this->chef = $this->departement->depChef->nom ?? 'Pas de chef';
        $this->chef_id = $this->departement->depChef->id ?? '';

        $this->created = $this->departement->creator->nom ?? '';
        $this->created_at = $this->departement->created_at->format('d-m-Y');
        $this->update_by = $this->departement->update_by ?? '';
        // $this->counter_agent = $this->departement->agents ?? '';
    }
    public function render()
    {


        return view('livewire.humanres.division.divisions');

    }
}
