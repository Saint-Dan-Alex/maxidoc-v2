<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function statut() {
        return $this->belongsTo(Statut::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function vendeurs() {
        return $this->hasMany(Vendeur::class);
    }
}
