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
    public $tab = 1;
    /** @var \Illuminate\Support\Collection */
    public $newTaches;
    public $newTachesCount = 0;
    // public $tacheEncours;
    // public $horsDelais;
    // public $endTaches;
    public $users;

    protected $listeners = [
        'reloadComponent' => '$refresh',
        'participantUpdated' => 'handleParticipantUpdated',
        'participantAdded' => 'handleParticipantAdded',
        'refreshTacheInfo' => 'refreshTacheInfo',
        'refreshTaches' => '$refresh'
    ];
    
    public $isInitialized = false;
    
    protected $paginationTheme = 'bootstrap-5';
    
    protected $queryString = [
        'tab' => ['except' => 1],
        // 'new_taches_page' => ['except' => 1],
        // 'tache_encours_page' => ['except' => 1],
        // 'end_taches_page' => ['except' => 1],
        // 'hors_delais_page' => ['except' => 1],
    ];

    public function mount()
    {
        // Initialiser la propriété newTaches comme une collection vide
        $this->newTaches = collect();
        
        if (!$this->tab) {
            if (Auth::user()->agent->isDG() || Auth::user()->agent->isDelegue()) {
                $this->tab = 1;
            } else {
                $this->tab = 2;
            }
        }
        
        // Charger les données initiales
        $this->loadNewTaches();
    }

    public function refresh()
    {
        $this->reset();
    }
    
    public function handleParticipantUpdated()
    {
        $this->emit('reloadComponent');
    }
    
    public function refreshTacheInfo()
    {
        // Force le rechargement complet des données
        $this->resetPage();
        $this->emit('$refresh');
        
        // Rafraîchir les données après un court délai pour s'assurer que tout est chargé
        $this->dispatchBrowserEvent('refresh-taches');
        
        // Si l'onglet actuel est l'onglet des tâches assignées, forcer le rafraîchissement
        if ($this->tab == 2) {
            $this->changeTab(2);
        }
    }
    
    public function handleParticipantAdded()
    {
        // Rafraîchir les données et forcer le rechargement des composants
        $this->emit('reloadComponent');
        $this->emit('refreshTacheInfo');
        $this->emit('$refresh');
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

    public function changeTab($tab)
    {
        $this->tab = $tab;
        
        // Si l'onglet est l'onglet des tâches assignées, forcer un rechargement complet
        if ($tab == 2) {
            $this->loadNewTaches();
        }
        
        // Forcer le rechargement des données pour l'onglet sélectionné
        $this->emit('$refresh');
    }
    
    protected function loadNewTaches()
    {
        // Charger les nouvelles tâches assignées à l'utilisateur
        $assignees = Tache::whereHas('agents', function($query) {
                $query->where('agent_id', Auth::user()->agent->id)
                      ->where('type', 'App\\Models\\Agent')
                      ->where('type_id', Auth::user()->agent->id);
            })
            ->with(['agents', 'objectifs', 'tache_statut'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        // S'assurer que newTaches est toujours une collection
        $filteredTaches = $assignees->where('tache_statut_id', '1');
        $this->newTaches = $filteredTaches->sortByDesc('id');
        $this->newTachesCount = $this->newTaches->count();
    }

    public function render()
    {
        $tacheEncours = collect();
        $endTaches = collect();
        $horsDelais = collect();
        $taches = collect();
        $newTaches = collect();

        if (Auth::user()->agent->isDG()) {
            $taches = Tache::where('user_id', Auth::user()->id)
                ->with(['agents', 'objectifs', 'tache_statut'])
                ->orderBy('id', 'DESC')
                ->paginate(10);
        } else {
            // Récupérer les tâches créées par l'utilisateur ET les tâches assignées
            $tachesCreees = Tache::where('user_id', Auth::user()->id)
                ->with(['agents', 'objectifs', 'tache_statut'])
                ->get();
                
            $tachesAssignees = Tache::whereHas('agents', function($query) {
                    $query->where('agent_id', Auth::user()->agent->id)
                          ->where('type', 'App\\Models\\Agent')
                          ->where('type_id', Auth::user()->agent->id);
                })
                ->with(['agents', 'objectifs', 'tache_statut'])
                ->get();
            
            // Fusionner et supprimer les doublons (si une tâche est à la fois créée et assignée)
            $toutesMesTaches = $tachesCreees->merge($tachesAssignees)->unique('id')->sortByDesc('id');
            
            // Convertir en paginator pour garder la pagination
            $currentPage = \Illuminate\Pagination\Paginator::resolveCurrentPage();
            $perPage = 10;
            $currentItems = $toutesMesTaches->slice(($currentPage - 1) * $perPage, $perPage)->values();
            
            $taches = new \Illuminate\Pagination\LengthAwarePaginator(
                $currentItems,
                $toutesMesTaches->count(),
                $perPage,
                $currentPage,
                ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath()]
            );
                
            // Charger TOUJOURS les tâches assignées pour avoir le compteur
            $assignees = Tache::getTachesForCurrentUser();
            $newTaches = $assignees->where('tache_statut_id', '1')->sortByDesc('id');
            
            // Mettre à jour le compteur de nouvelles tâches (toujours calculé)
            $this->newTachesCount = $newTaches->count();
            
            // Charger les autres catégories seulement si nécessaire
            // Utiliser $toutesMesTaches (créées + assignées) pour En cours, Achevées, Hors délais
            if ($this->tab == 2) {
                // Onglet Assignées : uniquement les tâches assignées
                $tacheEncours = $assignees->where('tache_statut_id', '2')->sortByDesc('id');
                $endTaches = $assignees->where('tache_statut_id', '3')->sortByDesc('id');
                $horsDelais = $assignees->where('tache_statut_id', '4')->sortByDesc('id');
            } elseif ($this->tab == 3) {
                // Onglet En cours : tâches créées OU assignées
                $tacheEncours = $toutesMesTaches->where('tache_statut_id', '2')->sortByDesc('id');
            } elseif ($this->tab == 4) {
                // Onglet Achevées : tâches créées OU assignées
                $endTaches = $toutesMesTaches->where('tache_statut_id', '3')->sortByDesc('id');
            } elseif ($this->tab == 5) {
                // Onglet Hors délais : tâches créées OU assignées
                $horsDelais = $toutesMesTaches->where('tache_statut_id', '4')->sortByDesc('id');
            }
        }

        return view('livewire.taches.index-tache', [
            'taches' => $taches,
            'newTachesCount' => $this->newTachesCount,
            'newTaches' => $newTaches,
            'tacheEncours' => $tacheEncours,
            'endTaches' => $endTaches,
            'horsDelais' => $horsDelais,
        ]);
    }
}
