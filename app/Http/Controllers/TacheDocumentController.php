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
            // Optionnel: si on veut rattacher explicitement au document principal
            'parent_document_id' => 'nullable|integer|exists:documents,id',
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
            ->where('titre', 'Documents partagés')
            ->first();

        if (!$classer) {
            $classer = Classeur::create([
                'titre' => 'Documents partagés',
                'reference' => 'CLS-PARTAGES-' . strtoupper(Str::random(8)),
                'description' => 'Classeur pour les documents partagés (issus des tâches)',
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
            'reference' => 'DT/' . Auth::user()->agent->matricule, // Même format que dans TachePane
            'description' => 'Document lié à la tâche ' . $tache->id,
            'document' => $fileData, // Stockage du JSON complet
            'dossier_id' => $dossier->id,
            'category_id' => 5, // Catégorie pour les tâches
            'type' => 3, // Type pour les pièces jointes
            'is_piece_jointe' => 1, // Marquer comme pièce jointe
            'user_id' => Auth::id(),
            'created_by' => Auth::user()->agent->id,
            'statut_id' => 5, // Même statut que dans TachePane
            'confidentiel' => 0, // Non confidentiel par défaut
        ]);

        $document->update([
            'statut_id' => 5,
        ]);
        $document->save();

        // Rattacher (optionnel) au document principal pour affichage groupé
        // 1) Si le front fournit explicitement un parent_document_id
        $parent = null;
        if ($request->filled('parent_document_id')) {
            $parent = Document::find($request->input('parent_document_id'));
        }

        // 2) Si non fourni, tenter d'inférer le document principal via le courrier de la tâche (si disponible)
        //    Remarque: selon votre modèle, adaptez la manière de retrouver le courrier/document principal
        if (!$parent && property_exists($tache, 'courrier_id') && $tache->courrier_id) {
            // Tente de récupérer le document principal lié au courrier
            $courrier = \App\Models\Courrier::find($tache->courrier_id);
            if ($courrier) {
                if ($courrier->document_id) {
                    $parent = Document::find($courrier->document_id);
                } else {
                    // Premier document racine du courrier (sans parent)
                    $parent = $courrier->documents()->whereNull('parent_document_id')->first();
                }
            }
        }

        // 3) Si un parent est identifié, aligner les métadonnées et lier la hiérarchie
        if ($parent) {
            $document->parent_document_id = $parent->id;
            // Propager des champs utiles pour que les filtres d'affichage l'incluent avec le principal
            if (is_null($document->courrier_id)) {
                $document->courrier_id = $parent->courrier_id;
            }
            // Aligner le statut et éventuellement le mark_as_done si votre index l'utilise
            $document->statut_id = $parent->statut_id ?? $document->statut_id;
            if (isset($parent->mark_as_done)) {
                $document->mark_as_done = $parent->mark_as_done;
            }
            $document->save();
        }


        // Associer le document à la tâche dans la table tache_documents
        // Le statut est déjà défini lors de la création du document
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
