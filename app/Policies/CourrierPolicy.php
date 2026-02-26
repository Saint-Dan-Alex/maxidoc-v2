<?php

namespace App\Policies;

use App\Models\Courrier;
use App\Models\User;
use App\Models\Agent;
use Illuminate\Auth\Access\HandlesAuthorization;

class CourrierPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        // return $user->agent->isDG();
    }

    // /**
    //  * Determine whether the user can view the model.
    //  *
    //  * @param  \App\Models\User  $user
    //  * @param  \App\Models\Courrier  $courrier
    //  * @return \Illuminate\Auth\Access\Response|bool
    //  */
    // public function view(User $user, Courrier $courrier)
    // {
    //     $isDestinateur = $courrier->destinateurs->where('id', $user->agent->id)->count();
    //     $isFollower = $courrier->followers->where('id', $user->agent->id)->count();
    //     $isShare = $courrier->partages->where('agent_id', $user->agent->id)->count(); 


    //     return $user->can('Voir les courriers') && ($isDestinateur || $courrier->author?->is($user->agent) || $isFollower || $isShare);
    // }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Courrier  $courrier
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Courrier $courrier)
    {
        $agentId = $user->agent->id;
        $agentIds = [$agentId];

        // Mode délégation : on ajoute l'ID de l'agent du DG pour la vérification
        if (session('delegation_mode') && session('acting_as_dg_id')) {
            $dgUser = \App\Models\User::find(session('acting_as_dg_id'));
            if ($dgUser && $dgUser->agent) {
                $agentIds[] = $dgUser->agent->id;
                
                // Si le document appartient au DG, accès autorisé (si permission de voir)
                if ($courrier->created_by == $dgUser->agent->id) {
                    return $user->can('Voir les courriers');
                }
            }
        }

        // Vérifier si l'un des agents (Moi ou DG) est l'auteur ou a une relation
        $cacheKey = "courrier_access_multi_" . implode('_', $agentIds) . "_{$courrier->id}";
        $hasAccess = cache()->remember($cacheKey, 60, function () use ($courrier, $agentIds) {
            return Courrier::withTrashed()->where('id', $courrier->id)->where(function ($query) use ($agentIds) {
                $query->whereIn('created_by', $agentIds)
                    ->orWhereHas('destinateurs', function ($query) use ($agentIds) {
                        $query->whereIn('agent_id', $agentIds);
                    })
                    ->orWhereHas('followers', function ($query) use ($agentIds) {
                        $query->whereIn('agent_id', $agentIds);
                    })
                    ->orWhereHas('partages', function ($query) use ($agentIds) {
                        $query->whereIn('agent_id', $agentIds);
                    });
            })->exists();
        });

        // Vérifier la permission et les conditions d'accès
        return $user->can('Voir les courriers') && $hasAccess;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->can('Créer un courrier');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Courrier  $courrier
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Courrier $courrier)
    {
        return $user->can('Modifier un courrier') || $courrier->created_by === $user->agent->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Courrier  $courrier
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Courrier $courrier)
    {
        $isDGOrActingAsDG = $user->agent->isDG() || session('delegation_mode');

        // L'auteur, un DG ou un Assistant peut supprimer (mettre à la corbeille)
        return $user->can('Supprimer un courrier') || 
               $courrier->created_by === $user->agent->id || 
               $isDGOrActingAsDG || 
               $user->agent->isAssistant() ||
               $user->agent->isSecretaire();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Courrier  $courrier
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Courrier $courrier)
    {
        $isDGOrActingAsDG = $user->agent->isDG() || session('delegation_mode');

        // Seul le DG, un admin ou un Assistant peut restaurer
        return $isDGOrActingAsDG || 
               $user->agent->isAssistant() || 
               $user->agent->isSecretaire() || 
               $user->can('Restaurer un courrier');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Courrier  $courrier
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Courrier $courrier)
    {
        $isDGOrActingAsDG = $user->agent->isDG() || session('delegation_mode');

        // Seul le DG, un admin ou un Assistant peut supprimer définitivement
        return $isDGOrActingAsDG || 
               $user->agent->isAssistant() || 
               $user->agent->isSecretaire() || 
               $user->can('Suppression définitive');
    }
}
