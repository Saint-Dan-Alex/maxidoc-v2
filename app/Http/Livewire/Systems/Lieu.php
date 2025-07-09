<?php

namespace App\Http\Livewire\Systems;

use App\Models\LieuAffectation as Model;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class Lieu extends Component
{
    use WithPagination;

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
        $this->filterText = "Filtre";
    }

    public function render()
    {
        $lieus = Model::select('id','titre');

        if ($this->search) {
            $lieus = $lieus->where('titre', 'LIKE', '%'.$this->search.'%');
            // filter(function ($lieu) {
            //     return Str::contains(Str::lower($lieu->titre), Str::lower($this->search));
            // });
        }

        switch ($this->filter) {
            case 1:
                $this->filterText = 'Filtre';
                $lieus = $lieus->orderBy('created_at', 'desc');
                break;
            case 2:
                $this->filterText = 'A - Z';
                $lieus = $this->lieus->orderBy('titre');
                break;
            case 3:
                $this->filterText = 'Z - A';
                $lieus = $lieus->orderBy('titre', 'desc');
                break;
            case 4:
                $this->filterText = "Date d'ajout";
                $lieus = $lieus->whereDate('created_at', now());
                break;
            case 5:
                $this->filterText = 'Date de modification';
                $lieus = $lieus->orderBy('updated_at');
                break;
            default:
                $lieus = $lieus->orderBy('titre');
                break;
        }

        return view('livewire.systems.lieu')->with([
            'lieus' => $lieus->paginate(10)
        ]);

    }

    public function changeFilter($value)
    {
        $this->filter = $value;
    }

}
