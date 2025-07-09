<?php

namespace App\Http\Livewire\Courrier;

use App\Models\Document;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class SelectDocument extends Component
{
    public $documents;
    public $doc;

    public function render()
    {
        $this->documents = Document::where('statut_id', '!=', 6)->orderByDesc('created_at')->get()->filter(function ($document)
        {
            return Gate::allows('view', $document);
        });

        return view('livewire.courrier.select-document');
    }

    public function selectedDoc($id){
        $this->doc = $id;
    }

    public function selectDoc()
    {
        $this->emit('selectDoc', $this->doc);
    }
}
