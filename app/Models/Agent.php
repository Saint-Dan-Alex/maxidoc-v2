<?php

namespace App\Models;

use App\Models\Direction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;
use NotificationChannels\WebPush\HasPushSubscriptions;

class Agent extends Model
{
    use HasFactory;
    use Notifiable;
    use HasPushSubscriptions;

    protected $guarded = [];
    /**
     * Get the adresse associated with the Agent
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function adresse()
    {
        return $this->hasOne(Adresse::class, 'agent_id');
    }

    public function isDG()
    {
        $direction = Direction::where('titre', 'Direction générale')->orWhere('id', 1)->first();
        return $this->id === $direction->responsable?->id;
    }

    public function isDelegue()
    {
        $direction = Direction::where('titre', 'Direction générale')->orWhere('id', 1)->first();
        return $this->id === $direction->responsable->delegue_id;
    }

    public function isDGA()
    {
        $direction = Direction::where('titre', 'Direction générale')
            ->orWhere('id', 1)->first();
        return $this->id === $direction->adjoint?->id;
    }

    public function isSecretaire()
    {
        return in_array($this->id, $this->direction?->secretaires->pluck('responsable_id')->toArray() ?? []);
    }

    public function isAssistant()
    {
        return in_array($this->id, $this->direction?->assistanats->pluck('responsable_id')->toArray() ?? []);
    }

    public function isResponsable()
    {
        return $this->id === $this->direction?->responsable->id;
    }

    public function brouillons()
    {
        return $this->belongsToMany(Brouillon::class, 'agent_brouillons', 'agent_id', 'brouillon_id');
    }

    // public function taches()
    // {
    //     $tachesIds = $this->objectifs()
    //         ->distinct('tache_id')
    //         ->pluck('tache_id')
    //         ->toArray();

    //     return Tache::whereIn('id', $tachesIds)->get();
    // }

    /**
     * The taches that belong to the Agent
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function taches(): BelongsToMany
    {
        return $this->belongsToMany(Tache::class, PivotTachesAgent::class)->withPivot(['type','type_id'])->withTimestamps();
    }

    /**
     * The fonctions that belong to the Agent
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function fonctions()
    {
        return $this->belongsToMany(Fonction::class, PivotAgentFonction::class)->withPivot([
            'statut_id',
            'date_debut',
            'created_by',
            'updated_by'
        ])->withTimestamps();
    }

    /**
     * The fonctions that belong to the Agent
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function fonction()
    {
        return $this->fonctions()->wherePivot('statut_id', '=', 1)->first();
    }

    /**
     * Get the user that owns the Agent
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pointages()
    {
        return $this->hasMany(Pointage::class);
    }

    public function planning()
    {
        return $this->belongsTo(Planning::class);
    }

    public function direction()
    {
        return $this->belongsTo(Direction::class);
    }

    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class, 'grade_id');
    }

    public function poste()
    {
        return $this->belongsTo(Fonction::class, 'fonction_id');
    }

    public function lieu()
    {
        return $this->belongsTo(LieuAffectation::class, 'lieu_id');
    }

    public function objectifs()
    {
        return $this->hasMany(TacheObjectif::class);
    }
    /**
     * Get all of the permissions for the Agent
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function permissions()
    {
        return $this->hasMany(ArchivePermission::class, 'agent_id');
    }

    /**
     * Get the contrat associated with the Agent
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function contrat()
    {
        return $this->hasOne(Contrat::class, 'agent_id');
    }

    /**
     * The courrier that belong to the agent
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function courriers()
    {
        return $this->belongsToMany(Courrier::class, CourrierFollower::class);
    }

    /**
     * Scope a query to only include actifs
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActif($query)
    {
        $user_id = auth()->id();
        return $query->where('statut_id', 1)
            ->orderByRaw("id = $user_id DESC");
    }

    /**
     * Scope a query to only include actifs
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInactif($query)
    {
        return $query->where('statut_id', 2);
    }

    /**
     * Scope a query to only include actifs
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeArchived($query)
    {
        return $query->where('statut_id', 3);
    }

    /**
     * The documents that belong to the Agent
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function documents()
    {
        return $this->belongsToMany(Document::class, PivotDocumentsAgents::class, 'agent_id', 'document_id');
    }

    /**
     * Get all of the created_documents for the Agent
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function created_documents()
    {
        return Document::where('created_by', $this->user->id)->get();
    }
}
