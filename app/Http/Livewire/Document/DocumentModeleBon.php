<?php

namespace App\Http\Livewire\Document;

use Livewire\Component;

class DocumentModeleBon extends Component
{
    public $rue;
    public $num;
    public $bp;
    public $idnat;
    public $phone;
    public $email;
    public $impot;
    public $bon;
    public $fournisseur;
    public $date;
    public $location;
    public $exp_fonction;
    public $exp_name;

    public $cosignataires = [];

    protected $listeners = [
        'changeRue' => 'changeRue',
        'changeNum' => 'changeNum',
        'changeBp' => 'changeBp',
        'changeIdnat' => 'changeIdnat',
        'changePhone' => 'changePhone',
        'changeFournisseur' => 'changeFournisseur',
        'changeEmail' => 'changeEmail',
        'changeImpot' => 'changeImpot',
        'changeBon' => 'changeBon',
        'changeDate' => 'changeDate',
        'changeLocation' => 'changeLocation',
        'changeExpFonction' => 'changeExpFonction',
        'changeExpName' => 'changeExpName',
        'changeCosignataire' => 'changeCosignataire',
    ];

    public function addRow()
    {
        $this->emit('addRow');
    }

    public function changeRue($rue)
    {
        $this->rue = $rue;
    }
    public function changeNum($num)
    {
        $this->num = $num;
    }
    public function changeBp($bp)
    {
        $this->bp = $bp;
    }
    public function changeIdnat($idnat)
    {
        $this->idnat = $idnat;
    }
    public function changePhone($phone)
    {
        $this->phone = $phone;
    }
    public function changeEmail($email)
    {
        $this->email = $email;
    }
    public function changeFournisseur($fournisseur)
    {
        $this->fournisseur = $fournisseur;
    }
    public function changeImpot($impot)
    {
        $this->impot = $impot;
    }
    public function changeBon($bon)
    {
        $this->bon = $bon;
    }

    public function changeDate($date)
    {
        $this->date = $date;
    }

    public function changeLocation($location)
    {
        $this->location = $location;
    }

    public function changeExpFonction($exp_fonction)
    {
        $this->exp_fonction = $exp_fonction;
    }
    public function changeExpName($exp_name)
    {
        $this->exp_name = $exp_name;
    }

    public function changeCosignataire($cosignataires)
    {
        $this->cosignataires = $cosignataires;
    }

    public function render()
    {
        return view('livewire.document.document-modele-bon');
    }
}
