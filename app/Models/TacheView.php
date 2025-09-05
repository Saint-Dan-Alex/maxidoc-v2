<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TacheView extends Model
{
    protected $table = 'tache_views';
    
    protected $fillable = [
        'tache_id',
        'user_id',
        'agent_id',
        'is_first_view',
        'viewed_at'
    ];
    
    protected $attributes = [
        'viewed_at' => null,
        'is_first_view' => true
    ];

    protected $casts = [
        'viewed_at' => 'datetime',
        'is_first_view' => 'boolean'
    ];

    public function tache()
    {
        return $this->belongsTo(Tache::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }
}
