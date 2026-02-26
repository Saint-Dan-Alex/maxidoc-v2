<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\DeleguePermission;
use App\Models\Delegation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    public function index()
    {
        $agents = Agent::where('id', '!=', Auth::user()->agent->id)->get();
        
        // Récupérer les historiques avec pagination
        $historiques = \App\Models\Historique::where('user_id', Auth::id())
            ->orderBy('id', 'desc')
            ->paginate(10);

        // Récupérer la délégation active (BLAST System)
        $activeDelegation = Delegation::where('delegator_id', Auth::id())
            ->where('is_active', true)
            ->where('end_date', '>', now())
            ->with('delegate.agent')
            ->first();

        return view('regidoc.pages.profil', compact('agents', 'historiques', 'activeDelegation'));
    }

    public function updateAvatar(Request $request)
    {
        $agent = Agent::find($request->agent_id);
        $agent->image = (new Image())->handle($request, 'image', 'agents');
        $agent->save();

        $content = json_encode([
            'name' => 'Ressources humaines',
            'statut' => 'success',
            'message' => 'La modification de l\'image a réussi avec succès !',
        ]);

        session()->flash(
            'session',
            $content
        );

        return redirect()->back();
    }

    public function delegueSave(Request $request)
    {
        // ✅ LOG FORCÉ EN ERROR — LOG_LEVEL=error sur le serveur, info() est ignoré
        \Log::error('[DELEGUE] ========== CONTROLLER ATTEINT ==========');
        \Log::error('[DELEGUE] Données POST reçues: ', $request->except('_token'));
        \Log::error('[DELEGUE] autre_agent = ' . var_export($request->autre_agent, true));
        \Log::error('[DELEGUE] to_dga = ' . var_export($request->to_dga, true));
        \Log::error('[DELEGUE] permissions = ' . var_export($request->permissions, true));

        try {
            // Récupérer l'ID de l'agent délégué (to_dga a priorité, sinon autre_agent)
            $agentId = $request->to_dga ?: ($request->autre_agent ?: null);
            \Log::error('[DELEGUE] Step 1 - agentId recu: ' . var_export($agentId, true));

            $agent = $agentId ? Agent::find($agentId) : null;
            \Log::error('[DELEGUE] Step 2 - Agent trouve: ' . ($agent ? 'OUI (id='.$agent->id.')' : 'NON'));
            \Log::error('[DELEGUE] Step 2b - Permissions reçues du formulaire: ' . var_export($request->permissions, true));
            \Log::error('[DELEGUE] Step 2c - Agent a-t-il un compte User ?: ' . ($agent && $agent->user ? 'OUI (user_id='.$agent->user->id.')' : 'NON'));

            if (!$agent) {
                $content = json_encode([
                    'name'    => 'Ressources humaines',
                    'statut'  => 'error',
                    'message' => 'Veuillez sélectionner un agent délégué.',
                ]);
            } else {
                $dg = Auth::user()->agent;
                \Log::error('[DELEGUE] Step 3 - DG agent: ' . ($dg ? 'OUI (id='.$dg->id.')' : 'NON - Auth::user()->agent est NULL'));

                if (!$dg) {
                    throw new \Exception('Auth::user()->agent est null — le DG n\'a pas d\'agent lié.');
                }

                $dg->delegue_id = $agent->id;
                $saved = $dg->save();
                \Log::error('[DELEGUE] Step 4 - dg->save(): ' . ($saved ? 'OK' : 'ECHEC'));

                $permissionsCreated = 0;
                $permissionsSollicitees = $request->permissions ?? [];
                \Log::error('[DELEGUE] Nombre de permissions à traiter: ' . count($permissionsSollicitees));

                foreach ($permissionsSollicitees as $permission) {
                    if (!$agent->user) {
                        \Log::error('[DELEGUE] Step 5 - L\'agent ID '.$agent->id.' n\'a pas d\'USER lié');
                        break;
                    }

                    // On vérifie si CETTE délégation précise est déjà enregistrée dans la table de trace
                    $alreadyDelegated = DeleguePermission::where('agent_id', $agent->id)
                        ->where('permission_id', $permission)
                        ->exists();
                    
                    if (!$alreadyDelegated) {
                        \Log::error('[DELEGUE] Enregistrement de la trace de délégation pour permission ID: ' . $permission);
                        DeleguePermission::create([
                            'agent_id'      => $agent->id,
                            'permission_id' => $permission,
                        ]);

                        // On lui donne le droit réel s'il ne l'a pas encore via Spatie
                        if (!$agent->user->hasPermissionTo((int)$permission)) {
                            $agent->user->givePermissionTo($permission);
                            \Log::error('[DELEGUE] Droit accordé via Spatie pour ID: ' . $permission);
                        }

                        $permissionsCreated++;
                    }
                }
                \Log::error('[DELEGUE] Step 6 - Total permissions créées: ' . $permissionsCreated);

                // --- NOUVELLE LOGIQUE BLAST: Enregistrement dans la table delegations ---
                // Pour le moment, on délègue pour une durée indéterminée (ou 1 an par défaut)
                Delegation::updateOrCreate(
                    [
                        'delegator_id' => Auth::id(),
                        'delegate_id'  => $agent->user->id,
                    ],
                    [
                        'start_date' => now(),
                        'end_date'   => now()->addYear(),
                        'is_active'  => true,
                        'metadata'   => ['source' => 'profil_delegue_save']
                    ]
                );
                \Log::error('[DELEGUE] Step 7 - Record Delegation créé/mis à jour');
                // -----------------------------------------------------------------------

                $content = json_encode([
                    'name'    => 'Ressources humaines',
                    'statut'  => 'success',
                    'message' => 'La délégation a été enregistrée avec succès !',
                ]);
            }
        } catch (\Throwable $th) {
            \Log::error('[DELEGUE] EXCEPTION: ' . $th->getMessage(), [
                'file'  => $th->getFile(),
                'line'  => $th->getLine(),
                'trace' => $th->getTraceAsString(),
            ]);
            $content = json_encode([
                'name'    => 'Ressources humaines',
                'statut'  => 'error',
                'message' => 'Une erreur inattendue s\'est produite. Veuillez réessayer.',
            ]);
        }

        session()->flash(
            'session',
            $content
        );

        return redirect()->back();

    }

    public function delegueRemove()
    {
        $dg = Auth::user()->agent;
        $agent = Agent::find($dg->delegue_id);
        $dg->delegue_id = null;
        $dg->save();

        $permissions = DeleguePermission::where('agent_id', $agent->id)->get();

        foreach ($permissions ?? [] as $permission) {
            $agent->user->revokePermissionTo($permission);
            $permission->delete();
        }

        $content = json_encode([
            'name' => 'Ressources humaines',
            'statut' => 'success',
            'message' => 'L\'opération a réussi !',
        ]);

        session()->flash(
            'session',
            $content
        );

        return redirect()->back();

    }

    /**
     * Kill Switch: Révocation immédiate d'une délégation
     */
    public function revokeDelegation(Delegation $delegation)
    {
        // Sécurité: Seul le délégant peut révoquer sa propre délégation
        if ($delegation->delegator_id !== Auth::id()) {
            abort(403);
        }

        $delegation->update(['is_active' => false]);

        $content = json_encode([
            'name' => 'Sécurité',
            'statut' => 'success',
            'message' => 'Délégation révoquée avec succès !',
        ]);

        session()->flash('session', $content);
        return redirect()->back();
    }
}
