<?php

namespace App\Policies;

use App\Models\Direction;
use App\Models\Division;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class DivisionPolicy
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
        return $user->role_id == 3 || $user->role_id == 1;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Division  $division
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Division $division)
    {
        // $isDGOrAdmin = Gate::allows('viewAny', $division);
        return true;//$isDGOrAdmin || $user->agent->fonction()->service->division->id == $division->id;
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
     * @param  \App\Models\Division  $division
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Division $division)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Division  $division
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Division $division)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Division  $division
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Division $division)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Division  $division
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Division $division)
    {
        //
    }
}
