<?php

namespace App\Http\Livewire\Taches;

use App\Events\TacheCreated;
use App\Models\Tache;
use Illuminate\Support\Facades\Auth; 
use Livewire\WithPagination;
use Livewire\Component;
use Illuminate\Support\Facades\Session;

class DesTaches extends Component
{
    use WithPagination;
     
    public $assignees;
    public $tab;
    public $users;

    protected $listeners = ['reloadComponent' => '$refresh'];
    protected $paginationTheme = 'bootstrap-5';
    protected $queryString = ['tab' => ['except' => 1]];

    public function mount()
    {
        $this->tab = $this->tab ?? 1;
    }

    public function refresh()
    {
        $this->resetPage();
    }

    public function updateStatut($id, $key = null)
    {
        $tache = Tache::find($id);

        if (!$tache) {
            $this->emit('alert', 'error', 'Tâche introuvable');
            return;
        }

        if ($tache->pourcentage == 0 && $key) {
            $tache->update(['pourcentage' => 1]);
            event(new TacheCreated($tache, $tache->user->agent->id, 'Accusé de réception émis pour la tâche ' . $tache->titre));
        } else {
            $tache->update(['tache_statut_id' => 2]);
            $this->tab = 3;
            event(new TacheCreated($tache, $tache->user->agent->id, 'La tâche ' . $tache->titre . ' est en cours de traitement'));
        }

        $this->emit('alert', 'success', 'La tâche est en cours de traitement');
    }

    public function changeTab($tab)
    {
        if ($this->tab !== $tab) {
            $this->resetPage();
            $this->tab = $tab;
        }
    } 

    public function filter($query)
    { 
            return $query->where('tache_statut_id', '==', 1);        
    }

    public function render()
    {
        $taches = collect();
        $newTaches = collect();
        $tacheEncours = collect();
        $endTaches = collect();
        $horsDelais = collect();
        $newTachesCount = 0;

        $query = Tache::getTachesForCurrentUser();

        if (Session::has('tacheFilter')) { 
            $query = $this->filter($query, Session::get('tacheFilter'));  
        }

        $assignedTasks = Tache::getTachesForCurrentUser(); // Tasks where user is an agent
        $createdTasks = Tache::where('user_id', Auth::user()->id)->get(); // Tasks created by user
        
        // All tasks related to the user (created OR assigned)
        $allRelatedTasks = $createdTasks->merge($assignedTasks)->unique('id');

        if ($this->tab == 1) { // A traiter (status initial)
            $taches = $allRelatedTasks->where('tache_statut_id', 1)->sortByDesc('id');
            $taches = $this->customPaginate($taches, 10);
        } elseif ($this->tab == 2) { // Assigner (Strictly assigned to user)
            $newTaches = $assignedTasks->sortByDesc('id'); 
            $newTaches = $this->customPaginate($newTaches, 10);
        } elseif ($this->tab == 3) { // En cours
            $tacheEncours = $allRelatedTasks->where('tache_statut_id', 2)->sortByDesc('id');
            $tacheEncours = $this->customPaginate($tacheEncours, 10);
        } elseif ($this->tab == 4) { // Achevées
            $endTaches = $allRelatedTasks->where('tache_statut_id', 3)->sortByDesc('id');
            $endTaches = $this->customPaginate($endTaches, 10);
        } elseif ($this->tab == 5) { // Hors delai
            $horsDelais = $allRelatedTasks->where('tache_statut_id', 4)->sortByDesc('id');
            $horsDelais = $this->customPaginate($horsDelais, 10);
        }

        if (Auth::user()->agent->isSecretaire()) {
            $newTachesCount = $assignedTasks->where('tache_statut_id', 1)->where('pourcentage', 0)->count();
        } else {
            $newTachesCount = $assignedTasks->where('tache_statut_id', 1)->where('pourcentage', '<', 2)->count();
        }

        return view('livewire.taches.des-taches')->with([
            'taches' => $taches,
            'newTachesCount' => $newTachesCount,
            'newTaches' => $newTaches,
            'tacheEncours' => $tacheEncours,
            'endTaches' => $endTaches,
            'horsDelais' => $horsDelais,
        ]);
    }

    public function customPaginate($items, $perPage)
    {
        $page = request()->get('page', 1);
        $offset = ($page * $perPage) - $perPage;

        return new \Illuminate\Pagination\LengthAwarePaginator(
            $items->slice($offset, $perPage)->all(),
            $items->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
    }
}

