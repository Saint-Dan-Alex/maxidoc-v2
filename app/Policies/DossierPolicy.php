<?php

namespace App\Policies;

use App\Models\Dossier;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class DossierPolicy
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
        return true; //$user->agent->fonction()->departement?->id == 5;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Dossier  $dossier
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Dossier $dossier)
    {
        $countDoc = $dossier->documents()->whereHas('followers', function ($query) use ($user)
        {
            $query->where('agent_id', $user->agent->id);
        })->orWhere('documents.created_by', $user->id)->count();
        return Auth::user()->hasRole('Admin') || ($user->can('Voir les documents') && $countDoc > 0) || ($user->agent->direction->is($dossier->author->direction) &&  $user->agent->isResponsable());
        // return $user->agent->fonction()->departement?->id == 5 || $user->agent->is($dossier->author) || $countDoc > 0;
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
     * @param  \App\Models\Dossier  $dossier
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Dossier $dossier)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Dossier  $dossier
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Dossier $dossier)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Dossier  $dossier
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Dossier $dossier)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Dossier  $dossier
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Dossier $dossier)
    {
        //
    }
}
