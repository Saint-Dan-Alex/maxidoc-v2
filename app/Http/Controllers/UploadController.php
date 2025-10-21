<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class UploadController extends Controller
{
    /**
     * Upload multiple documents (images, PDFs, etc.)
     * Compatible avec Hostinger
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function store(Request $request)
    {
        try {
            // Validation des fichiers
            $request->validate([
                'documents' => 'required|array',
                'documents.*' => 'required|file|mimes:pdf,jpg,jpeg,png,gif,doc,docx,xls,xlsx|max:10240', // 10MB max
            ]);
            
            if (!$request->hasFile('documents')) {
                Log::error('Aucun fichier document trouvé dans la requête');
                return response()->json([
                    'success' => false,
                    'message' => 'Aucun fichier n\'a été envoyé'
                ], 400);
            }
            
            $files = $request->file('documents');
            $folder = uniqid() . '-' . now()->timestamp;
            $path = 'tmp/' . $folder;
            $uploadedFiles = [];
            $errors = [];
            
            // Créer le répertoire de destination avec les bonnes permissions
            $fullPath = storage_path('app/public/' . $path);
            if (!file_exists($fullPath)) {
                if (!mkdir($fullPath, 0755, true)) {
                    Log::error('Impossible de créer le répertoire d\'upload', [
                        'path' => $fullPath,
                        'parent_writable' => is_writable(dirname($fullPath))
                    ]);
                    return response()->json([
                        'success' => false,
                        'message' => 'Impossible de créer le dossier d\'upload. Vérifiez les permissions.'
                    ], 500);
                }
            }
            
            // Vérifier que le dossier est accessible en écriture
            if (!is_writable($fullPath)) {
                Log::error('Le répertoire d\'upload n\'est pas accessible en écriture', [
                    'path' => $fullPath,
                    'permissions' => substr(sprintf('%o', fileperms($fullPath)), -4)
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Le dossier d\'upload n\'a pas les bonnes permissions.'
                ], 500);
            }

            foreach ($files as $index => $file) {
                if (!$file->isValid()) {
                    $error = 'Fichier invalide: ' . $file->getClientOriginalName() . ' - Erreur: ' . $file->getErrorMessage();
                    Log::error($error);
                    $errors[] = $error;
                    continue;
                }
                
                try {
                    $filename = $file->getClientOriginalName();
                    // Nettoyer le nom du fichier pour éviter les caractères spéciaux
                    $filename = preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', $filename);
                    
                    $storedPath = $file->storeAs($path, $filename, 'public');
                    
                    if ($storedPath) {
                        // Vérifier que le fichier existe réellement
                        $absolutePath = storage_path('app/public/' . $storedPath);
                        if (file_exists($absolutePath)) {
                            $uploadedFiles[] = [
                                'name' => $filename,
                                'path' => $storedPath,
                                'size' => filesize($absolutePath),
                                'mime' => $file->getMimeType()
                            ];
                            
                            Log::info('Fichier uploadé avec succès', [
                                'filename' => $filename,
                                'path' => $storedPath,
                                'size' => filesize($absolutePath)
                            ]);
                        } else {
                            $error = 'Le fichier a été uploadé mais est introuvable: ' . $filename;
                            Log::error($error, ['expected_path' => $absolutePath]);
                            $errors[] = $error;
                        }
                    } else {
                        $error = 'Échec de l\'upload: ' . $filename;
                        Log::error($error);
                        $errors[] = $error;
                    }
                } catch (\Exception $e) {
                    $error = 'Exception lors de l\'upload de ' . $file->getClientOriginalName() . ': ' . $e->getMessage();
                    Log::error($error, ['trace' => $e->getTraceAsString()]);
                    $errors[] = $error;
                }
            }
            
            // Réponse finale
            if (empty($uploadedFiles)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Aucun fichier n\'a pu être uploadé',
                    'errors' => $errors
                ], 500);
            }
            
            if (!empty($errors)) {
                return response()->json([
                    'success' => true,
                    'message' => 'Certains fichiers ont été uploadés avec des erreurs',
                    'folder' => $folder,
                    'uploaded' => $uploadedFiles,
                    'errors' => $errors
                ], 206); // 206 Partial Content
            }
            
            // Retour du dossier pour compatibilité avec le code existant
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Tous les fichiers ont été uploadés avec succès',
                    'folder' => $folder,
                    'uploaded' => $uploadedFiles
                ]);
            }
            
            return $folder;
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Erreur de validation lors de l\'upload', [
                'errors' => $e->errors()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Fichiers invalides',
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'upload des documents', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de l\'upload: ' . $e->getMessage()
            ], 500);
        }
    }
}
