<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class LieuAffectation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function agents()
    {
        return $this->hasMany(Agent::class,'lieu_id');
    }

    /**
     * Get all of the agents for the LieuAffectation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    // public function agents(): HasManyThrough
    // {
    //     return $this->hasManyThrough(Agent::class, User::class);
    // }

    // public function directions()
    // {
    //     return Direction::where('lieu_id', $this->id)->get();
    // }

    /**
     * Get all of the comments for the LieuAffectation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function directions(): HasMany
    {
        return $this->hasMany(Direction::class, 'lieu_id');
    }

}
