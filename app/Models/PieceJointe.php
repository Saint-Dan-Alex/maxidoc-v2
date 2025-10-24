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
     * Get the file URL for public access.
     */
    public function getUrlAttribute(): string
    {
        // En production sur Hostinger, utiliser l'URL complète depuis FILESYSTEM_URL
        if (config('app.env') === 'production' && env('FILESYSTEM_URL')) {
            return env('FILESYSTEM_URL') . '/' . $this->chemin;
        }
        
        // En local, utiliser asset()
        return asset('storage/' . $this->chemin);
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
