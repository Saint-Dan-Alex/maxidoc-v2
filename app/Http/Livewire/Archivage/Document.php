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
    
    public $loading = false;
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

        // Déterminer le tri à appliquer côté SQL
        [$sortField, $sortDirection] = $this->getSortOptions();

        // Récupérer les documents avec tri et pagination (le tri est appliqué dans la requête)
        $documents = $query->orderBy($sortField, $sortDirection)->paginate(10);
        $this->documents = $documents->getCollection();
        
        // Désactiver le loader une fois le rendu terminé
        $this->loading = false;
        
        return view('livewire.archivage.document', [
            'paginatedDocuments' => $documents
        ]);
    }
    
    protected function applyFilters($query)
    {
        // Filtre par recherche
        if (!empty($this->search)) {
            $searchTerm = '%' . $this->search . '%';
            $query->where(function($q) use ($searchTerm) {
                $q->where('libelle', 'like', $searchTerm)
                  ->orWhere('reference', 'like', $searchTerm)
                  ->orWhereHas('courrier', function($q) use ($searchTerm) {
                      $q->where('objet', 'like', $searchTerm)
                        ->orWhere('reference', 'like', $searchTerm);
                  });
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
    
    protected function getSortOptions(): array
    {
        // Valeurs par défaut: plus récent archivé au plus ancien
        $sortField = 'archived_at';
        $sortDirection = 'desc';

        switch ($this->filter) {
            case 1: // Par défaut
                $this->filterText = 'Filtre';
                break;
            case 2: // A - Z (sur le libellé du document)
                $sortField = 'libelle';
                $sortDirection = 'asc';
                $this->filterText = 'A - Z';
                break;
            case 3: // Z - A
                $sortField = 'libelle';
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

        return [$sortField, $sortDirection];
    }

    public function updatedLieuQuery($value)
    {
        $this->loading = true;
        $this->resetPage();
        if ($value) {
            $this->directions = Direction::where('lieu_id', $value)->get();
        } else {
            $this->directions = collect();
        }
        $this->divisions = collect();
        $this->agents = collect();
        $this->direction_query = null;
        $this->division_query = null;
        $this->agent_query = null;
    }

    public function updatedDirectionQuery($value)
    {
        $this->loading = true;
        $this->resetPage();
        if ($value) {
            $this->divisions = Division::where('direction_id', $value)->get();
        } else {
            $this->divisions = collect();
        }
        $this->agents = collect();
        $this->division_query = null;
        $this->agent_query = null;
    }

    public function updatedDivisionQuery($value)
    {
        $this->loading = true;
        $this->resetPage();
        if ($value) {
            $this->agents = Agent::where('division_id', $value)->get();
        } else {
            $this->agents = collect();
        }
        $this->agent_query = null;
    }

    public function updatedAgentQuery()
    {
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->loading = true;
        $this->resetPage();
    }

    public function updatedSelectedYear()
    {
        $this->loading = true;
        $this->resetPage();
    }

    public function updatedSelectedMonth()
    {
        $this->loading = true;
        $this->resetPage();
    }

    public function updatedSelectedDay()
    {
        $this->loading = true;
        $this->resetPage();
    }

    public function changeFilter($value)
    {
        $this->loading = true;
        $this->filter = $value;
        $this->resetPage();
    }
    
    public function resetFilters()
    {
        $this->loading = true;
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
