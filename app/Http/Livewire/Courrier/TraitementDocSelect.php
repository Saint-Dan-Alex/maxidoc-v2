<?php

namespace App\Http\Livewire\Courrier;

use Livewire\Component;
use App\Models\PieceJointe;
use Illuminate\Support\Facades\Log;

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
            
            // Vérifier que les clés nécessaires existent
            if (!isset($pieceJointe['nom']) || !isset($pieceJointe['chemin']) || !isset($pieceJointe['id'])) {
                \Log::error('Pièce jointe invalide', ['data' => $pieceJointe]);
                return;
            }
            
            $this->selected = $pieceJointe['nom'];
            $this->is_original = false;
            
            // Nettoyer et normaliser le chemin
            $chemin = $pieceJointe['chemin'];
            $chemin = str_replace(['\\/', '\\\\', '\\'], '/', $chemin);
            $chemin = preg_replace('#^[/]+#', '', $chemin);
            
            // Construire l'URL complète
            $url = url('storage/' . $chemin);
            
            \Log::info('Pièce jointe sélectionnée', [
                'nom' => $pieceJointe['nom'],
                'chemin' => $chemin,
                'url' => $url
            ]);
            
            $this->emit('documentChanged', [
                'doc' => $url,
                'doc_id' => $pieceJointe['id'],
                'is_original' => false,
                'is_piece_jointe' => true,
                'courrier_id' => $this->courrier->id,
                'name' => $pieceJointe['nom']
            ]);
        } else {
            $fileObj = files($this->document);
            $originalFileObj = files($this->courrier->document?->document);
            
            $this->selected = $fileObj->link == $originalFileObj->link 
                ? $fileObj->name.' (original)' 
                : $fileObj->name;
            $this->is_original = $is_original;
            
            $this->emit('documentChanged', [
                'doc' => $fileObj->link,
                'doc_id' => $id,
                'is_original' => $this->is_original,
                'is_piece_jointe' => false,
                'courrier_id' => $this->courrier->id,
                'name' => $this->selected
            ]);
        }
    }
}
