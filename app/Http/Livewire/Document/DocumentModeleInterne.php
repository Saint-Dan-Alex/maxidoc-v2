<?php

namespace App\Http\Livewire\Document;

use Livewire\Component;

class DocumentModeleInterne extends Component
{
    public $dest;
    public $dest_mat;
    public $deste_poste;
    public $direction;
    public $division;
    public $section;
    public $reference;
    public $directeur;
    public $lieu_date;
    public $exp_fonction;
    public $exp_name;
    public $dest_fonction;
    public $dest_name;
    public $concerne;
    public $body;

    protected $listeners = [
        'changeDest' => 'changeDest',
        'changeDestMat' => 'changeDestMat',
        'changeDestePoste' => 'changeDestePoste',
        'changeDirection' => 'changeDirection',
        'changeDivision' => 'changeDivision',
        'changeSection' => 'changeSection',
        'changeReference' => 'changeReference',
        'changeDirecteur' => 'changeDirecteur',
        'changeLieuDate' => 'changeLieuDate',
        'changeExpFonction' => 'changeExpFonction',
        'changeExpName' => 'changeExpName',
        'changeDestFonction' => 'changeDestFonction',
        'changeDestName' => 'changeDestName',
        'changeConcerne' => 'changeConcerne',
        'updateBody' => 'updateBody',
    ];


    public function changeDest($dest)
    {
        $this->dest = $dest;
    }

    public function changeDestMat($dest_mat)
    {
        $this->dest_mat = $dest_mat;
    }

    public function changeDestePoste($deste_poste)
    {
        $this->deste_poste = $deste_poste;
    }

    public function changeDirection($direction)
    {
        $this->direction = $direction;
    }

    public function changeDivision($division)
    {
        $this->division = $division;
    }

    public function changeSection($section)
    {
        $this->section = $section;
    }

    public function changeReference($reference)
    {
        $this->reference = $reference;
    }

    public function changeDirecteur($directeur)
    {
        $this->directeur = $directeur;
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

    public function changeConcerne($concerne)
    {
        $this->concerne = $concerne;
    }

    public function updateBody($body)
    {
        $this->body = $body;
    }


    public function render()
    {
        return view('livewire.document.document-modele-interne');
    }
}
