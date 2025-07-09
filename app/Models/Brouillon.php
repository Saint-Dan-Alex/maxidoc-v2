<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brouillon extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function commentaires()
    {
        return $this->hasMany(BrouillonCommentaire::class);
    }
    public function agents()
    {
        return $this->belongsToMany(Agent::class, 'agent_brouillons', 'brouillon_id', 'agent_id');
    }
}