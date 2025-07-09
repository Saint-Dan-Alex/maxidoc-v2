<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Section extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['division_id', 'service_id', 'responsable_id', 'titre', 'description', 'statut_id'];

    public function agents()
    {
        return $this->hasMany(Agent::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    /**
     * Get the responsable that owns the Section
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function responsable(): BelongsTo
    {
        return $this->belongsTo(Agent::class, 'responsable_id');
    }
}