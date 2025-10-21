<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class File
{
    public $slug;
    public $options;

    /**
     * @return string
     */
    public function handle($fileRequested, $field, $table_slug, $options = null)
    {
        try {
            $this->slug = $table_slug;
            $this->options = $options;
            $files = [];

            // Vérifier si le fichier est valide
            if ($fileRequested instanceof Request) {
                if (!$fileRequested->hasFile($field)) {
                    Log::error('Aucun fichier trouvé dans la requête pour le champ: ' . $field);
                    return null;
                } else {
                    $files = Arr::wrap($fileRequested->file($field));
                }
            } elseif ($fileRequested instanceof UploadedFile) {
                if (!$fileRequested->isValid()) {
                    Log::error('Fichier invalide: ' . $fileRequested->getError());
                    return null;
                }
                $files = Arr::wrap($fileRequested);
            } else {
                Log::error('Type de fichier non pris en charge: ' . gettype($fileRequested));
                return null;
            }

            $filesPath = [];
            $path = $this->generatePath();
            
            // Créer le répertoire s'il n'existe pas (avec permissions 0755 pour Hostinger)
            $fullPath = storage_path('app/public/' . $path);
            if (!file_exists($fullPath)) {
                try {
                    // Utiliser 0755 au lieu de 0777 pour la sécurité et compatibilité Hostinger
                    if (!mkdir($fullPath, 0755, true)) {
                        Log::error('Impossible de créer le répertoire: ' . $fullPath, [
                            'permissions' => '0755',
                            'parent_exists' => file_exists(dirname($fullPath)),
                            'parent_writable' => is_writable(dirname($fullPath))
                        ]);
                        return null;
                    }
                    Log::info('Répertoire créé avec succès: ' . $fullPath);
                } catch (\Exception $e) {
                    Log::error('Exception lors de la création du répertoire', [
                        'path' => $fullPath,
                        'error' => $e->getMessage()
                    ]);
                    return null;
                }
            }
            
            // Vérifier que le dossier est accessible en écriture
            if (!is_writable($fullPath)) {
                Log::error('Le répertoire n\'est pas accessible en écriture', [
                    'path' => $fullPath,
                    'permissions' => substr(sprintf('%o', fileperms($fullPath)), -4),
                    'owner' => function_exists('posix_getpwuid') ? posix_getpwuid(fileperms($fullPath))['name'] ?? 'unknown' : 'N/A'
                ]);
                return null;
            }

            foreach ($files as $file) {
                if (!$file->isValid()) {
                    Log::error('Erreur de téléversement: ' . $file->getErrorMessage());
                    continue;
                }

                $filename = $this->generateFileName($file, $path);
                $fullFilename = $filename . '.' . $file->getClientOriginalExtension();
                $filePath = $path . $fullFilename;
                
                // Vérifier si le fichier existe déjà
                if (Storage::disk('public')->exists($filePath)) {
                    Log::warning('Le fichier existe déjà: ' . $filePath);
                    $filename = $filename . '_' . time();
                    $fullFilename = $filename . '.' . $file->getClientOriginalExtension();
                    $filePath = $path . $fullFilename;
                }
                
                // Téléverser le fichier
                try {
                    $storedPath = $file->storeAs(
                        $path,
                        $fullFilename,
                        'public'
                    );

                    if (!$storedPath) {
                        Log::error('Échec du stockage du fichier', [
                            'filename' => $file->getClientOriginalName(),
                            'size' => $file->getSize(),
                            'mime' => $file->getMimeType(),
                            'error' => $file->getError(),
                            'temp_path' => $file->getRealPath()
                        ]);
                        continue;
                    }
                    
                    // Vérifier que le fichier a bien été créé
                    $absolutePath = storage_path('app/public/' . $storedPath);
                    if (!file_exists($absolutePath)) {
                        Log::error('Le fichier a été stocké mais n\'existe pas sur le disque', [
                            'stored_path' => $storedPath,
                            'absolute_path' => $absolutePath
                        ]);
                        continue;
                    }
                    
                    Log::info('Fichier stocké et vérifié', [
                        'path' => $storedPath,
                        'size' => filesize($absolutePath)
                    ]);
                    
                } catch (\Exception $e) {
                    Log::error('Exception lors du stockage du fichier', [
                        'filename' => $file->getClientOriginalName(),
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                    continue;
                }

                // Nettoyer le chemin avant de le stocker
                $cleanFilePath = str_replace('\\', '/', $filePath);
                $cleanFilePath = ltrim($cleanFilePath, '/'); // Supprimer les slashes en début de chaîne
                
                array_push($filesPath, [
                    'download_link' => $cleanFilePath,
                    'original_name' => $file->getClientOriginalName(),
                ]);
                
                Log::info('Fichier stocké avec succès', [
                    'chemin' => $cleanFilePath,
                    'nom_original' => $file->getClientOriginalName()
                ]);
            }

            if (empty($filesPath)) {
                Log::error('Aucun fichier n\'a pu être téléversé');
                return null;
            }

            return json_encode($filesPath);
            
        } catch (\Exception $e) {
            Log::error('Erreur lors du traitement du fichier: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    /**
     * @return string
     */
    protected function generatePath()
    {
        // Utiliser '/' au lieu de DIRECTORY_SEPARATOR pour compatibilité multi-plateforme
        // Laravel normalise automatiquement les chemins
        return $this->slug . '/' . date('FY') . '/';
    }

    /**
     * @return string
     */
    protected function generateFileName($file, $path)
    {
        if (isset($this->options->preserveFileUploadName) && $this->options->preserveFileUploadName) {
            $filename = basename($file->getClientOriginalName(), '.'.$file->getClientOriginalExtension());
            $filename_counter = 1;

            // Make sure the filename does not exist, if it does make sure to add a number to the end 1, 2, 3, etc...
            while (Storage::disk('public')->exists($path.$filename.'.'.$file->getClientOriginalExtension())) {
                $filename = basename($file->getClientOriginalName(), '.'.$file->getClientOriginalExtension()).(string) ($filename_counter++);
            }
        } else {
            $filename = Str::random(20); 

            // Make sure the filename does not exist, if it does, just regenerate
            while (Storage::disk('public')->exists($path.$filename.'.'.$file->getClientOriginalExtension())) {
                $filename = Str::random(20);
            }
        }

        return $filename;
    }
}
