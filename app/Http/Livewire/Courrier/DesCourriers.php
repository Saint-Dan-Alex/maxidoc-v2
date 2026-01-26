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

    public function mount()
    {
        $this->isSec = false;
        $user = Auth::user();
        
        if ($user && $user->agent) {
            // Vérifier si l'utilisateur est un secrétaire du DG
            $agent = $user->agent;
            $isSecretaireDG = \App\Models\Secretariat::where('responsable_id', $agent->id)
                ->where('for_dg', true)
                ->exists();
                
            $this->isSec = $isSecretaireDG;
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

        $agentId = Auth::user()->agent->id;

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

        // Gestion des différents onglets
        if ($this->active_tab == 1) {
            $query = $courriersQuery->where('statut_id', '!=', 3);
            
            if ($this->isSec) {
                $query->where('type_id', 1);
            }
            
            // Appliquer le filtre utilisateur pour l'onglet "Tous" également
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
        }

        return view('livewire.courrier.des-courriers', [
            'allcourriers' => $this->active_tab == 1 ? $allcourriers : collect(),
            'entrants' => $this->active_tab == 2 ? $entrants : collect(),
            'sortants' => $this->active_tab == 3 ? $sortants : collect(),
            'internes' => $this->active_tab == 4 ? $internes : collect(),
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
}
