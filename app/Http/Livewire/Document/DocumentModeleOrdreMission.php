<?php

namespace App\Http\Livewire\Document;

use Livewire\Component;

class DocumentModeleOrdreMission extends Component
{
    
    public $reference;
    public $dest;
    public $dest_mat;
    public $deste_poste;
    public $direction;
    public $location;
    public $date;
    public $division;
    public $concerne;
    public $body;
    public $lieu_date;
    public $exp_fonction;
    public $exp_name;

    protected $listeners = [
        'changeReference' => 'changeReference',
        'changeDest' => 'changeDest',
        'changeDestMat' => 'changeDestMat',
        'changeDestePoste' => 'changeDestePoste',
        'changeDirection' => 'changeDirection',
        'changeLocation' => 'changeLocation',
        'changeDate' => 'changeDate',
        'changeDivision' => 'changeDivision',
        'changeConcerne' => 'changeConcerne',
        'updateBody' => 'updateBody',
        'changeLieuDate' => 'changeLieuDate',
        'changeExpFonction' => 'changeExpFonction',
        'changeExpName' => 'changeExpName',
    ];

    public function changeReference($reference)
    {
        $this->reference = $reference;
    }
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
    public function changeLocation($location)
    {
        $this->location = $location;
    }
    public function changeDate($date)
    {
        $this->date = $date;
    }
    public function changeDivision($division)
    {
        $this->division = $division;
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

    public function render()
    {
        return view('livewire.document.document-modele-ordre-mission');
    }

}