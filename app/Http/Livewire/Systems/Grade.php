<?php

namespace App\Http\Livewire\Systems;

use App\Models\Grade as Model;
use Illuminate\Support\Str;
use Livewire\Component;

class Grade extends Component
{
    public $grades;
    public $filter;
    public $filterText;
    public $search;

    public function mount()
    {
        $this->grades = Model::all();
        $this->filterText = "Filtre";
    }

    public function render()
    {

        if ($this->search) {
            $this->grades = $this->grades->filter(function ($grade) {
                return Str::contains(Str::lower($grade->titre), Str::lower($this->search)) || Str::contains(Str::lower($grade->description), Str::lower($this->search));
            });
        } else {
            $this->grades = Model::all();
        }

        switch ($this->filter) {
            case 1:
                $this->filterText = 'Filtre';
                $this->grades = $this->grades->sortByDesc('created_at');
                break;
            case 2:
                $this->filterText = 'A - Z';
                $this->grades = $this->grades->sortBy('titre');
                break;
            case 3:
                $this->filterText = 'Z - A';
                $this->grades = $this->grades->sortByDesc('titre');
                break;
            case 4:
                $this->filterText = "Date d'ajout";
                $this->grades = $this->grades->sortByDesc('created_at');
                break;
            case 5:
                $this->filterText = 'Date de modification';
                $this->grades = $this->grades->sortByDesc('updated_at');
                break;
            default:
                # code...
                break;
        }

        return view('livewire.systems.grade');

    }

    public function changeFilter($value)
    {
        $this->filter = $value;
    }

}
