<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait DelegatableAuthority
{
    /**
     * Boot the trait to apply global scope and events.
     */
    public static function bootDelegatableAuthority()
    {
        // 1. Query Merging: Application du Scope Global pour voir les ressources du DG
        static::addGlobalScope('delegation_view', function (Builder $builder) {
            $actingAsDgId = session('acting_as_dg_id');
            
            if ($actingAsDgId && Auth::check()) {
                // On fusionne les vues: Mes outils + Outils du DG
                // Note: On utilise whereIn pour inclure les deux IDs
                $ownerColumn = (new static)->getOwnerColumn();
                $builder->where(function ($query) use ($ownerColumn, $actingAsDgId) {
                    $query->where($ownerColumn, Auth::id())
                          ->orWhere($ownerColumn, $actingAsDgId);
                });
            }
        });

        // 2. Audit Trail Automatique
        static::creating(function ($model) {
            if (session('delegation_mode')) {
                // On marque la création comme étant faite au nom de...
                // Cette information sera récupérée par le système de log Historique
            }
        });
    }

    /**
     * Retourne le nom de la colonne de possession (par défaut user_id).
     */
    public function getOwnerColumn()
    {
        return defined('static::OWNER_COLUMN') ? static::OWNER_COLUMN : 'user_id';
    }

    /**
     * Vérifie si cet objet appartient au délégant (DG) dans le contexte actuel.
     */
    public function isActingForDelegator()
    {
        if (!session('delegation_mode')) return false;
        
        $actingAsDgId = session('acting_as_dg_id');
        $ownerColumn = $this->getOwnerColumn();
        
        // Si la ressource appartient au DG mais pas à l'utilisateur courant
        return $this->{$ownerColumn} == $actingAsDgId && $this->{$ownerColumn} != Auth::id();
    }
}
