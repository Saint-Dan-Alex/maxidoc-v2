<?php

namespace App\Http\Livewire\Dashboard\Repertoire;

use App\Models\Tache;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Livewire\Component;

class NewTasks extends Component
{
    use WithPagination;
    protected $listeners = ['reloadComponent' => '$refresh'];
    protected $paginationTheme = 'bootstrap-5';

    public function render()
    {
        $taches = Tache::where('user_id', Auth::user()->id)
                        -> where('tache_statut_id', '==', 1)
                        ->orderBy('id', 'DESC')
                        ->paginate(10);
        return view('livewire.dashboard.repertoire.new-tasks',[
            'taches' => $taches
           ]);
    }
}
