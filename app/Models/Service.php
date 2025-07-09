<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Get the direction that owns the Service
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function direction()
    {
        return $this->belongsTo(Direction::class, 'direction_id');
    }

    /**
     * Get the division that owns the Service
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id');
    }

    public function responsable()
    {
        return $this->belongsTo(Agent::class, 'responsable_id');
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    public function agents()
    {
        return $this->hasMany(Agent::class);
    }
}
