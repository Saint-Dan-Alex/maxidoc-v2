<?php

namespace App\Http\Livewire\Systems;

use App\Models\Fonction as Model;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class Fonction extends Component
{
    use WithPagination;
    public $fonctions;
    public $filter;
    public $filterText;
    public $search;

    protected $listeners = ['reloadFonction' => '$refresh'];
    protected $paginationTheme = 'bootstrap-5';
    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public function mount()
    {
        $this->fonctions = Model::all();
        $this->filterText = "Filtre";
    }

    public function render()
    {

        if ($this->search) {
            $this->fonctions = $this->fonctions->filter(function ($fonction) {
                return Str::contains(Str::lower($fonction->titre), Str::lower($this->search)) || Str::contains(Str::lower($fonction->description), Str::lower($this->search));
            });
        } else {
            $this->fonctions = Model::all();
        }

        switch ($this->filter) {
            case 1:
                $this->filterText = 'Filtre';
                $this->fonctions = $this->fonctions->sortByDesc('created_at');
                break;
            case 2:
                $this->filterText = 'A - Z';
                $this->fonctions = $this->fonctions->sortBy('titre');
                break;
            case 3:
                $this->filterText = 'Z - A';
                $this->fonctions = $this->fonctions->sortByDesc('titre');
                break;
            case 4:
                $this->filterText = "Date d'ajout";
                $this->fonctions = $this->fonctions->sortByDesc('created_at');
                break;
            case 5:
                $this->filterText = 'Date de modification';
                $this->fonctions = $this->fonctions->sortByDesc('updated_at');
                break;
            default:
                # code...
                break;
        }

        return view('livewire.systems.fonction');

    }

    public function changeFilter($value)
    {
        $this->filter = $value;
    }

}
