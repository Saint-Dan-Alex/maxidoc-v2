<?php

namespace App\Http\Livewire\Systems;

use App\Models\Direction;
use App\Models\Division;
use App\Models\Service as Model;
use App\Models\Statut;
use Livewire\Component;
use Livewire\WithPagination;

class Service extends Component
{
    use WithPagination;
    
    public $divisions;
    public $directions;
    public $statuts;
    public $agents;
    public $filter;
    public $filterText;
    public $search;

    protected $listeners = ['reloadService' => '$refresh'];
    protected $paginationTheme = 'bootstrap-5';
    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public function mount()
    {
        $this->loadData();
        $this->filterText = "Filtre";
    }

    protected function loadData()
    {
        $this->divisions = Division::select('id', 'libelle')
            ->orderBy('libelle', 'asc')
            ->get();
            
        $this->directions = Direction::select('id', 'titre')
            ->orderBy('titre', 'asc')
            ->get();
            
        $this->statuts = Statut::select('id', 'libelle')
            ->orderBy('libelle', 'asc')
            ->get();
            
        $this->agents = \App\Models\Agent::select('id', 'prenom', 'nom')
            ->orderBy('prenom', 'asc')
            ->get();
    }

    public function render()
    {
        $query = Model::with([
                'responsable',
                'direction', 
                'division',
                'sections',
                'agents'
            ])
            ->select('id', 'direction_id', 'division_id', 'responsable_id', 'titre', 'created_at', 'updated_at');

        // Gestion de la recherche
        if ($this->search) {
            $query->where(function($q) {
                $q->where('titre', 'LIKE', '%' . $this->search . '%')
                  ->orWhereHas('direction', function($q) {
                      $q->where('titre', 'LIKE', '%' . $this->search . '%');
                  })
                  ->orWhereHas('division', function($q) {
                      $q->where('libelle', 'LIKE', '%' . $this->search . '%');
                  });
            });
        }

        // Gestion du filtrage
        switch ($this->filter) {
            case 1:
                $this->filterText = 'Filtre';
                $query->orderBy('created_at', 'desc');
                break;
            case 2:
                $this->filterText = 'A - Z';
                $query->orderBy('titre', 'asc');
                break;
            case 3:
                $this->filterText = 'Z - A';
                $query->orderBy('titre', 'desc');
                break;
            case 4:
                $this->filterText = "Date d'ajout";
                $query->orderBy('created_at', 'desc');
                break;
            case 5:
                $this->filterText = 'Date de modification';
                $query->orderBy('updated_at', 'desc');
                break;
            default:
                $query->orderBy('titre', 'asc');
        }

        // Pagination avec 10 éléments par page
        $services = $query->paginate(10);
        
        return view('livewire.systems.service', [
            'services' => $services,
            'allDivisions' => $this->divisions,
            'statuts' => $this->statuts,
            'allDirections' => $this->directions,
            'agents' => $this->agents
        ]);
    }

    public function changeFilter($value)
    {
        $this->filter = $value;
        $this->resetPage(); // Réinitialise la pagination lors du changement de filtre
    }

}
