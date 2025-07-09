<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Venturecraft\Revisionable\RevisionableTrait;

class CourriersPartage extends Model implements Viewable
{
    use HasFactory;
    use InteractsWithViews;
    use RevisionableTrait;

    protected $revisionEnabled = true;
    protected $revisionCleanup = true; //Remove old revisions (works only when used with $historyLimit)
    protected $historyLimit = 500; //Maintain a maximum of 500 changes at any point of time, while cleaning up old revisions.
    protected $revisionCreationsEnabled = true;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['courrier_id','agent_id','traitement_id','date_debut','date_fin','priorite_id','send_by','note'];

    /**
     * Get the courrier that owns the CourriersPartage
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function courrier(): BelongsTo
    {
        return $this->belongsTo(Courrier::class, 'courrier_id', 'id');
    }

    /**
     * Get the agent that owns the CourriersPartage
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function agent(): BelongsTo
    {
        return $this->belongsTo(Agent::class, 'agent_id', 'id');
    }

}
