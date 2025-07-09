<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use \Venturecraft\Revisionable\RevisionableTrait;

class Document extends Model
{
    use HasFactory;
    use SoftDeletes;
    // use Searchable;
    use RevisionableTrait;

    protected $revisionEnabled = true;
    protected $revisionCleanup = true; //Remove old revisions (works only when used with $historyLimit)
    protected $historyLimit = 500; //Maintain a maximum of 500 changes at any point of time, while cleaning up old revisions.
    protected $revisionCreationsEnabled = true;
    // protected $keepRevisionOf = ['title'];
    // protected $revisionFormattedFields = [
    //     'title'      => 'string:<strong>%s</strong>',
    //     'public'     => 'boolean:No|Yes',
    //     'modified'   => 'datetime:m/d/Y g:i A',
    //     'deleted_at' => 'isEmpty:Active|Deleted'
    // ];
    // protected $revisionFormattedFieldNames = [
    //     'title'      => 'Title',
    //     'small_name' => 'Nickname',
    //     'deleted_at' => 'Deleted At'
    // ];
    protected $revisionNullString = 'vide';
    protected $revisionUnknownString = 'inconnu';


    protected $guarded = [];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = ['dossier_id', 'category_id', 'reference', 'libelle', 'type', 'document', 'user_id', 'statut_id', 'created_by'];

    public function history()
    {
        return $this->morphMany(Historique::class, 'historiquecable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function statut()
    {
        return $this->belongsTo(DocumentStatut::class, 'statut_id');
    }

    /**
     * Scope a query to only include no archive
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNoArchive($query)
    {
        return $query->where('statut_id', '!=', 6);
    }

    /**
     * Scope a query to only include archive
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeArchive($query)
    {
        return $query->where('statut_id', '=', 6);
    }

    /**
     * The agent that belong to the Courrier
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followers()
    {
        return $this->belongsToMany(Agent::class, DocumentFollower::class);
    }

    /**
     * Get the courrier associated with the Document
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function courrier()
    {
        return $this->hasOne(Courrier::class, 'document_id');
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
     * Get the categorie that owns the Document
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categorie()
    {
        return $this->belongsTo(CourrierCategory::class, 'category_id');
    }

    /**
     * Get the dossier that owns the Document
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dossier()
    {
        return $this->belongsTo(Dossier::class, 'dossier_id');
    }

    /**
     * Get the typeDocument that owns the Document
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function typeDocument()
    {
        return $this->belongsTo(DocumentType::class, 'type');
    }

    public function taches()
    {
        return $this->belongsToMany(Tache::class, 'tache_documents', 'document_id', 'tache_id');
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        // $array = $this->toArray();
        return [
            'id' => $this->id,
            'libelle' => $this->libelle,
        ];

        // Customize array...

        // return $array;
    }
}
