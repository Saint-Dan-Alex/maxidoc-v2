<?php

namespace App\Http\Livewire\Systems;

use App\Models\Section as Model;
use App\Models\Service;
use App\Models\Statut;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;

class Section extends Component
{
    use WithPagination;
    
    public $services;
    public $statuts;
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
        // $this->sections = Model::all();
        $this->services = Service::all();
        // $this->statuts = Statut::select('libelle', 'id')->get();
        $this->filterText = "Filtre";
    }

    public function render()
    {

        $sections = Model::with('division','service','responsable','agents')->select('id','division_id','service_id','responsable_id','titre','description');

        if ($this->search) {
            $sections = $sections->where('titre', 'LIKE', '%'.$this->search.'%');
        }

        // if ($this->search) {
        //     $this->sections = $this->sections->filter(function ($section) {
        //         return Str::contains(Str::lower($section->titre), Str::lower($this->search)) || Str::contains(Str::lower($section->description), Str::lower($this->search));
        //     });
        // } else {
        //     $this->sections = Model::all();
        // }

        switch ($this->filter) {
            case 1:
                $this->filterText = 'Filtre';
                $sections = $sections->orderBy('created_at', 'desc');
                break;
            case 2:
                $this->filterText = 'A - Z';
                $sections = $this->sections->orderBy('titre');
                break;
            case 3:
                $this->filterText = 'Z - A';
                $sections = $sections->orderBy('titre', 'desc');
                break;
            case 4:
                $this->filterText = "Date d'ajout";
                $sections = $sections->whereDate('created_at', now());
                break;
            case 5:
                $this->filterText = 'Date de modification';
                $sections = $sections->orderBy('updated_at');
                break;
            default:
                $sections = $sections->orderBy('titre');
                break;
        }

        // switch ($this->filter) {
        //     case 1:
        //         $this->filterText = 'Filtre';
        //         $this->sections = $this->sections->sortByDesc('created_at');
        //         break;
        //     case 2:
        //         $this->filterText = 'A - Z';
        //         $this->sections = $this->sections->sortBy('libelle');
        //         break;
        //     case 3:
        //         $this->filterText = 'Z - A';
        //         $this->sections = $this->sections->sortByDesc('libelle');
        //         break;
        //     case 4:
        //         $this->filterText = "Date d'ajout";
        //         $this->sections = $this->sections->sortByDesc('created_at');
        //         break;
        //     case 5:
        //         $this->filterText = 'Date de modification';
        //         $this->sections = $this->sections->sortByDesc('updated_at');
        //         break;
        //     default:
        //         # code...
        //         break;
        // }

        return view('livewire.systems.section')->with([
            'sections' => $sections->paginate(10)
        ]);

    }

    public function changeFilter($value)
    {
        $this->filter = $value;
    }

}
