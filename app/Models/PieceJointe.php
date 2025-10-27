<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PieceJointe extends Model
{
    protected $table = 'pieces_jointes';
    protected $fillable = [
        'nom',
        'chemin',
        'taille',
        'mime_type',
        'courrier_id',
        'document_id',
        'uploaded_by',
    ];

    protected $with = ['document'];

    /**
     * Get the document that owns the piece jointe.
     */
    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    protected $casts = [
        'taille' => 'integer',
        'uploaded_at' => 'datetime',
    ];

    /**
     * Get the courrier that owns the piece jointe.
     */
    public function courrier(): BelongsTo
    {
        return $this->belongsTo(Courrier::class);
    }

    /**
     * Get the user who uploaded the file.
     */
    public function uploadedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Get the actual file path from JSON format.
     */
    public function getCheminAttribute($value)
    {
        // Si c'est déjà un JSON, le retourner tel quel pour la compatibilité
        return $value;
    }

    /**
     * Get the download link from the JSON chemin.
     */
    public function getDownloadLinkAttribute(): ?string
    {
        $decoded = json_decode($this->attributes['chemin']);
        
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded) && isset($decoded[0]->download_link)) {
            return $decoded[0]->download_link;
        }
        
        // Si ce n'est pas du JSON, retourner le chemin brut (pour la compatibilité avec les anciennes pièces jointes)
        return $this->attributes['chemin'];
    }

    /**
     * Get the original file name from the JSON chemin.
     */
    public function getOriginalNameAttribute(): ?string
    {
        $decoded = json_decode($this->attributes['chemin']);
        
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded) && isset($decoded[0]->original_name)) {
            return $decoded[0]->original_name;
        }
        
        // Sinon, utiliser le nom stocké dans la colonne 'nom'
        return $this->nom;
    }

    /**
     * Get the file URL for public access.
     */
    public function getUrlAttribute(): string
    {
        $downloadLink = $this->download_link;
        
        if (!$downloadLink) {
            return '';
        }
        
        // Nettoyer le chemin
        $cleanPath = str_replace(['\\/', '\\\\', '\\'], '/', $downloadLink);
        $cleanPath = preg_replace('#^[/]+#', '', $cleanPath);
        
        // Ne pas enlever 'storage/' si le chemin ne commence pas par 'storage/'
        // (pour les pièces jointes qui sont dans pieces-jointes/)
        if (stripos($cleanPath, 'storage/') === 0) {
            $cleanPath = preg_replace('#^storage[/]#i', '', $cleanPath);
        }
        
        // Encoder chaque segment du chemin pour gérer les espaces et caractères spéciaux
        $pathSegments = explode('/', $cleanPath);
        $encodedSegments = array_map(function($segment) {
            return rawurlencode($segment);
        }, $pathSegments);
        $encodedPath = implode('/', $encodedSegments);
        
        // En production sur Hostinger, utiliser l'URL complète depuis FILESYSTEM_URL
        if (config('app.env') === 'production') {
            if (env('FILESYSTEM_URL')) {
                $baseUrl = env('FILESYSTEM_URL');
                // Si FILESYSTEM_URL ne se termine pas par /storage, l'ajouter
                if (!str_ends_with($baseUrl, '/storage')) {
                    $baseUrl .= '/storage';
                }
                return $baseUrl . '/' . $encodedPath;
            }
            // Fallback: construire l'URL manuellement
            return url('storage/' . $encodedPath);
        }
        
        // En local, utiliser asset()
        return asset('storage/' . $encodedPath);
    }

    /**
     * Get the file size in human readable format.
     */
    public function getFormattedSizeAttribute(): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = $this->taille;
        $i = 0;

        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }
}
