<?php

namespace App\Http\Livewire\Systems;

use App\Models\Direction as Model;
use App\Models\LieuAffectation;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Direction extends Component
{
    use WithPagination;

    public $filter;
    public $filterText;
    public $lieus;
    protected $directions;
    public $users;
    public $search;

    protected $paginationTheme = 'bootstrap-5';
    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public function mount($directions)
    {
        $this->directions = $directions;
        // $this->lieus = $lieus;
        $this->filterText = "Filtre";
    }

    public function render()
    {
        $directions = $this->directions;
        // $this->lieus = LieuAffectation::select('id','titre')->get();
        // $this->users = User::select('name', 'id')->limit(50)->get();

        if ($directions == null) {
            $directions = Model::with('lieu','responsable')->select('id','titre','lieu_id','responsable_id','code', 'adjoint_id');
        }

        if ($this->search) {
            $directions = $directions->where('titre', 'LIKE', '%'.$this->search.'%');
            // filter(function ($lieu) {
            //     return Str::contains(Str::lower($lieu->titre), Str::lower($this->search));
            // });
        }

        switch ($this->filter) {
            case 1:
                $this->filterText = 'Filtre';
                $directions = $directions->orderBy('created_at', 'desc');
                break;
            case 2:
                $this->filterText = 'A - Z';
                $directions = $this->directions->orderBy('titre');
                break;
            case 3:
                $this->filterText = 'Z - A';
                $directions = $directions->orderBy('titre', 'desc');
                break;
            case 4:
                $this->filterText = "Date d'ajout";
                $directions = $directions->whereDate('created_at', now());
                break;
            case 5:
                $this->filterText = 'Date de modification';
                $directions = $directions->orderBy('updated_at');
                break;
            case 6:
                $this->filterText = "Lieu d'Affectation";
                $directions = $directions->orderBy('lieu_id');
                break;
            default:
                $directions = $directions->orderBy('titre');
                break;
        }

        return view('livewire.systems.direction')->with([
            'directions' => $directions->paginate(10)
        ]);
    }

    public function changeFilter($value)
    {
        $this->filter = $value;
    }

}
