<?php

namespace App\Http\Livewire\Document;

use App\Models\Classeur;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Illuminate\Support\Str;

class Dossiers extends Component
{
    public $classeur;
    public $dossiers;
    public $files;
    public $filter;
    public $search;
    public $filterText = 'Filtre';

    public function mount(Classeur $classeur)
    {
        $this->classeur = $classeur;
        $this->filter = "Tous";
    }

    public function render()
    {
        $this->dossiers = $this->classeur->dossiers
        ->filter(function ($dossier)
        {
            // return Gate::allows('view_dossier', $dossier);
            return Gate::allows('view', $dossier);
        });

        if ($this->search) {
            $this->dossiers = $this->dossiers->filter(function ($dossier)
            {
                return Str::contains(Str::lower($dossier->titre), Str::lower($this->search)) || Str::contains(Str::lower($dossier->reference), Str::lower($this->search));
            });
        }

        switch ($this->filter) {
            case 1:
                $this->filterText = 'Filtre';
                $this->dossiers = $this->dossiers->sortByDesc('created_at');
                break;
            case 2:
                $this->filterText = 'A - Z';
                $this->dossiers = $this->dossiers->sortBy('titre');
                break;
            case 3:
                $this->filterText = 'Z - A';
                $this->dossiers = $this->dossiers->sortByDesc('titre');
                break;
            case 4:
                $this->filterText = "Date d'ajout";
                $this->dossiers = $this->dossiers->sortByDesc('created_at');
                break;
            case 5:
                $this->filterText = 'Date de modification';
                $this->dossiers = $this->dossiers->sortByDesc('updated_at');
                break;
            default:
                # code...
                break;
        }

        return view('livewire.document.dossiers');
    }

    public function changeFilter($value)
    {
        $this->filter = $value;
    }
}
