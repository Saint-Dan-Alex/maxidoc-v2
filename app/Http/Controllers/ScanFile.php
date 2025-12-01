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
    public function handle($table_slug, $options = null, $specificFileName = null)
    {
        try {
            $this->slug = $table_slug;
            $this->options = $options;

            $filesPath = [];
            $path = $this->generatePath();
            
            // Utiliser le disque public explicitement pour correspondre à l'upload
            $disk = Storage::disk('public');
            $scanDir = 'tmp_scanne';
            
            if (!$disk->exists($scanDir)) {
                \Log::warning("Le dossier de scan temporaire n'existe pas sur le disque public ($scanDir).");
                // On ne lance pas d'exception tout de suite, on laisse files() retourner vide si c'est le cas
            }
            
            $file = null;

            if ($specificFileName) {
                $specificFileName = basename($specificFileName);
                
                \Log::info('DEBUG SCAN: Recherche spécifique (disk public)', [
                    'search' => $specificFileName,
                    'dir' => $scanDir
                ]);
                
                // Essayer de trouver le fichier avec ou sans extension .pdf
                if ($disk->exists($scanDir . '/' . $specificFileName)) {
                    $file = $scanDir . '/' . $specificFileName;
                    \Log::info('DEBUG SCAN: Trouvé (exact match)', ['file' => $file]);
                } elseif ($disk->exists($scanDir . '/' . $specificFileName . '.pdf')) {
                    $file = $scanDir . '/' . $specificFileName . '.pdf';
                    \Log::info('DEBUG SCAN: Trouvé (avec .pdf)', ['file' => $file]);
                }
                
                if (!$file) {
                    // Fallback: chercher un fichier qui commence par ce nom
                    $files = $disk->files($scanDir);
                    
                    \Log::info('DEBUG SCAN: Fallback search', [
                        'files_in_dir' => $files
                    ]);

                    foreach ($files as $f) {
                        if (strpos(basename($f), $specificFileName) === 0) {
                            $file = $f;
                            \Log::info('DEBUG SCAN: Trouvé via fallback', ['file' => $file]);
                            break;
                        }
                    }
                }
                
                if (!$file) {
                    throw new \Exception("Le fichier scanné spécifique '{$specificFileName}' est introuvable dans le dossier temporaire (disk public).");
                }
            } else {
                // Comportement par défaut
                $scannedFiles = $disk->files($scanDir);
                if (empty($scannedFiles)) {
                    throw new \Exception("Aucun fichier scanné trouvé dans le dossier temporaire");
                }
                
                $file = $scannedFiles[0];
            }
            
            $filename = $this->generateFileName($file, $path);
            $extension = Str::afterLast($file, '.');
            
            // Chemin relatif au disque public (sans 'public/' au début)
            $destinationPath = $path . $filename . '.' . $extension;

            // Créer le répertoire de destination
            $disk->makeDirectory(dirname($destinationPath));
            
            // Déplacer le fichier
            if (!$disk->move($file, $destinationPath)) {
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