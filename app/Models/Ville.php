<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ville extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function province() {
        return $this->belongsTo(Province::class);
    }

    public function statut() {
        return $this->belongsTo(Statut::class);
    }

    public function users() {
        return $this->hasMany(User::class);
    }
}
