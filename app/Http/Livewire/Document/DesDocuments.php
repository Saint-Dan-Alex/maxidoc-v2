<?php

namespace App\Http\Livewire\Document;

use App\Models\Document;
// use App\Models\Dossier; 
use App\Models\Direction;
use App\Models\Division;
// use App\Models\Agent; 
use App\Models\LieuAffectation; 
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Gate;
use Livewire\WithPagination;
use Livewire\Component;

class DesDocuments extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap-5';
    protected $queryString = ['active_tab' => ['except' => 1]];
    protected $listeners = ['refreshDocuments' => 'refreshPage'];

    public $filter;
    public $filterText;
    
    public $lieus;
    public $directions;
    public $divisions;
    public $agents;

    public $selectedMonth;
    public $selectedYear;
    public $selectedDay;
    public $search;

    public $lieu_query;
    public $direction_query;
    public $division_query;
    public $agent_query;

    public $active_tab = 1; 
   
    public function mount()
    {  
        $this->lieus = LieuAffectation::select('id', 'titre')->get();
        $this->directions = collect();
        $this->divisions = collect();
        $this->agents = collect();  
    }

    public function refreshPage()
    {
        $this->resetPage();
    }

    public function refreshSelection()
    {
        $this->resetFilters();
    }

    private function resetFilters()
    {
        $this->selectedMonth = null;
        $this->selectedYear = null;
        $this->selectedDay = null;
        $this->search = "";
        $this->lieu_query = "";
        $this->direction_query = "";
        $this->division_query = "";
        $this->agent_query = ""; 
    }
    
    public function changeTab($tab)
    {
        if ($this->active_tab !== $tab) {
            $this->resetPage();
            $this->active_tab = $tab;
            $this->resetFilters();
        }
    } 

    public function updatedLieuQuery($value)
    {
        if ($value) {
           $this->directions = LieuAffectation::findOrFail($value)->directions ?? collect();
        } else {
            $this->directions = collect();
        } 
        $this->divisions = collect();  // Reset divisions when lieu changes
        $this->agents = collect();     // Reset agents when lieu changes
    }

    public function updatedDirectionQuery($value)
    {
        if ($value) {
        $this->divisions = Direction::findOrFail($value)->divisions ?? collect();
        } else {
            $this->divisions = collect();
        }
        $this->agents = collect();     // Reset agents when direction changes
    }

    public function updatedDivisionQuery($value)
    {
        if ($value) {
        $this->agents = Division::findOrFail($value)->agents ?? collect();
        } else {
            $this->agents = collect();
        }
    }

    public function changeFilter($value)
    {
        $this->filter = $value;
    }

    public function applyFilters($query)
    {
        // Filtrer par recherche
        if (!empty($this->search)) {
            $query->where('libelle', 'like', '%' . $this->search . '%');
        }
        
        if (!empty($this->lieu_query)) {
            $query->whereHas('author', function($subQuery){
                $subQuery->where('lieu_id',$this->lieu_query);
            }); 
        } 

        if (!empty($this->direction_query)) {
            $query->whereHas('author', function($subQuery){
                $subQuery->where('direction_id',$this->direction_query);
            });
        } 

        if (!empty($this->division_query)) {
            $query->whereHas('author', function($subQuery){
                $subQuery->where('division_id',$this->division_query);
            });
        }

        if (!empty($this->agent_query)) {
            $query->whereHas('author', function($subQuery){
                $subQuery->where('id',$this->agent_query);
            });
        }

        // Filtre A à Z ou Z à A
        if ($this->filter === 'AtoZ') {
            $query->orderBy('libelle', 'asc'); // Tri de A à Z
        } elseif ($this->filter === 'ZtoA') {
            $query->orderBy('libelle', 'desc'); // Tri de Z à A
        } else {
            // Par défaut, tri par date de création
            $query->orderBy('created_at', 'desc');
        }

        // Filtrer par date (année, mois, jour)
        if (!empty($this->selectedYear)) {
            $query->whereYear('created_at', $this->selectedYear);
        }
        if (!empty($this->selectedMonth)) {
            $query->whereMonth('created_at', $this->selectedMonth);
        }
        if (!empty($this->selectedDay)) {
            $query->whereDay('created_at', $this->selectedDay);
        }

        return $query;
    }

    // public function render()
    // {
    //     $documents = collect();
    //     $shareds = collect();

    //     $documentsQuery = Document::query(); 
    //     $documentsQuery = $this->applyFilters($documentsQuery);
    //     // Exécuter la requête pour obtenir une collection
    //     $documents = $documentsQuery->get(); 
    //     // Appliquer le filtre sur la collection
    //     $documents = $documents->filter(function ($document) {
    //         return Gate::allows('view', $document);
    //     });
    
    //     // Paginer manuellement la collection filtrée
    //     $currentPage = $this->page; // Page actuelle
    //     $perPage = 10; // Nombre d'éléments par page
    //     $documentsPaginated = new LengthAwarePaginator(
    //         $documents->forPage($currentPage, $perPage), 
    //         $documents->count(), 
    //         $perPage, 
    //         $currentPage
    //     );

    //     $sharedQuery = $documentsQuery->whereHas('followers', function($query){
    //             $query->where('agent_id', auth()->user()->agent->id);
    //         });
    //     $shareds = $sharedQuery->orderBy('id','desc')->paginate(10);
            
    //     return view('livewire.document.des-documents', [
    //         'documents' => $documentsPaginated,
    //         'shareds' => $shareds,
    //     ]);
    // }

public function render()
{
    $documentsQuery = Document::query(); 
    $documentsQuery = $this->applyFilters($documentsQuery);

    // Filtrer uniquement les documents dont le statut est "Traité"
    $documentsQuery = $documentsQuery->whereHas('statut', function($query) {
        $query->where('titre', 'Traité');
    });

    // Exécuter la requête pour obtenir une collection
    $documents = $documentsQuery->get(); 

    // Appliquer le filtre d'autorisation
    $documents = $documents->filter(function ($document) {
        return Gate::allows('view', $document);
    });

    // Pagination manuelle
    $currentPage = $this->page; 
    $perPage = 10; 
    $documentsPaginated = new LengthAwarePaginator(
        $documents->forPage($currentPage, $perPage), 
        $documents->count(), 
        $perPage, 
        $currentPage
    );

    // Pour shareds (documents suivis)
    $sharedQuery = $documentsQuery->whereHas('followers', function($query){
        $query->where('agent_id', auth()->user()->agent->id);
    });

    $shareds = $sharedQuery->orderBy('id','desc')->paginate(10);

    return view('livewire.document.des-documents', [
        'documents' => $documentsPaginated,
        'shareds' => $shareds,
    ]);
}


} 