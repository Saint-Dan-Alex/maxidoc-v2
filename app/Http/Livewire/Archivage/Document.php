<?php

namespace App\Http\Livewire\Archivage;

use App\Models\Document as ModelsDocument;
use App\Models\Dossier;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Livewire\Component;

class Document extends Component
{
    public $dossier;
    public $documents;
    public $filter;
    public $filterText = 'Filtre';
    public $search;

    public function mount(Dossier $dossier)
    {
        $this->dossier = $dossier;
        // $this->filterText = "Filtre";
    }

    public function render()
    {
        $this->documents = ModelsDocument::archive()->where('dossier_id', $this->dossier->id)->get();

        if ($this->search) {
            $this->documents = $this->documents->filter(function ($document)
            {
                return Str::contains(Str::lower($document->titre), Str::lower($this->search)) || Str::contains(Str::lower($document->reference), Str::lower($this->search));
            });
        }

        switch ($this->filter) {
            case 1:
                $this->filterText = 'Filtre';
                $this->documents = $this->documents->sortByDesc('created_at');
                break;
            case 2:
                $this->filterText = 'A - Z';
                $this->documents = $this->documents->sortBy('titre');
                break;
            case 3:
                $this->filterText = 'Z - A';
                $this->documents = $this->documents->sortByDesc('titre');
                break;
            case 4:
                $this->filterText = "Date d'ajout";
                $this->documents = $this->documents->sortByDesc('created_at');
                break;
            case 5:
                $this->filterText = 'Date de modification';
                $this->documents = $this->documents->sortByDesc('updated_at');
                break;
            default:
                # code...
                break;
        }

        return view('livewire.archivage.document');
    }

    public function changeFilter($value)
    {
        $this->filter = $value;
    }
}
