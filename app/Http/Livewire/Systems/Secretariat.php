<?php

namespace App\Http\Livewire\Systems;

use App\Models\Direction;
use App\Models\Secretariat as Model;
use Livewire\Component;
use Livewire\WithPagination;

class Secretariat extends Component
{
    use WithPagination;
    
    public $filter;
    public $filterText;
    public $directions;
    public $search;

    protected $paginationTheme = 'bootstrap-5';
    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public function mount()
    {
        // $this->secretariats = Model::all();
        $this->filterText = "Filtre";
    }

    public function render()
    {
        $secretariats = Model::with('responsable', 'direction')->select('id','titre','direction_id','responsable_id', 'for_dg', 'for_dga');
        $this->directions = Direction::select('id','titre')->get();

        if ($this->search) {
            $secretariats = $secretariats->where('titre', 'LIKE', '%'.$this->search.'%');
        }

        switch ($this->filter) {
            case 1:
                $this->filterText = 'Filtre';
                $secretariats = $secretariats->orderBy('created_at', 'desc');
                break;
            case 2:
                $this->filterText = 'A - Z';
                $secretariats = $this->secretariats->orderBy('titre');
                break;
            case 3:
                $this->filterText = 'Z - A';
                $secretariats = $secretariats->orderBy('titre', 'desc');
                break;
            case 4:
                $this->filterText = "Date d'ajout";
                $secretariats = $secretariats->whereDate('created_at', now());
                break;
            case 5:
                $this->filterText = 'Date de modification';
                $secretariats = $secretariats->orderBy('updated_at');
                break;
            default:
                $secretariats = $secretariats->orderBy('titre');
                break;
        }

        return view('livewire.systems.secretariat')->with([
            'secretariats' => $secretariats->paginate(10)
        ]);

    }

    public function changeFilter($value)
    {
        $this->filter = $value;
    }

}
