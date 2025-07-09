<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function direction()
    {
        return $this->belongsTo(Direction::class);
    }

    public function responsable()
    {
        return $this->belongsTo(Agent::class, 'responsable_id');
    }

    public function statut()
    {
        return $this->belongsTo(Statut::class);
    }

    public function agents()
    {
        return $this->hasMany(Agent::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function fonctions()
    {
        return $this->hasMany(Fonction::class);
    }
}
