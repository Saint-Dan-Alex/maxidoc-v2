<?php

namespace App\Models;

use App\Traits\WithDatatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Direction extends Model
{
    use HasFactory;
    use WithDatatable;

    protected $guarded = [];

    protected $fillable = ['titre', 'direction_id', 'description', 'code', 'lieu_id', 'responsable_id', 'adjoint_id'];
    // protected static function boot()
    // {

    //     parent::boot();

    //     static::creating(function ($direction) {
    //         $titre = $direction->titre;

    //         // Supprimez les espaces et convertissez en minuscules
    //         $titre = strtolower(str_replace(' ', '', $titre));

    //         // Définissez une liste d'articles à exclure
    //         $articles = ['du', 'de', 'le', 'la', "l'", 'et'];

    //         // Divisez le titre en mots
    //         $mots = explode(' ', $titre);

    //         // Initialisez le code avec les premières lettres en majuscules
    //         $code = '';

    //         foreach ($mots as $mot) {
    //             // Excluez les articles
    //             if (!in_array($mot, $articles)) {
    //                 $code .= strtoupper(substr($mot, 0, 1));
    //             }
    //         }

    //         // Si le code est vide, utilisez une valeur de secours
    //         if (empty($code)) {
    //             $code = strtoupper(substr($titre, 0, 1));
    //         }

    //         // Vérifiez si le code existe déjà
    //         $count = Direction::where('code', $code)->count();

    //         if ($count > 0) {
    //             // Si le code existe déjà, utilisez la deuxième lettre du deuxième mot comme valeur de secours
    //             if (isset($mots[1]) && strlen($mots[1]) >= 2) {
    //                 $code = strtoupper(substr($mots[1], 1, 1));
    //             }
    //         }

    //         $direction->code = $code;
    //     });
    // }

    public function departements()
    {
        return $this->hasMany(Departement::class);
    }

    public function divisions()
    {
        return $this->hasMany(Division::class);
    }

    public function lieu()
    {
        return $this->belongsTo(LieuAffectation::class, 'lieu_id');
    }

    public function responsable()
    {
        return $this->belongsTo(Agent::class, 'responsable_id');
    }

    public function adjoint()
    {
        return $this->belongsTo(Agent::class, 'adjoint_id');
    }

    public function dgSecretaires()
    {
        return $this->hasMany(Secretariat::class)->where('for_dg', 1);
    }

    public function dgaSecretaires()
    {
        return $this->hasMany(Secretariat::class)->where('for_dga', 1);
    }

    public function secretaires()
    {
        return $this->hasMany(Secretariat::class);
    }

    public function secretaire()
    {
        return $this->hasMany(Secretariat::class)->first()?->user() ?? $this->responsable->user();
    }

    /**
     * Get all of the assistants for the Direction
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function assistanats()
    {
        return $this->hasMany(Assistanat::class, 'direction_id');
    }

    public function dgAssistanats()
    {
        return $this->assistanats()->where('for_dg', 1);
    }

    public function dgaAssistanats()
    {
        return $this->assistanats()->where('for_dga', 1);
    }

    public function assistants()
    {
        return $this->assistanats->map(function ($assistant) {
            return $assistant->responsable;
        });
    }

    public function agents()
    {
        return $this->hasMany(Agent::class);
    }

    public function fonctions()
    {
        return $this->hasMany(Fonction::class);
    }

    /**
     * Get all of the services for the Direction
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function services(): HasMany
    {
        return $this->hasMany(Service::class, 'direction_id');
    }

    /**
     * Get all of the documents for the Direction
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function documents(): HasManyThrough
    {
        return $this->hasManyThrough(Document::class, Agent::class);
    }

    

}
