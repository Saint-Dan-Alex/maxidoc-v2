<?php

namespace App\Http\Livewire\Courrier;

use Livewire\Component;
use App\Models\PieceJointe;

class TraitementDocSelect extends Component
{
    public $courrier;
    public $document;
    public $selected;
    public $is_original;

    public function mount($courrier) {
        $this->courrier = $courrier;
        if ($this->courrier->traitements->count()) {
            if ($this->courrier->traitements->last()->document_url) {
                $this->selectDoc($this->courrier->traitements->last()->document_url, $this->courrier->traitements->last()->id);
                $this->is_original = false;
            }else {
                $this->selectDoc($this->courrier->document?->document, $this->courrier->document?->id);
                $this->is_original = true;
            }
        } else {
            $this->selectDoc($this->courrier->document?->document, $this->courrier->document?->id);
            $this->is_original = true;
        }

    }

    public function render()
    {
        $piecesJointes = $this->courrier->piecesJointes()->get();
        return view('livewire.courrier.traitement-doc-select', [
            'piecesJointes' => $piecesJointes
        ]);
    }

    public function selectDoc($document, $id, $is_original = false, $is_piece_jointe = false) {
        $this->document = $document;
        
        if ($is_piece_jointe) {
            // Si c'est une pièce jointe, $document est un tableau (déjà décodé depuis JSON)
            $pieceJointe = is_string($document) ? json_decode($document, true) : (array)$document;
            $this->selected = $pieceJointe['nom'];
            $this->is_original = false;
            $this->emit('documentChanged', [
                'doc' => asset('storage/' . $pieceJointe['chemin']),
                'doc_id' => $pieceJointe['id'],
                'is_original' => false,
                'is_piece_jointe' => true,
                'courrier_id' => $this->courrier->id,
            ]);
        } else {
            $this->selected = files($this->document)->link == files($this->courrier->document?->document)->link 
                ? files($this->document)->name.' (original)' 
                : files($this->document)->name;
            $this->is_original = $is_original;
            $this->emit('documentChanged', [
                'doc' => files($this->document)->link,
                'doc_id' => $id,
                'is_original' => $this->is_original,
                'is_piece_jointe' => false,
                'courrier_id' => $this->courrier->id,
            ]);
        }
    }
}
