<?php

namespace App\Http\Livewire\Systems;

use App\Models\Direction as Model;
use App\Models\LieuAffectation;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Direction extends Component
{
    use WithPagination;

    public $filter;
    public $filterText;
    public $lieus;
    public $users;
    public $search;

    protected $listeners = ['reloadDirection' => '$refresh'];
    protected $paginationTheme = 'bootstrap-5';
    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public function mount()
    {
        $this->lieus = LieuAffectation::select('id', 'titre')->get();
        $this->users = User::select('name', 'id')->limit(50)->get();
        $this->filterText = "Filtre";
    }

    public function render()
    {
        $query = Model::with('lieu', 'responsable', 'adjoint')
            ->select('id', 'titre', 'lieu_id', 'responsable_id', 'code', 'adjoint_id');

        // Gestion de la recherche
        if ($this->search) {
            $query->where('titre', 'LIKE', '%' . $this->search . '%')
                  ->orWhere('code', 'LIKE', '%' . $this->search . '%');
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
            case 6:
                $this->filterText = "Lieu d'Affectation";
                $query->with(['lieu' => function($q) {
                    $q->orderBy('titre', 'asc');
                }]);
                break;
            default:
                $query->orderBy('titre', 'asc');
        }

        // Pagination avec 10 éléments par page
        $directions = $query->paginate(10);
        
        return view('livewire.systems.direction', [
            'directions' => $directions,
            'lieus' => $this->lieus,
            'users' => $this->users
        ]);
    }

    public function changeFilter($value)
    {
        $this->filter = $value;
        $this->resetPage(); // Réinitialise la pagination lors du changement de filtre
    }

}
