<?php

namespace App\Http\Livewire\Admin;

use App\Models\liste_tache;
use Livewire\Component;

class Btnliste extends Component
{
    public $date_debut,$date_fin,$assigned_id,$ids,$taches=[''],$name;
    public function mount($id){
        $this->ids = $id;
    }
    public function liste($ids){
        $this->taches = liste_tache::where('tache_id',$ids)->get();

    }
    public function render()
    {
        return view('livewire.admin.btnliste');
    }
}
