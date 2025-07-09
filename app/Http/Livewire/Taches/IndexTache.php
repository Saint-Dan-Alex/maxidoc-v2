<?php

namespace App\Http\Livewire\Taches;

use App\Events\TacheCreated;
use App\Models\Tache;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class IndexTache extends Component
{
    use WithPagination;
    // public $taches;
    public $assignees;
    public $tab;
    // public $newTaches;
    // public $tacheEncours;
    // public $horsDelais;
    // public $endTaches;
    public $users;

    protected $listeners = ['reloadComponent' => '$refresh'];
    protected $paginationTheme = 'bootstrap-5';
    protected $queryString = [
        'tab',
        // 'new_taches_page' => ['except' => 1],
        // 'tache_encours_page' => ['except' => 1],
        // 'end_taches_page' => ['except' => 1],
        // 'hors_delais_page' => ['except' => 1],
    ];

    public function mount()
    {
        if (!$this->tab) {
            if (Auth::user()->agent->isDG()) {
                $this->tab = 1;
            } else {
                $this->tab = 2;
            }
        }
    }

    public function refresh()
    {
        $this->reset();
    }

    public function updateStatut($id, $key = null)
    {
        try {

            $tache = Tache::findOrFail($id);

            if ($tache->pourcentage == 0) {
                if ($key) {
                    $tache->update([
                        "pourcentage" => 1,
                    ]);
                    // $tache->objectifs->first()->update([
                    //     'statut' => 1,
                    // ]);
                    event(new TacheCreated($tache, $tache->user->agent->id, 'Accusé de réception émis pour la tâche ' . $tache->titre));
                } else {
                    $tache->update([
                        "tache_statut_id" => 2,
                        // "statut_id" => 2,
                    ]);
                    $this->tab = 3;
                    event(new TacheCreated($tache, $tache->user->agent->id, 'La tâche ' . $tache->titre . ' est en cours de traitement'));
                }
            } else {
                $tache->update([
                    "tache_statut_id" => 2,
                    // "statut_id" => 2,
                ]);
                $this->tab = 3;
                event(new TacheCreated($tache, $tache->user->agent->id, 'La tâche ' . $tache->titre . ' est en cours de traitement'));
            }
            $this->emit('alert', 'success', 'La tâche est en cours de traitement');
        } catch (\Throwable $th) {
            // throw $th;
            $this->emit('alert', 'error', 'Echec de l\`opération');
        }

    }

    public function changeTab($value)
    {
        $this->tab = $value;
    }

    public function render()
    {
        $newTaches = collect();
        $tacheEncours = collect();
        $endTaches = collect();
        $horsDelais = collect();
        $newTachesCount = 0;
        $taches = collect();

        if (Auth::user()->agent->isDG()) {
            $taches = Tache::where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->paginate(10);
            // $this->taches = $taches;
        } else {
            // $taches = Tache::where('user_id', Auth::user()->id)->where('statut_id', 1)->orderBy('id', 'DESC')->get();

            $taches = Tache::where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->paginate(10);
            $assignees = Tache::getTachesForCurrentUser();

            // $this->assignees = $assignees;

            $newTaches = $assignees->where('tache_statut_id', '1')->sortByDesc('id');
            $tacheEncours = $assignees->where('tache_statut_id', '2')->sortByDesc('id');
            $endTaches = $assignees->where('tache_statut_id', '3')->sortByDesc('id');
            $horsDelais = $assignees->where('tache_statut_id', '4')->sortByDesc('id');

            if (Auth::user()->agent->isSecretaire() && $newTaches->where('pourcentage', 0)->count()){
                $newTachesCount = $newTaches->where('pourcentage', 0)->count();
            }elseif(!Auth::user()->agent->isSecretaire() && $newTaches->where('pourcentage', '<', 2)->count()){
                $newTachesCount = $newTaches->where('pourcentage', '<', 2)->count();
            }
        }

        // dd(customPaginate($newTaches, 9, 1,['pageName' =>'new_taches_page']));

        return view('livewire.taches.index-tache')->with([
            'taches' => $taches,
            'newTachesCount' => $newTachesCount,
            'newTaches' => $newTaches, //customPaginate($newTaches, 9, 1,['pageName' =>'new_taches_page']),
            'tacheEncours' => $tacheEncours, //customPaginate($tacheEncours,9,  1,['pageName' =>'tache_encours_page']),
            'endTaches' => $endTaches, //customPaginate($endTaches,9,  1,['pageName' =>'end_taches_page']),
            'horsDelais' => $horsDelais, //customPaginate($horsDelais,9,  1,['pageName' =>'hors_delais_page']),
        ]);
    }
}
