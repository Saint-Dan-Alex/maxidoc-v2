<?php

namespace App\Http\Livewire\Archivage;

use App\Models\Classeur;
use App\Models\Document;
use App\Models\DocumentArchivage;
use App\Models\Dossier;
use App\Models\LieuAffectation;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Illuminate\Support\Str;

class ArchivageDashboard extends Component
{
    public $classeurs;
    public $groupeFiles;
    public $filter;
    public $search;

    public function mount()
    {
        $this->filter = "Tous";
    }

    public function render()
    {
        // $this->classeurs = Classeur::orderBy('created_at', 'desc')->get()->filter(function ($classeur)
        // {
        //     return Gate::allows('view_classeur', $classeur);
        // });

        // $this->dossiers = Dossier::orderBy('created_at', 'desc')->get()->filter(function ($dossier)
        // {
        //     return Gate::allows('view_dossier', $dossier);
        // });

        // $this->groupeFiles = Document::archive()->select('created_at')->orderBy('created_at', 'desc')->get();
        // dd(Document::archive()->get());


        // ->filter(function ($document)
        // {
        //     return Gate::allows('view_document', $document);
        // });

        // if ($this->search) {
        //     if ($this->filter == 'Tous') {
        //         $this->classeurs = $this->classeurs->filter(function ($classeur)
        //         {
        //             return Str::contains($classeur->titre, $this->search) || Str::contains($classeur->reference, $this->search);
        //         });
        //         // ->where('titre', 'like', '%' . $this->search . '%')->all();
        //         $this->dossiers = $this->dossiers->filter(function ($dossier)
        //         {
        //             return Str::contains($dossier->titre, $this->search) || Str::contains($dossier->reference, $this->search);
        //         });
        //         // ->where('titre', 'like', '%' . $this->search . '%')->all();
        //         $this->files = $this->files->filter(function ($file)
        //         {
        //             return Str::contains($file->titre, $this->search) || Str::contains($file->reference, $this->search);
        //         });
        //         // ->where('titre', 'like', '%' . $this->search . '%')->all();
        //     }elseif ($this->filter == 'Classeurs') {
        //         $this->classeurs = $this->classeurs->filter(function ($classeur)
        //         {
        //             return Str::contains($classeur->titre, $this->search) || Str::contains($classeur->reference, $this->search);
        //         });
        //     }elseif ($this->filter == 'Dossiers') {
        //         $this->dossiers = $this->dossiers->filter(function ($dossier)
        //         {
        //             return Str::contains($dossier->titre, $this->search) || Str::contains($dossier->reference, $this->search);
        //         });
        //     }elseif ($this->filter == 'Documents') {
        //         $this->files = $this->files->filter(function ($file)
        //         {
        //             return Str::contains($file->titre, $this->search) || Str::contains($file->reference, $this->search);
        //         });
        //     }
        // }

        // $lieux = LieuAffectation::with('agents')->whereHas('agents', function($query){
        //     $query->withWhereHas('user', function($sql){
        //         $sql->whereHas('documents',function($sql2){
        //             $sql2->whereIn('documents.id', Document::get()->filter(function ($document) {
        //                 return $document->statut_id == 6 && Gate::allows('view', $document);
        //             })->pluck('id')->toArray());
        //         });
        //     });
        // })->get();

        // dd($lieux);
        $this->groupeFiles = Document::archive()->select('created_at')->orderBy('created_at', 'desc')->get();


        return view('livewire.archivage.archivage-dashboard');
    }

    public function changeFilter($value)
    {
        $this->filter = $value;
    }
}
