<?php

namespace App\Http\Livewire\Document;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Livewire\Component;

class DocumentModeleNoteCirculaire extends Component
{

    public $copies;
    public $reference;
    public $lieu_date;
    public $concerne;
    public $body;
    public $exp_fonction;
    public $exp_name;
    public $dest_fonction;
    public $dest_name;
    public $cosignataires = [];

    protected $listeners = [
        'changeReference' => 'changeReference',
        'changeCopie' => 'changeCopie',
        'changeConcerne' => 'changeConcerne',
        'updateBody' => 'updateBody',
        'changeLieuDate' => 'changeLieuDate',
        'changeExpFonction' => 'changeExpFonction',
        'changeExpName' => 'changeExpName',
        'changeDestFonction' => 'changeDestFonction',
        'changeDestName' => 'changeDestName',
        'changeCosignataire' => 'changeCosignataire',
    ];

    public function changeCopie($copies)
    {
        $this->copies = $copies;
    }
    public function changeReference($reference)
    {
        $this->reference = $reference;
    }

    public function changeConcerne($concerne)
    {
        $this->concerne = $concerne;
    }

    public function updateBody($body)
    {
        $this->body = $body;
    }
    public function changeLieuDate($lieu_date)
    {
        $this->lieu_date = $lieu_date;
    }
    public function changeExpFonction($exp_fonction)
    {
        $this->exp_fonction = $exp_fonction;
    }
    public function changeExpName($exp_name)
    {
        $this->exp_name = $exp_name;
    }
    public function changeDestFonction($dest_fonction)
    {
        $this->dest_fonction = $dest_fonction;
    }
    public function changeDestName($dest_name)
    {
        $this->dest_name = $dest_name;
    }
    public function changeCosignataire($cosignataires)
    {
        $this->cosignataires = $cosignataires;
    }

    public function render()
    {

        return view('livewire.document.document-modele-note-circulaire');
    }

}