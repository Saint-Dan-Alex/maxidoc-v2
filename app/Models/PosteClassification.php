<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosteClassification extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function postes() {
        return $this->hasMany(Poste::class);
    }

    public function statut() {
        return $this->belongsTo(Statut::class);
    }
}
