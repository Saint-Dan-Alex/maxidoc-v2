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
        $this->tab = $this->tab ?? (Auth::user()->agent->isDG() ? 1 : 2);
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

        $assignees = $query;

        if ($this->tab == 1) {
            $taches = Tache::where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->paginate(10);
        } elseif ($this->tab == 2) {
            $newTaches = $assignees->where('tache_statut_id', 1)->sortByDesc('id'); //->values(); // `values()` to reindex collection
            $newTaches = $this->customPaginate($newTaches, 10);
        } elseif ($this->tab == 3) {
            $tacheEncours = $assignees->where('tache_statut_id', 2)->sortByDesc('id'); //->values();
            $tacheEncours = $this->customPaginate($tacheEncours, 10);
        } elseif ($this->tab == 4) {
            $endTaches = $assignees->where('tache_statut_id', 3)->sortByDesc('id'); //->values();
            $endTaches = $this->customPaginate($endTaches, 10);
        } elseif ($this->tab == 5) {
            $horsDelais = $assignees->where('tache_statut_id', 4)->sortByDesc('id'); //->values();
            $horsDelais = $this->customPaginate($horsDelais, 10);
        }

        if (Auth::user()->agent->isSecretaire() && $newTaches->where('pourcentage', 0)->count()) {
            $newTachesCount = $newTaches->where('pourcentage', 0)->count();
        } elseif (! Auth::user()->agent->isSecretaire() && $newTaches->where('pourcentage', '<', 2)->count()) {
            $newTachesCount = $newTaches->where('pourcentage', '<', 2)->count();
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

