<?php

namespace App\Http\Livewire\Systems;

use App\Models\Direction;
use App\Models\Division;
use App\Models\Service as Model;
use Livewire\Component;
use Livewire\WithPagination;
use Str;

class Service extends Component
{
    use WithPagination;
    
    public $divisions;
    public $directions;
    public $filter;
    public $filterText;
    public $search;

    protected $paginationTheme = 'bootstrap-5';
    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public function mount()
    {
        // $this->services = Model::all();
        $this->filterText = "Filtre";
    }

    public function render()
    {
        $services = Model::with('responsable','direction', 'division', 'direction')->select('id', 'direction_id', 'division_id','responsable_id','titre');
        $this->divisions = Division::select('id','libelle')->get();
        $this->directions = Direction::select('id','titre')->get();
        // $this->directions = Direction::select('id','titre')->get();

        if ($this->search) {
            $services = $services->where('titre', 'LIKE', '%'.$this->search.'%');
        }

        switch ($this->filter) {
            case 1:
                $this->filterText = 'Filtre';
                $services = $services->orderBy('created_at', 'desc');
                break;
            case 2:
                $this->filterText = 'A - Z';
                $services = $this->services->orderBy('titre');
                break;
            case 3:
                $this->filterText = 'Z - A';
                $services = $services->orderBy('titre', 'desc');
                break;
            case 4:
                $this->filterText = "Date d'ajout";
                $services = $services->whereDate('created_at', now());
                break;
            case 5:
                $this->filterText = 'Date de modification';
                $services = $services->orderBy('updated_at');
                break;
            default:
                $services = $services->orderBy('titre');
                break;
        }

        // if ($this->search) {
        //     $this->services = $this->services->filter(function ($service) {
        //         return Str::contains(Str::lower($service->titre), Str::lower($this->search)) || Str::contains(Str::lower($service->description), Str::lower($this->search));
        //     });
        // } else {
        //     $this->services = Model::all();
        // }

        // switch ($this->filter) {
        //     case 1:
        //         $this->filterText = 'Filtre';
        //         $this->services = $this->services->sortByDesc('created_at');
        //         break;
        //     case 2:
        //         $this->filterText = 'A - Z';
        //         $this->services = $this->services->sortBy('titre');
        //         break;
        //     case 3:
        //         $this->filterText = 'Z - A';
        //         $this->services = $this->services->sortByDesc('titre');
        //         break;
        //     case 4:
        //         $this->filterText = "Date d'ajout";
        //         $this->services = $this->services->sortByDesc('created_at');
        //         break;
        //     case 5:
        //         $this->filterText = 'Date de modification';
        //         $this->services = $this->services->sortByDesc('updated_at');
        //         break;
        //     default:
        //         # code...
        //         break;
        // }

        return view('livewire.systems.service')->with([
            'services' => $services->paginate(10)
        ]);

    }

    public function changeFilter($value)
    {
        $this->filter = $value;
    }

}
