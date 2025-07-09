<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\DeleguePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    public function index()
    {
        $agents = Agent::where('id', '!=', Auth::user()->agent->id)->get();

        return view('regidoc.pages.profil', compact('agents'));
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
        try {
            $agent = Agent::find($request->to_dga ?? $request->autre_agent);
            // dd(!$agent);
            if(!$agent){
                $content = json_encode([
                    'name' => 'Ressources humaines',
                    'statut' => 'error',
                    'message' => 'L\'opération a échoué !',
                ]);
            }else{
                $dg = Auth::user()->agent;
                $dg->delegue_id = $agent->id;
                $dg->save();

                foreach ($request->permissions ?? [] as $permission) {
                    if (!in_array($permission, $agent->user->permissions->pluck('id')->toArray())) {
                        DeleguePermission::create([
                            'agent_id' => $agent->id,
                            'permission_id' => $permission,
                        ]);
                        $agent->user->givePermissionTo($permission);
                    }
                }

                $content = json_encode([
                    'name' => 'Ressources humaines',
                    'statut' => 'success',
                    'message' => 'L\'opération a réussi !',
                ]);
            }
        } catch (\Throwable $th) {
            // dd($th);
            $content = json_encode([
                'name' => 'Ressources humaines',
                'statut' => 'error',
                'message' => 'L\'opération a échoué !',
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
}
