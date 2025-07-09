<?php

namespace App\Http\Livewire\Document;

use Livewire\Component;

class DocumentModeleLetter extends Component
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

    public function mount($brouillon = null)
    {
        if ($brouillon) {
            // code...
            $this->reference = session('reference', null);
            $this->lieu_copie = session('lieu_copie', null);
            $this->dest = session('dest', null);
            $this->ville = session('ville', null);
            $this->lieu_date = session('lieu_date', null);
            $this->concerne = session('concerne', null);
            $this->exp_fonction = session('exp_fonction', null);
            $this->exp_name = session('exp_name', null);
            $this->dest_fonction = session('dest_fonction', null);
            $this->dest_name = session('dest_name', null);
            $this->cosignataires = session('cosignataires', null);
            $this->body = session('body', null);
        }
    }
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
        return view('livewire.document.document-modele-letter');
    }
}
