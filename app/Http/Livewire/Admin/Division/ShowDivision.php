<?php

namespace App\Http\Livewire\Admin\Division;

use Livewire\Component;
use App\Models\Departement;
use App\Models\Division;
use App\Models\Personel;
use App\Models\User;
class ShowDivision extends Component
{
    public $personnels,$nom,$chef,$created,$created_at,$description,$ids,$counter_agent,$number_personal=0,$number_division,$chef_id,$id_division,$departements,$departement,$departement_id,$departement_name ;
    public $id_depart,$divisions=[''];
    public function mount(){
        $this->divisions=Division::where('deleted_at', null)->orderby('id','DESC')->get();
        $this->id_depart = $this->ids;
        $this->personnels = User::all();
        $this->departements = Departement::all();


    }
    public function edite($id){

        $this->division = Division::where('id',$id)->first();
        $this->id_division = $this->division->id ?? '';
        $number_pers=Personel::where('division_id',$id)->get();
        $this->departement=Division::where('departement_id',$this->division->departement_id)->first();

        $this->departement_id = $this->departement?->id ?? '';
        $this->departement_name = $this->departement->departement->nom ?? '';
        $this->number_personal = count($number_pers);
        $this->nom = $this->division->denomination ?? '';
        $this->description = $this->division->description ?? '';

        $this->chef = $this->division->divChef->name ?? 'Pas de chef';
        $this->chef_id = $this->division->divChef->id ?? '';

        $this->created = $this->division->creator->nom ?? '';
        $this->created_at = $this->division->created_at->format('d-m-Y');
        $this->update_by = $this->division->update_by ?? '';
        // $this->counter_agent = $this->division->agents ?? '';
    }
    public function render()
    {
        return view('livewire.humanres.division.show-division',[

        ]);
    }
}
