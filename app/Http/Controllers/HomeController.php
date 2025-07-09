<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Tache;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yadahan\AuthenticationLog\AuthenticationLog;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {

        // $role = Role::find(1);
        // $permission = Permission::create(['name' => 'Voir les Fonctions', 'guard_name' => 'web', 'module_id' => 7]);
        // $role->givePermissionTo($permission);
        // User::find(1)->assignRole($role);

        $agents = Agent::select('id')->get();
        $taches = Tache::all(); //Tache::orderby('id', 'DESC')->where('user_id', Auth::user()->id)->orwhere('assigned_id', Auth::user()->id)->limit(5)->get();
        // $connected = AuthenticationLog::where('')
        return view('regidoc.pages.home.index')->with([
            'agents' => $agents,
            // 'newAgents' => $newAgents,
            // 'courriers' => $courriers,
            // 'departements' => $departements,
            // 'personnels' => $personels,
            // 'connected' => $conneted,
            // 'noconnected' => $noconnected,
            // 'files' => $files,
            'taches' => $taches,
            // 'projets' => $projets,
            // 'personnel' => $personel,
            // 'divisions' => $divisions,
            // 'documents' => $documents,
            // 'dossiers' => $dossiers,
            // 'classeurs' => $classeurs,
            // 'fonctions' => $fonctions,
        ]);
    }

    public function redirectUserToHomePage(){

        return redirect()->route('regidoc.home');
    }
}
