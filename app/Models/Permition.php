<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permition extends Model
{
    use HasFactory;

    /**
     * The postes that belong to the Permition
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function postes()
    {
        return $this->belongsToMany(Poste::class);
    }
}
