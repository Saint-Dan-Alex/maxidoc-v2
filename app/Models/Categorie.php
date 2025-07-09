<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function produits() {
        return $this->hasMany(Produit::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function statut() {
        return $this->belongsTo(Statut::class);
    }
}
