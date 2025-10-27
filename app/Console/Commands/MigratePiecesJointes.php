<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PieceJointe;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class MigratePiecesJointes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pieces-jointes:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrer les pièces jointes du dossier documents vers pieces-jointes';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Début de la migration des pièces jointes...');
        
        $piecesJointes = PieceJointe::all();
        $migratedCount = 0;
        $errorCount = 0;
        
        foreach ($piecesJointes as $pieceJointe) {
            try {
                // Décoder le JSON
                $decoded = json_decode($pieceJointe->chemin);
                
                if (json_last_error() !== JSON_ERROR_NONE || !is_array($decoded) || !isset($decoded[0]->download_link)) {
                    $this->warn("Pièce jointe #{$pieceJointe->id} : Format invalide, ignorée");
                    continue;
                }
                
                $oldPath = $decoded[0]->download_link;
                $originalName = $decoded[0]->original_name;
                
                // Vérifier si le fichier est déjà dans pieces-jointes
                if (strpos($oldPath, 'pieces-jointes/') === 0) {
                    $this->info("Pièce jointe #{$pieceJointe->id} : Déjà dans le bon dossier");
                    continue;
                }
                
                // Vérifier si le fichier existe
                if (!Storage::disk('public')->exists($oldPath)) {
                    $this->error("Pièce jointe #{$pieceJointe->id} : Fichier introuvable à {$oldPath}");
                    $errorCount++;
                    continue;
                }
                
                // Créer le nouveau chemin
                $year = $pieceJointe->created_at->format('Y');
                $month = $pieceJointe->created_at->format('m');
                $courrierId = $pieceJointe->courrier_id;
                $fileName = basename($oldPath);
                
                $newPath = "pieces-jointes/{$year}/{$month}/courrier-{$courrierId}/{$fileName}";
                
                // Créer le dossier si nécessaire
                $directory = dirname($newPath);
                if (!Storage::disk('public')->exists($directory)) {
                    Storage::disk('public')->makeDirectory($directory, 0755, true);
                }
                
                // Copier le fichier
                if (Storage::disk('public')->copy($oldPath, $newPath)) {
                    // Mettre à jour la base de données
                    $newJson = json_encode([
                        [
                            'download_link' => $newPath,
                            'original_name' => $originalName
                        ]
                    ]);
                    
                    $pieceJointe->update(['chemin' => $newJson]);
                    
                    $this->info("Pièce jointe #{$pieceJointe->id} : Migrée avec succès");
                    $this->line("  De : {$oldPath}");
                    $this->line("  Vers : {$newPath}");
                    
                    $migratedCount++;
                    
                    // Optionnel : Supprimer l'ancien fichier
                    // Storage::disk('public')->delete($oldPath);
                } else {
                    $this->error("Pièce jointe #{$pieceJointe->id} : Erreur lors de la copie");
                    $errorCount++;
                }
                
            } catch (\Exception $e) {
                $this->error("Pièce jointe #{$pieceJointe->id} : Erreur - " . $e->getMessage());
                Log::error("Erreur migration pièce jointe #{$pieceJointe->id}", [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                $errorCount++;
            }
        }
        
        $this->info("\n=== Résumé de la migration ===");
        $this->info("Total de pièces jointes : " . $piecesJointes->count());
        $this->info("Migrées avec succès : {$migratedCount}");
        $this->info("Erreurs : {$errorCount}");
        
        return Command::SUCCESS;
    }
}
