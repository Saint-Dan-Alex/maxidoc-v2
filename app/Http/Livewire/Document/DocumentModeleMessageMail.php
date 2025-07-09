<?php

namespace App\Http\Livewire\Document;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Livewire\Component;

class DocumentModeleMessageMail extends Component
{
    public $direction;
    public $reference;
    public $lieu_date;
    public $concerne;
    public $body;
    public $exp_fonction;
    public $exp_name;

    protected $listeners = [
        'changeReference' => 'changeReference',
        'changeDirection' => 'changeDirection',
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

    public function changeConcerne($concerne)
    {
        $this->concerne = $concerne;
    }
    public function changeDirection($direction)
    {
        $this->direction = $direction;
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

        return view('livewire.document.document-modele-message-mail');
    }

}