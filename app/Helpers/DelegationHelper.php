<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class DelegationHelper
{
    /**
     * Retourne l'ID de l'agent courant et, si une délégation est active,
     * l'ID de l'agent du DG (délégant).
     * 
     * @return array [currentAgentId, dgAgentId|null]
     */
    public static function getAgentIds(): array
    {
        $agent = Auth::user()->agent;
        $currentAgentId = $agent ? $agent->id : null;
        $dgAgentId = null;

        if (session('delegation_mode') && session('acting_as_dg_id')) {
            $dgUser = \App\Models\User::find(session('acting_as_dg_id'));
            if ($dgUser && $dgUser->agent) {
                $dgAgentId = $dgUser->agent->id;
            }
        }

        return [$currentAgentId, $dgAgentId];
    }

    /**
     * Retourne l'ID utilisateur courant et l'ID du DG délégant.
     * 
     * @return array [currentUserId, dgUserId|null]
     */
    public static function getUserIds(): array
    {
        $currentUserId = Auth::id();
        $dgUserId = session('delegation_mode') ? (int) session('acting_as_dg_id') : null;

        return [$currentUserId, $dgUserId];
    }

    /**
     * Applique le filtre d'interaction utilisateur sur une requête Courrier.
     * Si une délégation est active, inclut aussi les courriers du DG.
     * 
     * @param Builder $query
     * @return Builder
     */
    public static function filterByUserInteraction(Builder $query): Builder
    {
        [$agentId, $dgAgentId] = self::getAgentIds();

        return $query->where(function ($q) use ($agentId, $dgAgentId) {
            // Mes courriers
            $q->where('created_by', $agentId)
              ->orWhereHas('destinateurs', function ($sq) use ($agentId) {
                  $sq->where('agent_id', $agentId);
              })
              ->orWhereHas('followers', function ($sq) use ($agentId) {
                  $sq->where('agent_id', $agentId);
              })
              ->orWhereHas('partages', function ($sq) use ($agentId) {
                  $sq->where('agent_id', $agentId);
              });

            // + Les courriers du DG si délégation active
            if ($dgAgentId) {
                $q->orWhere('created_by', $dgAgentId)
                  ->orWhereHas('destinateurs', function ($sq) use ($dgAgentId) {
                      $sq->where('agent_id', $dgAgentId);
                  })
                  ->orWhereHas('followers', function ($sq) use ($dgAgentId) {
                      $sq->where('agent_id', $dgAgentId);
                  })
                  ->orWhereHas('partages', function ($sq) use ($dgAgentId) {
                      $sq->where('agent_id', $dgAgentId);
                  });
            }
        });
    }

    /**
     * Applique le filtre d'interaction utilisateur via un callback (pour TopCards).
     * 
     * @return \Closure
     */
    public static function getFilterCallback(): \Closure
    {
        return function (Builder $query) {
            self::filterByUserInteraction($query);
        };
    }
}
