<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function inventaires() {
        return $this->hasMany(Inventaire::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function ventes() {
        return $this->hasMany(Vente::class);
    }

    public function statut() {
        return $this->belongsTo(Statut::class);
    }
}
