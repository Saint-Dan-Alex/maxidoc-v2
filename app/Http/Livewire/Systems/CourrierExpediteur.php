<?php

namespace App\Http\Livewire\Systems;

use App\Models\CourrierExpediteur as ExpediteurModel;
use App\Models\CourrierCategory;
use Livewire\Component;
use Livewire\WithPagination;

class CourrierExpediteur extends Component
{
    use WithPagination;
    
    public $filter;
    public $filterText;
    public $search;
    public $nom;
    public $editingId = null;
    public $category_id;

    protected $paginationTheme = 'bootstrap-5';
    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    protected $rules = [
        'nom' => 'required|string|max:255',
        'category_id' => 'required|exists:courrier_categories,id',
    ];

    public function mount()
    {
        $this->filterText = "Filtre";
    }

    public function render()
    {
        $query = ExpediteurModel::with('category');

        // Gestion de la recherche
        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'LIKE', '%' . $this->search . '%')
                  ->orWhereHas('category', function($q) {
                      $q->where('title', 'LIKE', '%' . $this->search . '%');
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
                $query->orderBy('name', 'asc');
                break;
            case 3:
                $this->filterText = 'Z - A';
                $query->orderBy('name', 'desc');
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
                $query->orderBy('nom', 'asc');
        }

        $expediteurs = $query->paginate(10);
        $categories = CourrierCategory::orderBy('title')->get();
        
        return view('livewire.systems.courrier-expediteur', [
            'expediteurs' => $expediteurs,
            'categories' => $categories
        ]);
    }

    public function changeFilter($value)
    {
        $this->filter = $value;
        $this->resetPage();
    }

    public function resetForm()
    {
        $this->reset(['nom', 'category_id', 'editingId']);
        $this->resetErrorBag();
    }

    public function store()
    {
        $this->validate();

        if ($this->editingId) {
            $expediteur = ExpediteurModel::findOrFail($this->editingId);
            $expediteur->update([
                'nom' => $this->nom,
                'category_id' => $this->category_id,
            ]);
            session()->flash('message', 'Expéditeur mis à jour avec succès.');
        } else {
            ExpediteurModel::create([
                'nom' => $this->nom,
                'category_id' => $this->category_id,
            ]);
            session()->flash('message', 'Expéditeur créé avec succès.');
        }

        $this->resetForm();
    }

    public function edit($id)
    {
        $expediteur = ExpediteurModel::findOrFail($id);
        $this->editingId = $id;
        $this->nom = $expediteur->nom;
        $this->category_id = $expediteur->category_id;
    }

    public function delete($id)
    {
        $expediteur = ExpediteurModel::findOrFail($id);
        $expediteur->delete();
        session()->flash('message', 'Expéditeur supprimé avec succès.');
    }
}
