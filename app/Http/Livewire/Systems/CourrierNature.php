<?php

namespace App\Http\Livewire\Systems;

use App\Models\CourrierNature as NatureModel;
use App\Models\CourrierCategory;
use Livewire\Component;
use Livewire\WithPagination;

class CourrierNature extends Component
{
    use WithPagination;
    
    public $filter;
    public $filterText;
    public $search;
    public $titre;
    public $editingId = null;
    public $category_id;

    protected $paginationTheme = 'bootstrap-5';
    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    protected $rules = [
        'titre' => 'required|string|max:100',
        'category_id' => 'nullable|exists:courrier_categories,id',
    ];

    public function mount()
    {
        $this->filterText = "Filtre";
    }

    public function render()
    {
        $query = NatureModel::query();

        // Gestion de la recherche
        if ($this->search) {
            $query->where(function($q) {
                $q->where('titre', 'LIKE', '%' . $this->search . '%')
                  ->orWhere('description', 'LIKE', '%' . $this->search . '%');
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

        $natures = $query->paginate(10);
        $categories = CourrierCategory::orderBy('title')->get();
        
        return view('livewire.systems.courrier-nature', [
            'natures' => $natures,
            'categories' => $categories,
        ]);
    }

    public function changeFilter($value)
    {
        $this->filter = $value;
        $this->resetPage();
    }

    public function resetForm()
    {
        $this->reset(['titre', 'category_id', 'editingId']);
        $this->resetErrorBag();
    }

    public function store()
    {
        $this->validate();

        if ($this->editingId) {
            $nature = NatureModel::findOrFail($this->editingId);
            $nature->update([
                'titre' => $this->titre,
                'category_id' => $this->category_id,
            ]);
            $this->emit('alert', 'success', 'Nature mise à jour avec succès');
        } else {
            NatureModel::create([
                'titre' => $this->titre,
                'category_id' => $this->category_id,
            ]);
            $this->emit('alert', 'success', 'Nature créée avec succès');
        }

        $this->resetForm();
        $this->dispatchBrowserEvent('close-modal');
    }

    public function edit($id)
    {
        $nature = NatureModel::findOrFail($id);
        $this->editingId = $id;
        $this->titre = $nature->titre;
        $this->category_id = $nature->category_id;
        $this->dispatchBrowserEvent('show-edit-modal');
    }

    public function delete($id)
    {
        $nature = NatureModel::findOrFail($id);
        $nature->delete();
        $this->emit('alert', 'success', 'Nature supprimée avec succès');
    }
}
