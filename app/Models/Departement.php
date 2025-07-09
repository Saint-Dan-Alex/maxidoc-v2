<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departement extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function agent()
    {
        return $this->hasMany(Agent::class);
    }
    public function direction()
    {
        return $this->belongsTo(Direction::class);
    }

    public function fonctions()
    {
        return $this->hasMany(Fonction::class);
    }

    public function divisions()
    {
        return $this->hasMany(Division::class);
    }

    public function responsable()
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function statut()
    {
        return $this->belongsTo(Statut::class);
    }
}
