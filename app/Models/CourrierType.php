<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourrierType extends Model
{
    use HasFactory;

    /**
     * Get all of the courriers for the CourrierType
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function courriers()
    {
        return $this->hasMany(Courrier::class, 'type_id');
    }
}
