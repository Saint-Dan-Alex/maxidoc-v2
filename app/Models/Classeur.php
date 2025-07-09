<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Models\Role;
use App\Models\Personel;
use App\Models\Departement;
use App\Models\Division;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classeur extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    /**
     * Get the personnel that owns the Classeur
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function personnel()
    {
        return $this->belongsTo(Personel::class, 'created');
    }

    /**
     * Get the role that owns the Classeur
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'niveau');
    }
    /**
     * Get the division that owns the Classeur
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function division()
    {
        return $this->belongsTo(Division::class, 'division');
    }

    public function departement()
    {
        return $this->belongsTo(Departement::class, 'departement_id');
    }

    /**
     * Get all of the dossiers for the Classeur
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dossiers()
    {
        return $this->hasMany(Dossier::class, 'classeur_id');
    }

    /**
     * Get the author that owns the Classeur
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(Agent::class, 'created_by');
    }

    /**
     * Get all of the documents for the Classeur
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function documents()
    {
        return $this->hasManyThrough(Document::class, Dossier::class);
    }
}