<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poste extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function postecategorie() {
        return $this->belongsTo(PosteCategorie::class, 'poste_categorie_id');
    }

    public function posteclassification() {
        return $this->belongsTo(PosteClassification::class, 'poste_classification_id');
    }

    public function statut() {
        return $this->belongsTo(Statut::class);
    }

    public function users() {
        return $this->hasMany(User::class);
    }
}
