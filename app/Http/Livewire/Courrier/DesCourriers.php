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
        $courriersQuery = Courrier::with('expediteur','externExpediteur','externDestinateur','destinateurs');
        // $courriersQuery = $this->applyFilters($courriersQuery);

        // Gestion des différents onglets
        if ($this->active_tab == 1) {
            $allcourriers = $courriersQuery->where('statut_id','!=',3)->orderBy('id', 'desc');
            $allcourriers = $this->applyFilters($allcourriers);
            $allcourriers = $this->applyPermissions($allcourriers);
            $allcourriers = $this->mapFollowers($allcourriers);
            $allcourriers = $this->paginateCollection($allcourriers, 10);
        } elseif ($this->active_tab == 2) {
            $entrants = $courriersQuery->where('type_id', 1)->orderBy('id', 'desc');
            $entrants = $this->applyFilters($entrants);
            $entrants = $this->applyPermissions($entrants);
            $entrants = $this->mapFollowers($entrants);
            $entrants = $this->paginateCollection($entrants, 10);
        } elseif ($this->active_tab == 3) {
            $sortants = $courriersQuery->where('type_id', 2)->orderBy('id', 'desc');
            $sortants = $this->applyFilters($sortants);
            $sortants = $this->applyPermissions($sortants);
            $sortants = $this->mapFollowers($sortants);
            $sortants = $this->paginateCollection($sortants, 10);
        } elseif ($this->active_tab == 4) {
            $internes = $courriersQuery->where('type_id', 3)->orderBy('id', 'desc');
            $internes = $this->applyFilters($internes);
            $internes = $this->applyPermissions($internes);
            $internes = $this->mapFollowers($internes);
            $internes = $this->paginateCollection($internes, 10);
        }

        return view('livewire.courrier.des-courriers', [
            'allcourriers' => $this->active_tab == 1 ? $allcourriers : collect(),
            'entrants' => $this->active_tab == 2 ? $entrants : collect(),
            'sortants' => $this->active_tab == 3 ? $sortants : collect(),
            'internes' => $this->active_tab == 4 ? $internes : collect(),
        ]);
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
