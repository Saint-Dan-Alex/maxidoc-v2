<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Historique extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::created(function ($historique) {
            // Si l'historique est lié à une tâche, on le propage au courrier lié s'il existe
            if ($historique->historiquecable_type === 'App\Models\Tache' || $historique->historiquecable_type === Tache::class) {
                $tache = $historique->historiquecable;
                if (!$tache) return;

                // Recherche du courrier lié (directement ou via le parent)
                $courrierId = $tache->courrier_id;
                $currentTache = $tache;
                
                // On remonte la hiérarchie pour trouver un courrier lié
                while (!$courrierId && $currentTache->parent_id) {
                    $currentTache = $currentTache->tacheParent;
                    if (!$currentTache) break;
                    $courrierId = $currentTache->courrier_id;
                }

                if ($courrierId) {
                    self::withoutEvents(function () use ($historique, $tache, $courrierId) {
                        Historique::create([
                            'key' => "Suivi Tâche: " . $historique->key,
                            'historiquecable_id' => $courrierId,
                            'historiquecable_type' => 'App\Models\Courrier',
                            'description' => "[Tâche: {$tache->titre}] " . $historique->description,
                            'user_id' => $historique->user_id,
                        ]);
                    });
                }
            }
        });
    }

    protected $fillable = [
        "key",
        "historiquecable_id",
        "historiquecable_type",
        "description",
        "user_id"
    ];

    /**
     * Get the parent commentable model (post or video).
     */
    public function historiquecable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the user that owns the Historique
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Alias de la relation user pour la rétrocompatibilité
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userResponsible()
    {
        return $this->user();
    }
}
