<?php

namespace App\Models;

use App\Models\Document;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Tache extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $casts = [
        'date_debut' => 'datetime',
        'date_fin' => 'datetime',
    ];

    public function commentaires()
    {
        return $this->hasMany(Commentaire::class);
    }

    public function getTacheStatutIdAttribute($value)
    {
        if ($this->date_fin && $this->date_fin <= now() && $this->pourcentage < 100) {
            $this->tache_statut_id = 4;
            $this->save();
            return 4;
        } else {
            return $value;
        }
    }
    // public function updatePourcentage()
    // {
    //     $totalTacheObjectifs = $this->objectifs()->count();
    //     $termineTacheObjectifs = $this->objectifs()->where('statut', 0)->count();

    //     if ($totalTacheObjectifs > 0) {
    //         $pourcentage = ($termineTacheObjectifs / $totalTacheObjectifs) * 100;
    //     } else {
    //         $pourcentage = 0;
    //     }

    //     $this->pourcentage = $pourcentage;
    //     $this->save();
    // }

    public function updateTacheStatutId()
    {
        if ($this->pourcentage == 100) {
            $this->tache_statut_id = 3;
            $this->save();
        }
    }

    public function objectifs()
    {
        return $this->hasMany(TacheObjectif::class);
    }

    public function isForDirection() {
        return $this->agents()->first()->pivot->type == Direction::class;
    }

    public static function getTachesForCurrentUser()
    {
        
        return Auth::user()->agent->taches->unique('id');
    }


    public function etat()
    {
        return $this->belongsTo(Etat::class);
    }

    public function tache_statut()
    {
        return $this->belongsTo(TachesStatut::class,'tache_statut_id');
    }

    public function fichiers()
    {
        return $this->hasMany(Fichier::class);
    }

    public function pivotusertaches()
    {
        return $this->hasMany(PivotUserTache::class);
    }

    /**
     * The executants that belong to the Tache
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function executants()
    {
        return $this->belongsToMany(Agent::class, PivotUserTache::class, 'agent_id', 'tache_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function statut()
    {
        return $this->belongsTo(TachesStatut::class, 'tache_statut_id');
    }

    /**
     * Scope a query to only include initiale
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInitiale($query)
    {
        return $query->where('statut_id', 1);
    }

    /**
     * Scope a query to only include encours
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEncours($query)
    {
        return $query->where('statut_id', 2);
    }

    /**
     * Get the priorite that owns the Tache
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function priorite()
    {
        return $this->belongsTo(Priorite::class, 'priorite_id');
    }

    public function subTasks()
    {
        return Tache::where('parent_id', $this->id)->get();
    }

    /**
     * Get the priorite that owns the Tache
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tacheParent()
    {
        return $this->belongsTo(Tache::class, 'parent_id');
    }

    /**
     * Get the document that owns the Tache
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function documents()
    {
        return $this->belongsToMany(Document::class, TacheDocument::class, 'tache_id', 'document_id');
    }

    /**
     * The agents that belong to the Tache
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function agents(): BelongsToMany
    {
        return $this->belongsToMany(Agent::class, PivotTachesAgent::class)->withPivot(['type','type_id'])->withTimestamps();
    }

    /**
     * Get the courrier that owns the Tache
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function courrier(): BelongsTo
    {
        return $this->belongsTo(Courrier::class, 'courrier_id');
    }
}
