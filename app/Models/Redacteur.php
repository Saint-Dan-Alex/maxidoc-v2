<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Redacteur extends Model
{
    use HasFactory;

    protected $fillable = ['nom'];

    /**
     * Get all documents for the redacteur.
     */
    public function documents(): HasMany
    {
        return $this->hasMany(Document::class, 'redacteur_id');
    }
}
