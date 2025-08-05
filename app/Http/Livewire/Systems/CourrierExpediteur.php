<?php

namespace App\Http\Livewire\Systems;

use App\Models\CourrierExpediteur as ExpediteurModel;
use Livewire\Component;
use Livewire\WithPagination;

class CourrierExpediteur extends Component
{
    use WithPagination;
    
    public $filter;
    public $filterText;
    public $search;
    public $nom;
    public $adresse;
    public $telephone;
    public $email;
    public $editingId = null;

    protected $paginationTheme = 'bootstrap-5';
    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    protected $rules = [
        'nom' => 'required|string|max:255',
        'adresse' => 'nullable|string|max:255',
        'telephone' => 'nullable|string|max:20',
        'email' => 'nullable|email|max:255',
    ];

    public function mount()
    {
        $this->filterText = "Filtre";
    }

    public function render()
    {
        $query = ExpediteurModel::query();

        // Gestion de la recherche
        if ($this->search) {
            $query->where(function($q) {
                $q->where('nom', 'LIKE', '%' . $this->search . '%')
                  ->orWhere('email', 'LIKE', '%' . $this->search . '%')
                  ->orWhere('telephone', 'LIKE', '%' . $this->search . '%');
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
                $query->orderBy('nom', 'asc');
                break;
            case 3:
                $this->filterText = 'Z - A';
                $query->orderBy('nom', 'desc');
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
        
        return view('livewire.systems.courrier-expediteur', [
            'expediteurs' => $expediteurs
        ]);
    }

    public function changeFilter($value)
    {
        $this->filter = $value;
        $this->resetPage();
    }

    public function resetForm()
    {
        $this->reset(['nom', 'adresse', 'telephone', 'email', 'editingId']);
        $this->resetErrorBag();
    }

    public function store()
    {
        $this->validate();

        $data = [
            'nom' => $this->nom,
            'adresse' => $this->adresse,
            'telephone' => $this->telephone,
            'email' => $this->email,
        ];

        if ($this->editingId) {
            $expediteur = ExpediteurModel::findOrFail($this->editingId);
            $expediteur->update($data);
            session()->flash('message', 'Expéditeur mis à jour avec succès.');
        } else {
            ExpediteurModel::create($data);
            session()->flash('message', 'Expéditeur créé avec succès.');
        }

        $this->resetForm();
        $this->dispatchBrowserEvent('close-modal');
    }

    public function edit($id)
    {
        $expediteur = ExpediteurModel::findOrFail($id);
        $this->editingId = $id;
        $this->nom = $expediteur->nom;
        $this->adresse = $expediteur->adresse;
        $this->telephone = $expediteur->telephone;
        $this->email = $expediteur->email;
        $this->dispatchBrowserEvent('show-edit-modal');
    }

    public function delete($id)
    {
        $expediteur = ExpediteurModel::findOrFail($id);
        $expediteur->delete();
        session()->flash('message', 'Expéditeur supprimé avec succès.');
    }
}
