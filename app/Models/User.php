<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Yadahan\AuthenticationLog\AuthenticationLogable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Traits\HasPermissions;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use AuthenticationLogable;
    use HasRoles;
    use HasPermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'statut_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * The permissions that belong to the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    // public function permissions()
    // {
    //     return $this->belongsToMany(Permission::class, PermissionUser::class);
    // }

    /**
     * Get the agent associated with the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function agent()
    {
        return $this->hasOne(Agent::class, 'user_id');
    }

    public function taches()
    {
        return $this->belongsToMany(Tache::class, 'pivot_user_taches', 'tache_id', 'user_id');
    }

    public function categories()
    {
        return $this->hasMany(Categorie::class);
    }

    public function commentaires()
    {
        return $this->hasMany(Commentaire::class);
    }

    public function departements()
    {
        return $this->hasMany(Departement::class);
    }

    public function departementresponsable()
    {
        return $this->hasMany(Departement::class, 'responsable_id');
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function divisionresponsable()
    {
        return $this->hasMany(Division::class, 'responsable_id');
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function etats()
    {
        return $this->hasMany(Etat::class);
    }

    public function fournisseurs()
    {
        return $this->hasMany(Fournisseur::class);
    }

    public function fichiers()
    {
        return $this->hasMany(Fichier::class);
    }

    public function fichepaies()
    {
        return $this->hasMany(FichePaie::class);
    }

    public function brouillons()
    {
        return $this->hasMany(Brouillon::class);
    }

    public function pivotusertache()
    {
        return $this->hasMany(PivotUserTache::class, 'agent_id');
    }

    public function pivotusertaches()
    {
        return $this->hasMany(PivotUserTache::class);
    }

    public function poste()
    {
        return $this->belongsTo(Poste::class);
    }

    public function produits()
    {
        return $this->hasMany(Produit::class);
    }

    public function sites()
    {
        return $this->hasMany(Site::class);
    }

    public function statut()
    {
        return $this->belongsTo(Statut::class);
    }

    public function types()
    {
        return $this->hasMany(Type::class);
    }

    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

    // public function users()
    // {
    //     return $this->hasMany(User::class);
    // }

    public function ville()
    {
        return $this->belongsTo(Ville::class);
    }

    public function notification()
    {
        return $this->hasMany(Notification::class, 'user_receve');
    }

    public function message()
    {
        return $this->hasMany(Chat::class, 'user_receve');
    }
    //fin roger

    // debut jean-louis
    public function actualPoste()
    {
        return $this->belongsToMany(Poste::class)->wherePivotNull('date_fin')->wherePivot('statu_id', 1)->withPivot('departement_id')->withTimestamps();
    }

    public function isInDG()
    {
        $dgKeys = Departement::where('direction_id', 1)->get('id')->toArray();
        $dgKeys = Arr::flatten($dgKeys);
        return $this->actualPoste->first() ? in_array($this->actualPoste->first()->pivot->departement_id, $dgKeys) : false;
    }

    public function isInAdminFin()
    {
        $dgKeys = Departement::where('direction_id', 2)->get('id')->toArray();
        $dgKeys = Arr::flatten($dgKeys);
        return $this->actualPoste->first() ? in_array($this->actualPoste->first()->pivot->departement_id, $dgKeys) : false;
    }

    /**
     * Get all of the user's subscriptions.
     */
    public function subscriptions()
    {
        return $this->morphMany(Subscription::class, 'subscribable');
    }

    public function getAccessToken()
    {
        // $accessTokenId = $this->tokens()->first()->id;
        // $accessToken = $this->findForToken($accessTokenId);
        $accessToken = $this->token();

        return $accessToken;
    }

}
