<?php

namespace App\Models;

use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Laravel\Scout\Searchable;
use Venturecraft\Revisionable\RevisionableTrait;
use Illuminate\Database\Eloquent\Builder;
use CyrildeWit\EloquentViewable\Support\Period;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use App\Models\Personel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Courrier extends Model implements Viewable
{
    use HasFactory;
    use Searchable;
    use InteractsWithViews;
    use RevisionableTrait;

    protected $revisionEnabled = true;
    protected $revisionCleanup = true; //Remove old revisions (works only when used with $historyLimit)
    protected $historyLimit = 500; //Maintain a maximum of 500 changes at any point of time, while cleaning up old revisions.
    protected $revisionCreationsEnabled = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'document_id', 'type_id', 'exped_externe', 'exped_interne_id',
        'dest_externe_id', 'dest_interne_id', 'departement_id',
        'service_id', 'service_traitant_id', 'is_intern', 'title',
        'confidentiel', 'reference_courrier', 'reference_interne',
        'priorite_id', 'date_du_courrier', 'date_arrive', 'date_fin',
        'nature_id', 'objet', 'copie', 'category_id', 'is_classified',
        'traitement_id', 'created_by', 'statut_id', 'mark_as_done'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */

    // use SoftDeletes; // Utilisation du trait SoftDeletes

    
    protected $dates = ['date_du_courrier', 'date_arrive', 'date_fin', 'created_at', 'updated_at',];

    public function history()
    {
        return $this->morphMany(Historique::class, 'historiquecable');
    }

    /**
     * Get all of the annotations for the Courrier
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function annotations()
    {
        return $this->hasMany(CourriersAnnotation::class, 'courrier_id');
    }

    public function dossier()
    {
        return $this->belongsTo(Dossier::class, 'dossier_id');
    }

    /**
     * Get the classeur that owns the Document
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function classeur()
    {
        return $this->belongsTo(Classeur::class, 'classeur_id');
    }

    public function personnel()
    {
        return $this->belongsTo(User::class, 'user_send_id');
    }
    /**
     * Get the user that owns the Document
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function answer()
    {
        return $this->belongsTo(User::class, 'user_enswer_id');
    }

    public function receve()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function send()
    {
        return $this->belongsTo(User::class, 'user_receve_id');
    }
    /**
     * Get the role associated with the Document
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function poste()
    {
        return $this->belongsTo(Role::class, 'role');
    }

    /**
     * Get the nature that owns the Courrier
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function nature()
    {
        return $this->belongsTo(CourrierNature::class, 'nature_id');
    }

    /**
     * Scope a query to only include not classified
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNotClassified($query)
    {
        return $query->where('is_classified', 0);
    }

    /**
     * Scope a query to only include classified
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeClassified($query)
    {
        return $query->where('is_classified', 1);
    }

    public function scopeScheduled($query) //Étendre la requête pour n'inclue que des courriers avec echeance
    {
        return $query->whereNotNull('date_fin');
    }

    public function scopeIsLate($query)
    {
        return $query->whereDate('date_fin', '<', now())->where('statut_id', '!=', 1);
    }

    public function isIntern()
    {
        return $this->is_intern === 1;
    }

    /**
     * The agent that belong to the Courrier
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followers()
    {
        return $this->belongsToMany(Agent::class, CourrierFollower::class);
    }

    /**
     * The destinateurs that belong to the Courrier
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function destinateurs()
    {
        return $this->belongsToMany(Agent::class, CourrierDestinateur::class, 'courrier_id', 'agent_id');
    }

    /**
     * The agent that belong to the Courrier
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function externDestinateur()
    {
        return $this->belongsTo(CourrierDestinateurExterne::class, 'dest_externe_id');
    }

    /**
     * The agent that belong to the Courrier
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function expediteur()
    {
        return $this->belongsTo(Agent::class, 'exped_interne_id');
    }

    /**
     * The agent that belong to the Courrier
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function externExpediteur()
    {
        return $this->belongsTo(CourrierExpediteur::class, 'exped_externe');
    }

    /**
     * Get the type that owns the Courrier
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(CourrierType::class, 'type_id');
    }

    /**
     * Get the departement that owns the Courrier
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function service()
    {
        return $this->belongsTo(Service::class, 'departement_id');
    }

    public function serviceExpediteur()
    {
        return $this->belongsTo(Service::class, 'departement_id');
    }

    /**
     * Get the departement that owns the Courrier
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fromService()
    {
        return $this->belongsTo(Direction::class, 'service_id');
    }

    /**
     * Get the departement that owns the Courrier
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function toDirection()
    {
        return $this->belongsTo(Direction::class, 'service_traitant_id');
    }

    /**
     * Get the priorite that owns the Courrier
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function priorite()
    {
        return $this->belongsTo(Priorite::class, 'priorite_id');
    }

    /**
     * Get the category that owns the Courrier
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categorie()
    {
        return $this->belongsTo(CourrierCategory::class, 'category_id');
    }

    /**
     * Get the document that owns the Courrier
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function document()
    {
        return $this->belongsTo(Document::class, 'document_id');
    }

    /**
     * The roles that belong to the Courrier
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function traitements()
    {
        return $this->belongsToMany(CourrierTraitement::class, CourriersTraitementsAgent::class, 'courrier_id', 'traitement_id');
    }

    /**
     * The roles that belong to the Courrier
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function traitement()
    {
        return $this->belongsTo(CourrierTypesTraitement::class, 'traitement_id');
    }

    /**
     * Get the author that owns the Courrier
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(Agent::class, 'created_by');
    }

    /**
     * Get all of the partages for the Courrier
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function partages()
    {
        return $this->hasMany(CourriersPartage::class, 'courrier_id');
    }

    /**
     * The etapes that belong to the Courrier
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function etapes()
    {
        return $this->belongsToMany(Etape::class, CourriersEtape::class, 'courrier_id', 'etape_id')->withPivot('view_by')->withTimestamps();
    }
 
    /**
     * Get all of the AccuseReception for the Courrier
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accuseReceptions(): HasMany
    {
        return $this->hasMany(AccuseReception::class, 'courrier_id')->orderBy('id','desc');
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    // public function toSearchableArray()
    // {
    //     $array = $this->toArray();
    //     return $array;
    // }

    public function toSearchableArray()
{
    return [
        'id' => $this->id,
        'objet' => $this->objet,
        'reference_interne' => $this->reference_interne,
        'title' => $this->title,
        'reference_courrier' => $this->reference_courrier,
        'date_arrive' => optional($this->date_arrive)->toDateString(),
        'libelle' => optional($this->document)->libelle, // ⚠️ si tu veux inclure un champ de relation, vérifie qu’il est bien string
    ];
}


    /**
     * Get the statut that owns the Courrier
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function statut()
    {
        return $this->belongsTo(Statut::class, 'statut_id');
    }

    /**
     * Scope a query to order records by views count.
     */
     public function scopeNotViewed(
         Builder $query,
         string $direction = 'desc',
         ?Period $period = null,
         ?string $collection = null,
         bool $unique = false,
         string $as = 'views'
     ): Builder {
         return $query->whereDoesntHave('views',function (Builder $query) use ($period, $collection, $unique)  {
             if ($period) {
                 $query->withinPeriod($period);
             }

             if ($collection) {
                 $query->collection($collection);
             }

             if ($unique) {
                 $query->select(DB::raw('count(DISTINCT dest_intern_id)'));
             }
            
             $query->where('user_id', '=', Auth::id());
            $query->where('dest_interne_id', '=', Auth::id());
           
         });
     }

    //  public function scopeNotViewed($query, string $direction = 'desc', ?Period $period = null, ?string $collection = null, bool $unique = false, string $as = 'views')
    //  {
    //      return $query->whereDoesntHave('views', function ($query) {
    //          $query->where('dest_interne_id', '=', Auth::id());
    //      });
    //  }

    public function isViewed()
    {
        // dd($this->views);
        $count = $this->views->map(function ($view) {
            if ($view->user_id == Auth::id()) {
                return $view;
            }
        })->reject(function ($view) {
            return $view == null;
        });
        return $count->count() > 0;
    }  

    // public function isntViewed()
    // {
    //     $unviewed = $this->views == null;
    //     return $unviewed;
    // }

    public function isNotViewed()
    {
        return $this->views->where('user_id', Auth::id())->count() == 0;
    }

    // Dans app/Models/Courrier.php
public function getStatusBadgeAttribute()
{
    $lastHistory = $this->history()
        ->whereIn('description', [
            'Le courrier a été marqué comme validé',
            'Le courrier a été marqué comme rejeté'
        ])
        ->latest()
        ->first();
    
    if (!$lastHistory) {
        return '';
    }
    
    if (str_contains($lastHistory->description, 'validé')) {
        return '<span class="badge bg-success ms-2">Validé</span>';
    }
    
    if (str_contains($lastHistory->description, 'rejeté')) {
        return '<span class="badge bg-danger ms-2">Rejeté</span>';
    }
    
    return '';
}
   
}
