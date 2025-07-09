<?php

namespace App\Http\Livewire\Systems;

use App\Models\Direction;
use App\Models\Division as Model;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class Division extends Component
{
    use WithPagination;

    public $filter;
    public $directions;
    protected $divisions;
    public $filterText;
    public $search;

    protected $paginationTheme = 'bootstrap-5';
    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public function mount($divisions)
    {
        $this->divisions = $divisions;
        $this->filterText = "Filtre";
    }

    public function render()
    {
        $divisions = $this->divisions; //Model::with('responsable','direction')->select('id','libelle','direction_id','responsable_id');
        // $this->directions = Direction::select('id','titre')->get();

        if ($divisions == null) {
            $divisions = Model::with('responsable','direction')->select('id','libelle','direction_id','responsable_id');
        }

        if ($this->search) {
            $divisions = $divisions->where('libelle', 'LIKE', '%'.$this->search.'%');
        }

        switch ($this->filter) {
            case 1:
                $this->filterText = 'Filtre';
                $divisions = $divisions->orderBy('created_at', 'desc');
                break;
            case 2:
                $this->filterText = 'A - Z';
                $divisions = $this->divisions->orderBy('libelle');
                break;
            case 3:
                $this->filterText = 'Z - A';
                $divisions = $divisions->orderBy('libelle', 'desc');
                break;
            case 4:
                $this->filterText = "Date d'ajout";
                $divisions = $divisions->whereDate('created_at', now());
                break;
            case 5:
                $this->filterText = 'Date de modification';
                $divisions = $divisions->orderBy('updated_at');
                break;
            default:
                $divisions = $divisions->orderBy('libelle');
                break;
        }

        return view('livewire.systems.division')->with([
            'divisions' => $divisions->paginate(10)
        ]);

    }

    public function changeFilter($value)
    {
        $this->filter = $value;
    }

}
