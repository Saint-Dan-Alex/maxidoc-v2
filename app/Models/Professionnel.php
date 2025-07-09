<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professionnel extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function etablissement() {
        return $this->belongsTo(Etablissement::class);
    }
    
    public function commissions() {
        return $this->hasMany(Commission::class);
    }

    public function statut() {
        return $this->belongsTo(Statut::class);
    }
}
