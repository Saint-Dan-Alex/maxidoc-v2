<?php

namespace App\Http\Livewire\Document;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Livewire\Component;

class DocumentModele extends Component
{
    public $reference;
    public $copies;
    public $lieu_copie;
    public $dest;
    public $ville;
    public $lieu_date;
    public $exp_fonction;
    public $exp_name;
    public $dest_fonction;
    public $dest_name;
    public $concerne;
    public $body;
    public $cosignataires = [];

    protected $listeners = [
        'changeReference' => 'changeReference',
        'changeCopie' => 'changeCopie',
        'changeLieuCopie' => 'changeLieuCopie',
        'changeDest' => 'changeDest',
        'changeVille' => 'changeVille',
        'changeLieuDate' => 'changeLieuDate',
        'changeConcerne' => 'changeConcerne',
        'changeExpFonction' => 'changeExpFonction',
        'changeExpName' => 'changeExpName',
        'changeDestFonction' => 'changeDestFonction',
        'changeDestName' => 'changeDestName',
        'updateBody' => 'updateBody',
        'changeCosignataire' => 'changeCosignataire',
    ];

    public function changeReference($reference)
    {
        $this->reference = $reference;
    }

    public function changeCopie($copies)
    {
        $this->copies = $copies;
    }
    public function changeLieuCopie($lieu)
    {
        $this->lieu_copie = $lieu;
    }
    public function changeDest($dest)
    {
        $this->dest = $dest;
    }
    public function changeVille($ville)
    {
        $this->ville = $ville;
    }

    public function changeLieuDate($lieu_date)
    {
        $this->lieu_date = $lieu_date;
    }

    public function changeConcerne($concerne)
    {
        $this->concerne = $concerne;
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

    public function updateBody($body)
    {
        $this->body = $body;
    }

    public function render()
    {

        return view('livewire.document.document-modele');
    }

}