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
        // Vérifier si c'est un document par défaut
        if ($document->is_default) {
            return $user->can('Voir les documents');
        }

        $isDGOrActingAsDG = $user->hasRole('Directeur Générale') || session('delegation_mode');

        // Vérifier si l'utilisateur a le rôle 'Admin' ou 'DG' (ou délégué)
        if ($user->hasRole('Admin') || $isDGOrActingAsDG) {
            return true;
        }

        // Vérifier les permissions de l'utilisateur
        if (!$user->can('Voir les documents')) {
            return false;
        }

        // IDs d'agents autorisés (Moi + DG si délégation)
        $agentIds = [$user->agent->id];
        if (session('delegation_mode') && session('acting_as_dg_id')) {
            $dgUser = \App\Models\User::find(session('acting_as_dg_id'));
            if ($dgUser && $dgUser->agent) {
                $agentIds[] = $dgUser->agent->id;
            }
        }

        // Vérifier si l'utilisateur (ou son délégant) est l'auteur du document
        $isAuthor = in_array($document->created_by, $agentIds);

        // Vérifier si l'utilisateur (ou son délégant) est un suiveur du document
        $isFollower = $document->followers()
            ->whereIn('agent_id', $agentIds)
            ->exists();

        // Vérifier si l'utilisateur est dans la même direction que l'auteur et qu'il est responsable
        $isSameDirectionAndResponsable = $document->author && $user->agent
            ? $user->agent->direction_id === $document->author->direction_id
                && $user->agent->isResponsable()
            : false;

        // Vérifier si l'utilisateur est Assistant DG et si l'auteur est dans la même direction
        $isAssistantDG = $user->hasRole('Assistant DG') && $document->author && $user->agent
            ? $document->author->direction_id === $user->agent->direction_id
            : false;

        // Retourner la permission finale
        return $isAuthor || $isFollower || $isSameDirectionAndResponsable || $isAssistantDG;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->can('Créer un document');
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
        return $user->can('Modifier un document') || $document->created_by === $user->agent->id;
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
        $isDGOrActingAsDG = $user->hasRole('Directeur Générale') || session('delegation_mode');
        return $user->can('Supprimer un document') || $document->created_by === $user->agent->id || $isDGOrActingAsDG;
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
        $isDGOrActingAsDG = $user->hasRole('Directeur Générale') || session('delegation_mode');
        return $user->can('Restaurer un document') || $isDGOrActingAsDG;
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
        $isDGOrActingAsDG = $user->hasRole('Directeur Générale') || session('delegation_mode');
        return $user->can('Suppression définitive') || $isDGOrActingAsDG;
    }
}
