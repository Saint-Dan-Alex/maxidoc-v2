<?php

namespace App\Http\Livewire\Admin\Division;

use App\Models\Personel;
use Livewire\Component;

class CounterPersonnel extends Component
{
    public $personnel;
    public function mount($id){
        $this->personnel = Personel::where('division_id',$id)->get();

    }
    public function render()
    {
        return view('livewire.humanres.division.counter-personnel');
    }
}
