<?php

namespace App\Http\Livewire\Systems;

use App\Models\Direction;
use App\Models\Division as Model;
use Livewire\Component;
use Livewire\WithPagination;

class Division extends Component
{
    use WithPagination;

    public $filter;
    public $filterText;
    public $search;
    public $directions;

    protected $listeners = ['reloadDivision' => '$refresh'];
    protected $paginationTheme = 'bootstrap-5';
    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public function mount()
    {
        $this->directions = Direction::select('id', 'titre')->orderBy('titre', 'asc')->get();
        $this->filterText = "Filtre";
    }

    public function render()
    {
        $query = Model::with('responsable', 'direction')
            ->select('id', 'libelle', 'direction_id', 'responsable_id');

        // Gestion de la recherche
        if ($this->search) {
            $query->where('libelle', 'LIKE', '%' . $this->search . '%')
                  ->orWhereHas('direction', function($q) {
                      $q->where('titre', 'LIKE', '%' . $this->search . '%');
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
                $query->orderBy('libelle', 'asc');
                break;
            case 3:
                $this->filterText = 'Z - A';
                $query->orderBy('libelle', 'desc');
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
                $query->orderBy('libelle', 'asc');
        }

        // Pagination avec 10 éléments par page
        $divisions = $query->paginate(10);
        
        return view('livewire.systems.division', [
            'divisions' => $divisions,
            'allDirections' => $this->directions
        ]);
    }

    public function changeFilter($value)
    {
        $this->filter = $value;
        $this->resetPage(); // Réinitialise la pagination lors du changement de filtre
    }

}
