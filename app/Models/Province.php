<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function villes() {
        return $this->hasMany(Ville::class);
    }

    public function statut() {
        return $this->belongsTo(Statut::class);
    }
}
