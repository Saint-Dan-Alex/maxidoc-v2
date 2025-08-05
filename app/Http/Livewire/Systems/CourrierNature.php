<?php

namespace App\Http\Livewire\Systems;

use App\Models\CourrierNature as NatureModel;
use Livewire\Component;
use Livewire\WithPagination;

class CourrierNature extends Component
{
    use WithPagination;
    
    public $filter;
    public $filterText;
    public $search;
    public $libelle;
    public $description;
    public $editingId = null;

    protected $paginationTheme = 'bootstrap-5';
    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    protected $rules = [
        'libelle' => 'required|string|max:255',
        'description' => 'nullable|string',
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
                $q->where('libelle', 'LIKE', '%' . $this->search . '%')
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

        $natures = $query->paginate(10);
        
        return view('livewire.systems.courrier-nature', [
            'natures' => $natures
        ]);
    }

    public function changeFilter($value)
    {
        $this->filter = $value;
        $this->resetPage();
    }

    public function resetForm()
    {
        $this->reset(['libelle', 'description', 'editingId']);
        $this->resetErrorBag();
    }

    public function store()
    {
        $this->validate();

        $data = [
            'libelle' => $this->libelle,
            'description' => $this->description,
        ];

        if ($this->editingId) {
            $nature = NatureModel::findOrFail($this->editingId);
            $nature->update($data);
            session()->flash('message', 'Nature mise à jour avec succès.');
        } else {
            NatureModel::create($data);
            session()->flash('message', 'Nature créée avec succès.');
        }

        $this->resetForm();
        $this->dispatchBrowserEvent('close-modal');
    }

    public function edit($id)
    {
        $nature = NatureModel::findOrFail($id);
        $this->editingId = $id;
        $this->libelle = $nature->libelle;
        $this->description = $nature->description;
        $this->dispatchBrowserEvent('show-edit-modal');
    }

    public function delete($id)
    {
        $nature = NatureModel::findOrFail($id);
        $nature->delete();
        session()->flash('message', 'Nature supprimée avec succès.');
    }
}
