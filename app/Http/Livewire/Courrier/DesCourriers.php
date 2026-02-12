<?php

namespace App\Http\Livewire\Courrier;

use App\Models\Courrier;
use App\Models\User;
use Livewire\WithPagination;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\On; 

class DesCourriers extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap-5';
    protected $queryString = ['active_tab' => ['except' => 1]];

    public $active_tab = 1;
    public $search = '';  
    public $selectedMonth = '';
    public $selectedYear = '';
    public $priority = null;
    public $statut = null; 
    public $isSec = false;
    public $isDG = false;
    public $isAssistant = false;
    public $isSecretaire = false;
    public $isSuperAdmin = false;
    public $perPage = 10;

    public function mount()
    {
        $this->isSec = false;
        $this->isDG = false;
        $user = Auth::user();

        // Vérifier si Super Admin (même sans agent)
        $this->isSuperAdmin = $user && $user->hasRole('Super Admin');

        if ($user && $user->agent) {
            // Vérifier si l'utilisateur est un secrétaire du DG
            $agent = $user->agent;
            $isSecretaireDG = \App\Models\Secretariat::where('responsable_id', $agent->id)
                ->where('for_dg', true)
                ->exists();
                
            $this->isSec = $isSecretaireDG;
            
            // Vérifier si l'utilisateur est DG
            $this->isDG = $agent->isDG();
            
            // Vérifier si l'utilisateur est Assistant
            $this->isAssistant = $agent->isAssistant();

            // Vérifier si l'utilisateur est Secretaire
            $this->isSecretaire = $agent->isSecretaire();
        }

        // Si Super Admin, l'onglet par défaut doit être la Corbeille (5)
        if ($this->isSuperAdmin && $this->active_tab == 1) {
            $this->active_tab = 5;
        }
    }

    protected $listeners = [
        'CourrierCreated' => 'SendCourrierCreatedNotification',
    ];



    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function refreshCourriers()
    {
        $this->resetPage();
        $this->resetFilters();
    }

    public function SendCourrierCreatedNotification()
    {
        $this->resetPage();
        $this->resetFilters(); 
    }

    public function changeTab($tab)
    {
        if ($this->active_tab !== $tab) {
            $this->resetPage();
            $this->active_tab = $tab;
            $this->resetFilters();
        }
    } 

    public function refreshSelection()
    {
        $this->resetFilters();
    }

    private function resetFilters()
    {
        $this->selectedMonth = null;
        $this->selectedYear = null;
        $this->priority = null;
        $this->statut = null;
        $this->search = "";
    }

    private function applyFilters($query)
    { 
        if (!empty($this->search)) {
            $query->where(function ($subQuery) {
                $subQuery->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('reference_interne', 'like', '%' . $this->search . '%')
                    // ->orWhereHas('expediteur', function ($query) {
                    //     $query->where('prenom', 'like', '%' . $this->search . '%')
                    //         ->orWhere('nom', 'like', '%' . $this->search . '%')
                    //         ->orWhere('post_nom', 'like', '%' . $this->search . '%');
                    // })
                    ->orWhereHas('externExpediteur', function ($query) {
                        $query->where('nom', 'like', '%'.$this->search.'%');
                    })->orWhereHas('serviceExpediteur', function($query) {
                        $query->where('titre', 'like', '%'.$this->search.'%');
                    })->orWhereHas('toDirection', function($query){
                        $query->where('titre','like','%'.$this->search . '%');
                    })->orWhereHas('externDestinateur', function($query){
                        $query->where('nom','like','%'.$this->search . '%');
                    });
                });
            } 

        if (!empty($this->selectedYear)) {
            $query->whereYear('created_at', $this->selectedYear);
        }

        if (!empty($this->selectedMonth)) {
            $query->whereMonth('created_at', $this->selectedMonth);
        } 
        
        if (!empty($this->priority)) {
            $query->where('priorite_id', $this->priority);
        }

        if (!empty($this->statut)) {
            $query->where('statut_id', $this->statut);
        }

        return $query;
    }

    private function applyPermissions($query)
    {
        // Filtrer avant pagination en fonction des permissions
        return $query->get()->filter(function ($courrier) {
            return Auth::user()->can('view', $courrier);
        });
    }

    public function mapFollowers($courriers)
    {
        return $courriers->transform(function ($courrier) {
            $followers = collect();

            foreach ($courrier->etapes as $etape) {
                if ($etape->pivot->view_by) {
                    $followers->push(User::find($etape->pivot->view_by)->agent);
                }
            }

            $courrier->followers = $followers->unique();
            return $courrier;
        });
    } 

    public function render()
    {
        $courriersQuery = Courrier::with([
            'expediteur',
            'externExpediteur',
            'externDestinateur',
            'destinateurs',
            'accuseReceptions.user.agent',
            'partages'
        ]);

        $agentId = Auth::user()->agent?->id;

        // Fonction pour filtrer les courriers où l'utilisateur est impliqué
        $filterByUserInteraction = function ($query) use ($agentId) {
            $query->where(function ($q) use ($agentId) {
                $q->where('created_by', $agentId)
                  ->orWhereHas('destinateurs', function ($sq) use ($agentId) {
                      $sq->where('agent_id', $agentId);
                  })
                  ->orWhereHas('followers', function ($sq) use ($agentId) {
                      $sq->where('agent_id', $agentId);
                  })
                  ->orWhereHas('partages', function ($sq) use ($agentId) {
                      $sq->where('agent_id', $agentId);
                  });
            });
        };

        // Initialisation des variables pour la vue
        $allcourriers = collect();
        $entrants = collect();
        $sortants = collect();
        $internes = collect();
        $finalises = collect();
        $priorites = collect();

        // Gestion des différents onglets
        if ($this->isDG) {
            // Logique spécifique DG
            switch ($this->active_tab) {
                case 1: // Tous
                    $query = $courriersQuery;
                    $filterByUserInteraction($query);
                    $query = $this->applyFilters($query)->orderBy('id', 'desc');
                    $allcourriers = $query->paginate(10);
                    $allcourriers->getCollection()->transform(function ($courrier) {
                        return $this->mapFollowerSingle($courrier);
                    });
                    break;
                case 2: // A orienter (Pas de tâches liées)
                    $query = $courriersQuery->whereDoesntHave('taches');
                    $filterByUserInteraction($query);
                    $query = $this->applyFilters($query)->orderBy('id', 'desc');
                    $entrants = $query->paginate(10); // On réutilise le nom entrants pour simplifier la vue
                    $entrants->getCollection()->transform(function ($courrier) {
                        return $this->mapFollowerSingle($courrier);
                    });
                    break;
                case 3: // En cours (A des tâches liées ET statut 2)
                    $query = $courriersQuery->whereHas('taches')->where('statut_id', 2);
                    $filterByUserInteraction($query);
                    $query = $this->applyFilters($query)->orderBy('id', 'desc');
                    $sortants = $query->paginate(10); // On réutilise sortants
                    $sortants->getCollection()->transform(function ($courrier) {
                        return $this->mapFollowerSingle($courrier);
                    });
                    break;
                case 4: // Finalisés (Statut 3)
                    $query = $courriersQuery->where('statut_id', 3);
                    $filterByUserInteraction($query);
                    $query = $this->applyFilters($query)->orderBy('id', 'desc');
                    $finalises = $query->paginate($this->perPage);
                    $finalises->getCollection()->transform(function ($courrier) {
                        return $this->mapFollowerSingle($courrier);
                    });
                    break;
                case 5: // Corbeille (Désormais pour DG, Admin et Assistants)
                    $query = Courrier::onlyTrashed()->with([
                        'expediteur', 'externExpediteur', 'externDestinateur', 'destinateurs'
                    ]);
                    $query = $this->applyFilters($query)->orderBy('deleted_at', 'desc');
                    $trashed = $query->paginate($this->perPage);
                    $trashed->getCollection()->transform(function ($courrier) {
                        return $this->mapFollowerSingle($courrier);
                    });
                    break;
            }
        } else {
            // Logique standard (Non-DG)
            if ($this->active_tab == 1) {
                $query = $courriersQuery->where('statut_id', '!=', 3);
                
                if ($this->isSec) {
                    $query->where('type_id', 1);
                }
                
                $filterByUserInteraction($query);
                
                $query = $this->applyFilters($query)->orderBy('id', 'desc');
                $allcourriers = $query->paginate(10);
                $allcourriers->getCollection()->transform(function ($courrier) {
                    return $this->mapFollowerSingle($courrier);
                });

            } elseif ($this->active_tab == 2) {
                $query = $courriersQuery->where('type_id', 1);
                $filterByUserInteraction($query);
                $query = $this->applyFilters($query)->orderBy('id', 'desc');
                $entrants = $query->paginate(10);
                $entrants->getCollection()->transform(function ($courrier) {
                    return $this->mapFollowerSingle($courrier);
                });

            } elseif ($this->active_tab == 3) {
                $query = $courriersQuery->where('type_id', 2);
                $filterByUserInteraction($query);
                $query = $this->applyFilters($query)->orderBy('id', 'desc');
                $sortants = $query->paginate(10);
                $sortants->getCollection()->transform(function ($courrier) {
                    return $this->mapFollowerSingle($courrier);
                });

            } elseif ($this->active_tab == 4) {
                $query = $courriersQuery->where('type_id', 3);
                $filterByUserInteraction($query);
                $query = $this->applyFilters($query)->orderBy('id', 'desc');
                $internes = $query->paginate(10);
                $internes->getCollection()->transform(function ($courrier) {
                    return $this->mapFollowerSingle($courrier);
                });
            } elseif ($this->active_tab == 5) {
                // Corbeille pour non-DG (Assistants)
                $query = Courrier::onlyTrashed()->with([
                    'expediteur', 'externExpediteur', 'externDestinateur', 'destinateurs'
                ]);
                $query = $this->applyFilters($query)->orderBy('deleted_at', 'desc');
                $trashed = $query->paginate($this->perPage);
                $trashed->getCollection()->transform(function ($courrier) {
                    return $this->mapFollowerSingle($courrier);
                });
            }
        }

        return view('livewire.courrier.des-courriers', [
            'allcourriers' => $allcourriers,
            'entrants' => $entrants,
            'sortants' => $sortants,
            'internes' => $internes,
            'finalises' => $finalises,
            'trashed' => isset($trashed) ? $trashed : collect(),
            'priorites' => $priorites,
            'isSuperAdmin' => $this->isSuperAdmin,
        ]);
    }

    public function mapFollowerSingle($courrier)
    {
        $followers = collect();
        foreach ($courrier->etapes as $etape) {
            if ($etape->pivot->view_by) {
                $followers->push(User::find($etape->pivot->view_by)->agent);
            }
        }
        $courrier->followers = $followers->unique();
        return $courrier;
    }

     // Méthode pour paginer une collection manuellement
     private function paginateCollection($items, $perPage)
     {
         $page = $this->page ?: 1;
         $total = $items->count();
         $results = $items->forPage($page, $perPage);
 
         return new \Illuminate\Pagination\LengthAwarePaginator(
             $results, 
             $total, 
             $perPage, 
             $page,
             ['path' => request()->url(), 'query' => request()->query()]
         );
     }
     
     // --- Actions de suppression ---

    public function deleteCourrier($id)
    {
        $courrier = Courrier::findOrFail($id);
        
        if (Auth::user()->can('delete', $courrier)) {
            $courrier->delete();
            
            \App\Models\Historique::create([
                'key' => 'Suppression',
                'historiquecable_id' => $id,
                'historiquecable_type' => 'App\Models\Courrier',
                'description' => "Le courrier a été déplacé dans la corbeille par " . Auth::user()->name,
                'user_id' => Auth::user()->id,
            ]);

            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'success',
                'title' => 'Courrier supprimé',
                'text' => 'Le courrier a été placé dans la corbeille.'
            ]);
        }
    }

    public function restoreCourrier($id)
    {
        $courrier = Courrier::onlyTrashed()->findOrFail($id);
        
        if (Auth::user()->can('restore', $courrier)) {
            $courrier->restore();

            \App\Models\Historique::create([
                'key' => 'Restauration',
                'historiquecable_id' => $id,
                'historiquecable_type' => 'App\Models\Courrier',
                'description' => "Le courrier a été restauré par " . Auth::user()->name,
                'user_id' => Auth::user()->id,
            ]);

            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'success',
                'title' => 'Courrier restauré',
                'text' => 'Le courrier a été remis dans la liste principale.'
            ]);
        }
    }

    public function forceDeleteCourrier($id)
    {
        $courrier = Courrier::onlyTrashed()->findOrFail($id);
        
        if (Auth::user()->can('forceDelete', $courrier)) {
            $courrier->forceDelete();

            \App\Models\Historique::create([
                'key' => 'Suppression définitive',
                'historiquecable_id' => $id,
                'historiquecable_type' => 'App\Models\Courrier',
                'description' => "Le courrier a été définitivement supprimé par " . Auth::user()->name,
                'user_id' => Auth::user()->id,
            ]);

            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'success',
                'title' => 'Suppression définitive',
                'text' => 'Le courrier a été supprimé définitivement.'
            ]);
        }
    }
}
