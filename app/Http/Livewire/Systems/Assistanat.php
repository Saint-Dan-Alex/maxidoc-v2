<?php

namespace App\Http\Livewire\Systems;

use App\Models\Assistanat as Model;
use App\Models\Direction;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class Assistanat extends Component
{
    use WithPagination;
    // public $assistants;
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
        // $this->assistants = Model::all();
        $this->filterText = "Filtre";
    }

    public function render()
    {

        $assistants = Model::with('responsable','direction')->select('id','titre','direction_id','responsable_id', 'for_dg', 'for_dga');
        $this->directions = Direction::select('id','titre')->get();

        if ($this->search) {
            $assistants = $assistants->where('titre', 'LIKE', '%'.$this->search.'%');
        }

        switch ($this->filter) {
            case 1:
                $this->filterText = 'Filtre';
                $assistants = $assistants->orderBy('created_at', 'desc');
                break;
            case 2:
                $this->filterText = 'A - Z';
                $assistants = $this->assistants->orderBy('titre');
                break;
            case 3:
                $this->filterText = 'Z - A';
                $assistants = $assistants->orderBy('titre', 'desc');
                break;
            case 4:
                $this->filterText = "Date d'ajout";
                $assistants = $assistants->whereDate('created_at', now());
                break;
            case 5:
                $this->filterText = 'Date de modification';
                $assistants = $assistants->orderBy('updated_at');
                break;
            default:
                $assistants = $assistants->orderBy('titre');
                break;
        }

        // if ($this->search) {
        //     $this->assistants = $this->assistants->filter(function ($assistant) {
        //         return Str::contains(Str::lower($assistant->libelle), Str::lower($this->search));
        //     });
        // } else {
        //     $this->assistants = Model::all();
        // }

        // switch ($this->filter) {
        //     case 1:
        //         $this->filterText = 'Filtre';
        //         $this->assistants = $this->assistants->sortByDesc('created_at');
        //         break;
        //     case 2:
        //         $this->filterText = 'A - Z';
        //         $this->assistants = $this->assistants->sortBy('libelle');
        //         break;
        //     case 3:
        //         $this->filterText = 'Z - A';
        //         $this->assistants = $this->assistants->sortByDesc('libelle');
        //         break;
        //     case 4:
        //         $this->filterText = "Date d'ajout";
        //         $this->assistants = $this->assistants->sortByDesc('created_at');
        //         break;
        //     case 5:
        //         $this->filterText = 'Date de modification';
        //         $this->assistants = $this->assistants->sortByDesc('updated_at');
        //         break;
        //     default:
        //         # code...
        //         break;
        // }

        return view('livewire.systems.assistanat')->with([
            'assistants' => $assistants->paginate(10)
        ]);

    }

    public function changeFilter($value)
    {
        $this->filter = $value;
    }

}
