<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourrierExpediteur extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'nom'];

    /**
     * Get the category that owns the expediteur.
     */
    public function category()
    {
        return $this->belongsTo(CourrierCategory::class, 'category_id');
    }
}
