<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Historique extends Model
{
    use HasFactory;

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
     * Get the userResponsible that owns the Historique
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userResponsible()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
