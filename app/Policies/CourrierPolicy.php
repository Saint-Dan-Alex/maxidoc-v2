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

        // Vérifier si l'utilisateur est l'auteur ou s'il a une relation de destinataire, suiveur ou partage avec le courrier
        $cacheKey = "courrier_access_{$user->id}_{$courrier->id}";
        $hasAccess = cache()->remember($cacheKey, 60, function () use ($courrier, $agentId) {
            return $courrier->where(function ($query) use ($agentId) {
                $query->where('created_by', $agentId) // L'utilisateur est l'auteur
                    ->orWhereHas('destinateurs', function ($query) use ($agentId) {
                        $query->where('agent_id', $agentId);
                    })
                    ->orWhereHas('followers', function ($query) use ($agentId) {
                        $query->where('agent_id', $agentId);
                    })
                    ->orWhereHas('partages', function ($query) use ($agentId) {
                        $query->where('agent_id', $agentId);
                    })->take(15);
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
        //
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
        //
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
        //
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
        //
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
        //
    }
}
