<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Assistanat extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }

    public function direction()
    {
        return $this->belongsTo(Direction::class, 'direction_id');
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
