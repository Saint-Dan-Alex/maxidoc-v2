<?php

namespace App\Http\Livewire\Archive;

use Livewire\Component;
use App\Models\CourrierFollower;
use App\Models\Document;

class AddArchiveForm extends Component
{
    public $types;
    public $natures;
    public $services;
    public $agents;
    public $sec;
    public $isDestinateur;
    public $newDoc;
    public $textSelected;
    public $fileName;

    public $followers;
    public $type;
    public $num;
    public $isFormValid = true;
    public $selectedDoc = false;
    public $isConfidentiel = false;
    public $ref;

    public function mount($types, $natures, $services, $agents, $sec, $isDestinateur, $newDoc, $textSelected, $fileName)
    {
        $this->types = $types;
        $this->natures = $natures;
        $this->services = $services;
        $this->agents = $agents;
        $this->sec = $sec;
        $this->isDestinateur = $isDestinateur;
        $this->newDoc = $newDoc;
        $this->textSelected = $textSelected;
        $this->fileName = $fileName;
        $this->followers = CourrierFollower::all();
        $this->type = $types->first()->id ?? 1;
        $this->changeNumRef();
        if ($this->newDoc) {
            $this->selectedDoc = true;
        }
    }

    public function changeNumRef()
    {
        // Format attendu: Doc-YYYY-00000001 (incrément annuel)
        $year = now()->year;
        $prefix = sprintf('Doc-%d-', $year);

        // Récupérer la dernière référence de l'année courante
        $lastRef = Document::where('reference_interne', 'like', $prefix . '%')
            ->orderBy('reference_interne', 'desc')
            ->value('reference_interne');

        $next = 1;
        if ($lastRef) {
            // Extraire les 8 derniers chiffres et incrémenter
            $lastSeq = (int) substr($lastRef, -8);
            $next = $lastSeq + 1;
        }

        $this->num = $prefix . str_pad((string) $next, 8, '0', STR_PAD_LEFT);
    }

    public function render()
    {
        return view('livewire.archive.add-archive-form');
    }

    public function changeServiceInit($id)
    {
        //
    }
}
