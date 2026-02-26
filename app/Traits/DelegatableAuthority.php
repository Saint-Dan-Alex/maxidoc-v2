<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait DelegatableAuthority
{
    /**
     * Boot the trait to apply events.
     * 
     * NOTE: Le Query Merging est désormais géré par DelegationHelper::filterByUserInteraction()
     * dans chaque composant, pour éviter les conflits avec les filtres métier existants.
     */
    public static function bootDelegatableAuthority()
    {
        // Audit Trail Automatique : marquer les créations sous délégation
        static::creating(function ($model) {
            if (session('delegation_mode')) {
                // Cette information sera récupérée par le système de log Historique
                // via le middleware CheckActiveDelegation
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
