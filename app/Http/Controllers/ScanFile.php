<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class ScanFile
{
    public $slug;
    public $options;

    /**
     * @return string
     */
    public function handle($table_slug, $options = null)
    {
        try {
            $this->slug = $table_slug;
            $this->options = $options;

            $filesPath = [];
            $path = $this->generatePath();
            
            // Vérifier si le dossier de scan existe
            $scanDir = 'public/tmp_scanne';
            if (!Storage::exists($scanDir)) {
                throw new \Exception("Le dossier de scan temporaire n'existe pas");
            }
            
            // Vérifier s'il y a des fichiers scannés
            $scannedFiles = Storage::files($scanDir);
            if (empty($scannedFiles)) {
                throw new \Exception("Aucun fichier scanné trouvé dans le dossier temporaire");
            }
            
            // Prendre le premier fichier scanné
            $file = $scannedFiles[0];
            $filename = $this->generateFileName($file, $path);
            $extension = Str::afterLast($file, '.');
            $destinationPath = 'public/' . $path . $filename . '.' . $extension;

            // Créer le répertoire de destination s'il n'existe pas
            Storage::makeDirectory(dirname($destinationPath), 0755, true, true);
            
            // Déplacer le fichier
            if (!Storage::move($file, $destinationPath)) {
                throw new \Exception("Impossible de déplacer le fichier scanné");
            }

            array_push($filesPath, [
                'download_link' => $path . $filename . '.' . $extension,
                'original_name' => 'Scan ' . now()->format('dmYhms') . '.' . $extension,
            ]);

            return json_encode($filesPath);
            
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la numérisation du document', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw new \Exception('Erreur lors de la numérisation : ' . $e->getMessage());
        }
    }

    /**
     * @return string
     */
    protected function generatePath()
    {
        return $this->slug . DIRECTORY_SEPARATOR . date('FY') . DIRECTORY_SEPARATOR;
    }

    /**
     * @return string
     */
    protected function generateFileName($file, $path)
    {
        $filename = Str::random(20);

        // Make sure the filename does not exist, if it does, just regenerate
        while (Storage::disk('public')->exists($path . $filename . '.' . Str::afterLast($file, '.'))) {
            $filename = Str::random(20);
        }

        return $filename;
    }
}