<?php

namespace App\Http\Livewire\Systems;

use App\Models\Agent;
use App\Models\Assistanat as Model;
use App\Models\Direction;
use Livewire\Component;
use Livewire\WithPagination;

class Assistanat extends Component
{
    use WithPagination;
    
    public $directions;
    public $agents;
    public $filter;
    public $filterText;
    public $search;

    protected $listeners = ['reloadAssistanat' => '$refresh'];
    protected $paginationTheme = 'bootstrap-5';
    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public function mount()
    {
        $this->loadDirections();
        $this->loadAgents();
        $this->filterText = "Filtre";
    }

    protected function loadDirections()
    {
        $this->directions = Direction::select('id', 'titre')
            ->orderBy('titre', 'asc')
            ->get();
    }

    protected function loadAgents()
    {
        $this->agents = Agent::select('id', 'prenom', 'nom', 'post_nom')
            ->orderBy('prenom')
            ->orderBy('nom')
            ->get();
    }

    public function render()
    {
        $query = Model::with([
                'responsable',
                'direction',
            ])
            ->select('id', 'titre', 'direction_id', 'responsable_id', 'for_dg', 'for_dga', 'created_at', 'updated_at');

        // Gestion de la recherche
        if ($this->search) {
            $query->where(function($q) {
                $q->where('titre', 'LIKE', '%' . $this->search . '%')
                  ->orWhereHas('direction', function($q) {
                      $q->where('titre', 'LIKE', '%' . $this->search . '%');
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
        $assistants = $query->paginate(10);
        
        return view('livewire.systems.assistanat', [
            'assistants' => $assistants,
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
