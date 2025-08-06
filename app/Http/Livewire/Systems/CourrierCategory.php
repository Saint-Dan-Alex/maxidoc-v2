<?php

namespace App\Http\Livewire\Systems;

use App\Models\CourrierCategory as Model;
use Livewire\Component;
use Livewire\WithPagination;

class CourrierCategory extends Component
{
    use WithPagination;
    
    public $filter;
    public $filterText;
    public $search;
    public $title;
    public $editingId = null;

    protected $paginationTheme = 'bootstrap-5';
    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    protected $rules = [
        'title' => 'required|string|max:255'
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
            $query->where('title', 'LIKE', '%' . $this->search . '%');
        }

        // Gestion du filtrage
        switch ($this->filter) {
            case 1:
                $this->filterText = 'Filtre';
                $query->orderBy('created_at', 'desc');
                break;
            case 2:
                $this->filterText = 'A - Z';
                $query->orderBy('title', 'asc');
                break;
            case 3:
                $this->filterText = 'Z - A';
                $query->orderBy('title', 'desc');
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
                $query->orderBy('title', 'asc');
        }

        $categories = $query->paginate(10);
        
        return view('livewire.systems.courrier-category', [
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
        $this->reset(['title', 'editingId']);
        $this->resetErrorBag();
    }

    public function store()
    {
        $this->validate();

        if ($this->editingId) {
            $category = Model::findOrFail($this->editingId);
            $category->update([
                'title' => $this->title
            ]);
            session()->flash('message', 'Catégorie mise à jour avec succès.');
        } else {
            Model::create([
                'title' => $this->title
            ]);
            session()->flash('message', 'Catégorie créée avec succès.');
        }

        $this->resetForm();
        $this->dispatchBrowserEvent('close-modal');
    }

    public function edit($id)
    {
        $category = Model::findOrFail($id);
        $this->editingId = $id;
        $this->title = $category->title;
        $this->dispatchBrowserEvent('show-edit-modal');
    }

    public function delete($id)
    {
        $category = Model::findOrFail($id);
        $category->delete();
        session()->flash('message', 'Catégorie supprimée avec succès.');
    }
}
