<?php

namespace App\Http\Livewire\Archivage;

use App\Models\Document as ModelsDocument;
use App\Models\Dossier;
use App\Models\LieuAffectation;
use App\Models\Direction;
use App\Models\Division;
use App\Models\Agent;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class Document extends Component
{
    use WithPagination;
    
    protected $paginationTheme = 'bootstrap-5';
    
    public $dossier;
    public $documents;
    public $filter;
    public $filterText = 'Filtre';
    public $search;
    
    // Propriétés pour les filtres
    public $lieus;
    public $directions;
    public $divisions;
    public $agents;
    
    public $selectedMonth;
    public $selectedYear;
    public $selectedDay;
    
    public $lieu_query;
    public $direction_query;
    public $division_query;
    public $agent_query;

    public function mount(Dossier $dossier)
    {
        $this->dossier = $dossier;
        $this->lieus = LieuAffectation::select('id', 'titre')->get();
        $this->directions = collect();
        $this->divisions = collect();
        $this->agents = collect();
    }

    public function render()
    {
        $query = ModelsDocument::archive()->where('dossier_id', $this->dossier->id);
        
        // Appliquer les filtres
        $query = $this->applyFilters($query);
        
        // Récupérer les documents avec pagination
        $documents = $query->paginate(10);
        $this->documents = $documents->getCollection();
        
        // Appliquer le tri
        $this->applySorting();
        
        return view('livewire.archivage.document', [
            'paginatedDocuments' => $documents
        ]);
    }
    
    protected function applyFilters($query)
    {
        // Filtre par recherche
        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('titre', 'like', '%' . $this->search . '%')
                  ->orWhere('reference', 'like', '%' . $this->search . '%');
            });
        }
        
        // Filtres par lieu, direction, division, agent
        if (!empty($this->lieu_query)) {
            $query->whereHas('author', function($q) {
                $q->where('lieu_id', $this->lieu_query);
            });
        }
        
        if (!empty($this->direction_query)) {
            $query->whereHas('author', function($q) {
                $q->where('direction_id', $this->direction_query);
            });
        }
        
        if (!empty($this->division_query)) {
            $query->whereHas('author', function($q) {
                $q->where('division_id', $this->division_query);
            });
        }
        
        if (!empty($this->agent_query)) {
            $query->where('author_id', $this->agent_query);
        }
        
        // Filtres par date
        if (!empty($this->selectedYear)) {
            $query->whereYear('archived_at', $this->selectedYear);
        }
        
        if (!empty($this->selectedMonth)) {
            $query->whereMonth('archived_at', $this->selectedMonth);
        }
        
        if (!empty($this->selectedDay)) {
            $query->whereDay('archived_at', $this->selectedDay);
        }
        
        return $query;
    }
    
    protected function applySorting()
    {
        $sortField = 'archived_at';
        $sortDirection = 'desc';
        
        switch ($this->filter) {
            case 1: // Par défaut
                $sortField = 'archived_at';
                $sortDirection = 'desc';
                $this->filterText = 'Filtre';
                break;
            case 2: // A-Z
                $sortField = 'titre';
                $sortDirection = 'asc';
                $this->filterText = 'A - Z';
                break;
            case 3: // Z-A
                $sortField = 'titre';
                $sortDirection = 'desc';
                $this->filterText = 'Z - A';
                break;
            case 4: // Date d'ajout
                $sortField = 'created_at';
                $sortDirection = 'desc';
                $this->filterText = "Date d'ajout";
                break;
            case 5: // Date de modification
                $sortField = 'updated_at';
                $sortDirection = 'desc';
                $this->filterText = 'Date de modification';
                break;
        }
        
        $this->documents = $this->documents->sortBy($sortField, SORT_REGULAR, $sortDirection === 'desc');
   

        return view('livewire.archivage.document');
    }

    public function updatedLieuQuery($value)
    {
        if ($value) {
            $this->directions = LieuAffectation::findOrFail($value)->directions ?? collect();
        } else {
            $this->directions = collect();
        } 
        $this->divisions = collect();
        $this->agents = collect();
        $this->direction_query = null;
        $this->division_query = null;
        $this->agent_query = null;
        $this->resetPage();
    }

    public function updatedDirectionQuery($value)
    {
        if ($value) {
            $this->divisions = Direction::findOrFail($value)->divisions ?? collect();
        } else {
            $this->divisions = collect();
        }
        $this->agents = collect();
        $this->division_query = null;
        $this->agent_query = null;
        $this->resetPage();
    }

    public function updatedDivisionQuery($value)
    {
        if ($value) {
            $this->agents = Division::findOrFail($value)->agents ?? collect();
        } else {
            $this->agents = collect();
        }
        $this->agent_query = null;
        $this->resetPage();
    }

    public function updatedAgentQuery()
    {
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedSelectedYear()
    {
        $this->resetPage();
    }

    public function updatedSelectedMonth()
    {
        $this->resetPage();
    }

    public function updatedSelectedDay()
    {
        $this->resetPage();
    }

    public function changeFilter($value)
    {
        $this->filter = $value;
        $this->resetPage();
    }
    
    public function resetFilters()
    {
        $this->reset([
            'search',
            'lieu_query',
            'direction_query',
            'division_query',
            'agent_query',
            'selectedDay',
            'selectedMonth',
            'selectedYear',
            'filter'
        ]);
        
        $this->directions = collect();
        $this->divisions = collect();
        $this->agents = collect();
        $this->filterText = 'Filtre';
        $this->resetPage();
    }
}
