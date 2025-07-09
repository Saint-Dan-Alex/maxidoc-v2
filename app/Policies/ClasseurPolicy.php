<?php

namespace App\Policies;

use App\Models\Classeur;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClasseurPolicy
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
        // return $user->agent->fonction()->departement->id == 5;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Classeur  $classeur
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Classeur $classeur)
    {
        // $countDoc = $classeur->documents()->whereHas('followers', function ($query) use ($user)
        // {
        //     $query->where('agent_id', $user->agent->id);
        // })->orWhere('documents.created_by', $user->id)->count();

        // return $user->can('Voir les documents') && $countDoc > 0 && $classeur->documents->count() > 0;
        return true;
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
     * @param  \App\Models\Classeur  $classeur
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Classeur $classeur)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Classeur  $classeur
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Classeur $classeur)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Classeur  $classeur
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Classeur $classeur)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Classeur  $classeur
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Classeur $classeur)
    {
        //
    }
}
