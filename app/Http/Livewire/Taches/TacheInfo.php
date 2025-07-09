<?php

namespace App\Http\Livewire\Taches;


use Livewire\Component;

class TacheInfo extends Component
{
    public $tache;

    protected $listeners = ['reloadInfo' => '$refresh'];
    protected $rules = [
        'message' => 'required|string',
        'file' => 'required|file',
    ];
    public function mount($tache)
    {
        $this->tache = $tache;
    }

    public function render()
    {
        return view('livewire.taches.tache-info');
    }
}