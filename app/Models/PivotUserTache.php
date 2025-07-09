<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PivotUserTache extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function employe() {
        return $this->belongsTo(Agent::class, 'agent_id');
    }

    public function tache() {
        return $this->belongsTo(Tache::class);
    }

    public function statut() {
        return $this->belongsTo(Statut::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
