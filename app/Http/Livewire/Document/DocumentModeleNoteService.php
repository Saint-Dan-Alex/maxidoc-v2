<?php

namespace App\Http\Livewire\Document;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Component;

class DocumentModeleNoteService extends Component
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


   

    public function generatePDF()
    {
        // Collecter les données à partir du composant Livewire
        $data = [
            'field1' => $this->field1,
            'field2' => $this->field2,
            'field3' => $this->field3,
            // Ajouter toutes les données nécessaires pour le PDF
        ];

        // Générer la vue HTML du PDF
        $pdfContent = view('livewire.template-pdf', $data)->render();

        // Générer le PDF avec DomPDF
        $pdf = Pdf::loadHTML($pdfContent);

        // Télécharger ou enregistrer le PDF
        return response()->streamDownload(
            fn() => print($pdf->output()),
            'document.pdf'
        );
    }

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
        // dd($this->body);
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

        return view('livewire.document.document-modele-note-service');
    }

}