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
use Illuminate\Support\Facades\Storage;
use Imagick;
use Illuminate\Support\Facades\Log;

class TacheDocumentController extends Controller
{
    public function store(Request $request, Tache $tache)
    {
        $request->validate([
            'file' => 'required|file',
        ]);

        // Utilisation de la classe File pour gérer le stockage au format JSON
        $fileHandler = new File();
        $fileData = $fileHandler->handle($request, 'file', 'documents');
        
        // Si aucun fichier n'a été traité (erreur)
        if (!$fileData) {
            return response()->json([
                'success' => false,
                'message' => 'Aucun fichier valide fourni.'
            ], 400);
        }
        
        // Décoder le JSON pour récupérer les informations du fichier
        $fileInfo = json_decode($fileData, true);
        $filePath = $fileInfo[0]['download_link'] ?? null;
        $originalName = $fileInfo[0]['original_name'] ?? null;

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
            'libelle' => $originalName ?? 'Document sans nom',
            'reference' => 'DOC-' . strtoupper(Str::random(8)),
            'description' => 'Document lié à la tâche ' . $tache->id,
            'document' => $fileData, // Stockage du JSON complet
            'dossier_id' => $dossier->id,
            'created_by' => Auth::id(),
            'statut_id' => 1, // Statut par défaut
            'confidentiel' => 0, // Non confidentiel par défaut
        ]);

        // Associer le document à la tâche dans la table tache_documents
        $tache->documents()->attach($document->id, [
            'created_by' => Auth::id(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Préparer la réponse JSON
        $response = [
            'success' => true,
            'message' => 'Le document a été ajouté avec succès.',
            'document' => $document,
            'tache_document' => [
                'tache_id' => $tache->id,
                'document_id' => $document->id,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        // Si c'est une requête AJAX, retourner la réponse JSON
        if ($request->ajax()) {
            return response()->json($response);
        }

        // Pour les requêtes normales, rediriger avec un message flash
        return redirect()->back()->with('success', $response['message']);
    }

    /**
     * Génère un aperçu de la première page d'un PDF
     */
    public function generatePdfPreview(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf|max:10240', // Max 10MB
        ]);

        $file = $request->file('file');
        
        try {
            // Créer un nom de fichier unique pour l'aperçu
            $previewName = 'preview_' . time() . '.jpg';
            $previewPath = storage_path('app/public/previews/' . $previewName);
            
            // Créer le répertoire s'il n'existe pas
            if (!file_exists(dirname($previewPath))) {
                mkdir(dirname($previewPath), 0777, true);
            }

            // Utiliser Imagick pour générer l'aperçu
            $imagick = new \Imagick();
            $imagick->readImage($file->getRealPath() . '[0]'); // Première page
            $imagick->setImageFormat('jpg');
            $imagick->setImageCompressionQuality(80);
            
            // Redimensionner tout en conservant le ratio
            $imagick->thumbnailImage(800, 0); // Largeur maximale de 800px
            
            // Sauvegarder l'aperçu
            $imagick->writeImage($previewPath);
            $imagick->clear();
            $imagick->destroy();
            
            // Retourner l'URL de l'aperçu
            return response()->json([
                'success' => true,
                'preview_url' => asset('storage/previews/' . $previewName)
            ]);
            
        } catch (\Exception $e) {
            Log::error('Erreur lors de la génération de l\'aperçu PDF: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Impossible de générer l\'aperçu du PDF.'
            ], 500);
        }
    }
}
