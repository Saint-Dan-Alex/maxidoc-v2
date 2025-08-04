<?php

namespace App\Http\Livewire\Systems;

use App\Models\LieuAffectation as Model;
use Livewire\Component;
use Livewire\WithPagination;

class Lieu extends Component
{
    use WithPagination;

    public $filter;
    public $filterText;
    public $search;

    protected $listeners = ['reloadLieu' => '$refresh'];
    protected $paginationTheme = 'bootstrap-5';
    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public function mount()
    {
        $this->filterText = "Filtre";
    }

    public function render()
    {
        $query = Model::query();

        // Gestion de la recherche
        if ($this->search) {
            $query->where('titre', 'LIKE', '%' . $this->search . '%');
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
        $lieus = $query->paginate(10);
        
        return view('livewire.systems.lieu', [
            'lieus' => $lieus
        ]);
    }

    public function changeFilter($value)
    {
        $this->filter = $value;
        $this->resetPage(); // Réinitialise la pagination lors du changement de filtre
    }

}
