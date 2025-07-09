<?php

namespace App\Policies;

use App\Models\Document;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class DocumentPolicy
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
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Auth\Access\Response|bool
     */
    // public function view(User $user, Document $document)
    // {
    //     // $isDestinateur = $courrier->destinateurs->where('id', $user->agent->id)->count();
    //     $isFollower = $document->followers->where('id', $user->agent->id)->count();

    //     return Auth::user()->hasRole('Admin') || ($user->can('Voir les documents') && ($document->author->is($user->agent) || $isFollower)) || ($user->agent->direction->is($document->author->direction) && $user->agent->isResponsable());
    //     // return true;
    // }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Document $document)
    {
        // Vérifier si l'utilisateur a le rôle 'Admin'
        if ($user->hasRole('Admin')) {
            return true;
        }

        // Vérifier les permissions de l'utilisateur
        if (!$user->can('Voir les documents')) {
            return false;
        }

        // Vérifier si l'utilisateur est l'auteur du document
        $isAuthor = $document->created_by === $user->agent->id;

        // Vérifier si l'utilisateur est un suiveur du document
        $isFollower = $document->followers()
            ->where('agent_id', $user->agent->id)
            ->exists();

        // Vérifier si l'utilisateur est dans la même direction que l'auteur et qu'il est responsable
        $isSameDirectionAndResponsable = $user->agent->direction_id === $document->author->direction_id
            && $user->agent->isResponsable();

        // Retourner la permission finale
        return $isAuthor || $isFollower || $isSameDirectionAndResponsable;
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
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Document $document)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Document $document)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Document $document)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Document $document)
    {
        //
    }
}
