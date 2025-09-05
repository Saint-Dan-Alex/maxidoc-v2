<?php

namespace App\Http\Livewire\Systems;

use App\Models\Section as Model;
use App\Models\Service;
use App\Models\Statut;
use Livewire\Component;
use Livewire\WithPagination;

class Section extends Component
{
    use WithPagination;
    
    public $services;
    public $statuts;
    public $filter;
    public $filterText;
    public $search;

    protected $listeners = ['reloadSection' => '$refresh'];
    protected $paginationTheme = 'bootstrap-5';
    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public function mount()
    {
        $this->services = Service::with('division')->orderBy('titre', 'asc')->get();
        $this->statuts = Statut::select('libelle', 'id')->orderBy('libelle', 'asc')->get();
        $this->filterText = "Filtre";
    }

    public function render()
    {
        $query = Model::with([
                'division',
                'service',
                'responsable',
                'agents',
                'statut'
            ])
            ->select('id', 'division_id', 'service_id', 'responsable_id', 'statut_id', 'titre', 'description', 'created_at', 'updated_at');

        // Gestion de la recherche
        if ($this->search) {
            $query->where(function($q) {
                $q->where('titre', 'LIKE', '%' . $this->search . '%')
                  ->orWhere('description', 'LIKE', '%' . $this->search . '%')
                  ->orWhereHas('service', function($q) {
                      $q->where('libelle', 'LIKE', '%' . $this->search . '%');
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
        $sections = $query->paginate(10);
        
        return view('livewire.systems.section', [
            'sections' => $sections,
            'allServices' => $this->services,
            'allStatuts' => $this->statuts
        ]);
    }

    public function changeFilter($value)
    {
        $this->filter = $value;
        $this->resetPage(); // Réinitialise la pagination lors du changement de filtre
    }

}
