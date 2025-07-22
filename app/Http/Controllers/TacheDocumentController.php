<?php

namespace App\Http\Controllers;

use App\Models\Classeur;
use App\Models\Dossier;
use App\Models\Document;
use App\Models\Tache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Spatie\PdfToImage\Pdf;
use Intervention\Image\ImageManagerStatic as Image;

class TacheDocumentController extends Controller
{
    public function store(Request $request, Tache $tache)
    {
        $request->validate([
            'file' => 'required|file',
        ]);

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('documents', $fileName, 'public');

        $classer = Classeur::where('direction_id', Auth::user()->agent->direction_id)
            ->where('titre', 'Classeur Tâches ' . Auth::user()->agent->direction?->titre)
            ->first();

        if (!$classer) {
            $classer = Classeur::create([
                'titre' => 'Classeur Tâches ' . Auth::user()->agent->direction?->titre,
                'reference' => 'CLS-TACHES-' . strtoupper(Str::random(8)),
                'description' => 'Classeur pour les documents des tâches',
                'direction_id' => Auth::user()->agent->direction_id,
                'created_by' => Auth::id(),
            ]);
        }

        $dossier = Dossier::where('classeur_id', $classer->id)
            ->where('titre', 'Tâche ' . $tache->id)
            ->first();

        if (!$dossier) {
            $dossier = Dossier::create([
                'titre' => 'Tâche ' . $tache->id,
                'reference' => 'DOS-TACHE-' . $tache->id,
                'description' => 'Dossier pour la tâche ' . $tache->id,
                'classeur_id' => $classer->id,
                'created_by' => Auth::id(),
            ]);
        }

        $document = Document::create([
            'libelle' => $file->getClientOriginalName(),
            'reference' => 'DOC-' . strtoupper(Str::random(8)),
            'description' => 'Document lié à la tâche ' . $tache->id,
            'document' => $filePath,
            'dossier_id' => $dossier->id,
            'created_by' => Auth::id(),
            'statut_id' => 1, // Statut par défaut
            'confidentiel' => 0, // Non confidentiel par défaut
        ]);

        // Associer le document à la tâche dans la table tache_documents
        $tache->documents()->attach($document->id, [
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'document' => $document,
            'tache_document' => [
                'tache_id' => $tache->id,
                'document_id' => $document->id,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
