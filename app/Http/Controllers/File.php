<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
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
                    \Log::error('Aucun fichier trouvé dans la requête pour le champ: ' . $field);
                    return null;
                } else {
                    $files = Arr::wrap($fileRequested->file($field));
                }
            } elseif ($fileRequested instanceof UploadedFile) {
                if (!$fileRequested->isValid()) {
                    \Log::error('Fichier invalide: ' . $fileRequested->getError());
                    return null;
                }
                $files = Arr::wrap($fileRequested);
            } else {
                \Log::error('Type de fichier non pris en charge: ' . gettype($fileRequested));
                return null;
            }

            $filesPath = [];
            $path = $this->generatePath();
            
            // Créer le répertoire s'il n'existe pas
            $fullPath = storage_path('app/public/' . $path);
            if (!file_exists($fullPath)) {
                if (!mkdir($fullPath, 0777, true)) {
                    \Log::error('Impossible de créer le répertoire: ' . $fullPath);
                    return null;
                }
            }

            foreach ($files as $file) {
                if (!$file->isValid()) {
                    \Log::error('Erreur de téléversement: ' . $file->getErrorMessage());
                    continue;
                }

                $filename = $this->generateFileName($file, $path);
                $fullFilename = $filename . '.' . $file->getClientOriginalExtension();
                $filePath = $path . $fullFilename;
                
                // Vérifier si le fichier existe déjà
                if (Storage::disk('public')->exists($filePath)) {
                    \Log::warning('Le fichier existe déjà: ' . $filePath);
                    $filename = $filename . '_' . time();
                    $fullFilename = $filename . '.' . $file->getClientOriginalExtension();
                    $filePath = $path . $fullFilename;
                }
                
                // Téléverser le fichier
                $storedPath = $file->storeAs(
                    $path,
                    $fullFilename,
                    'public'
                );

                if (!$storedPath) {
                    \Log::error('Échec du stockage du fichier: ' . $file->getClientOriginalName());
                    continue;
                }

                array_push($filesPath, [
                    'download_link' => str_replace('\\', '/', $filePath),
                    'original_name' => $file->getClientOriginalName(),
                ]);
            }

            if (empty($filesPath)) {
                \Log::error('Aucun fichier n\'a pu être téléversé');
                return null;
            }

            return json_encode($filesPath);
            
        } catch (\Exception $e) {
            \Log::error('Erreur lors du traitement du fichier: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            return null;
        }
    }

    /**
     * @return string
     */
    protected function generatePath()
    {
        return $this->slug.DIRECTORY_SEPARATOR.date('FY').DIRECTORY_SEPARATOR;
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
