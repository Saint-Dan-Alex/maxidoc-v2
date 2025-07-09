<?php

namespace App\Http\Controllers\RH;

use App\Models\User;
use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AboutController extends Controller
{
    public function index()
    {
        $about = About::where('statut_id', '1')->first();
        $users = User::where('statut_id', '1')->orderBy('role_id', 'asc')->get();

        return view('pages.rh.about.index', compact('about', 'users'));
    }

    public function update(Request $request)
    {
        $aboutold = About::where('statut_id', '1')->first();

        if ($aboutold->directeur_id != $request->directeur_id) {
            User::where('id', $request->directeur_id)->update([
                'role_id' => '1',
            ]);

            User::where('id', $aboutold->directeur_id)->update([
                'role_id' => '6',
            ]);
        }

        $about = About::where('id', $request->about_id)->update([
            'libelle' => $request->libelle,
            'adresse' => $request->adresse,
            'telephone' => $request->telephone,
            'mobile' => $request->mobile,
            'fixe' => $request->fixe,
            'email' => $request->email,
            'idnat' => $request->idnat,
            'rccm' => $request->rccm,
            'impot' => $request->impot,
            'taux' => $request->taux,
            'slogan' => $request->slogan,
            'message' => $request->message,
            'directeur_id' => $request->directeur_id,
            'user_id' => Auth::user()->id,
            'statut_id' => 1,
        ]);

        if($about == 1){
            $content = json_encode([
                'name' => 'Ressources humaines',
                'statut' => 'success',
                'message' => 'La modification des informations de l\'a-propos a réussie avec succès !',
            ]);
        } else {
            $content = json_encode([
                'name' => 'Ressources humaines',
                'statut' => 'error',
                'message' => 'La modification des informations de l\'a-propos a échouée !',
            ]);
        }

        session()->flash(
            'session',
            $content
        );

        return back();
    }
}
