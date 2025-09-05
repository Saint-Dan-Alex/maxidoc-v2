<?php

namespace App\Http\Controllers\RH;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Secretariat;
use App\Models\Fonction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SecretariatController extends Controller
{
    public function index()
    {
        return view('regidoc.pages.systems.secretariat');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'direction_id' => 'required|exists:directions,id',
            'responsable_id' => 'required|exists:agents,id',
            'for' => 'nullable|in:1,2'
        ]);

        try {
            Secretariat::create([
                'titre' => $request->titre,
                'direction_id' => $request->direction_id,
                'responsable_id' => $request->responsable_id,
                'for_dg' => $request->for == 1 ? 1 : 0,
                'for_dga' => $request->for == 2 ? 1 : 0,
            ]);

            // Création de la fonction uniquement si elle n'existe pas
            Fonction::firstOrCreate(
                ['titre' => $request->titre],
                ['direction_id' => $request->direction_id]
            );

            // ⚠️ On ne touche plus à l'agent ici

            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'success',
                'message' => 'Secrétariat ajouté avec succès',
            ]);
        } catch (\Throwable $th) {
            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'L\'ajout du Secrétariat a échoué !',
            ]);
        }

        session()->flash('session', $content);
        return back();
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'direction_id' => 'required|exists:directions,id',
            'responsable_id' => 'required|exists:agents,id',
            'for' => 'nullable|in:1,2'
        ]);

        try {
            $secretariat = Secretariat::findOrFail($id);

            // On ne modifie pas le fonction_id de l'ancien agent
            // Ni celui du nouveau

            $secretariat->update([
                'titre' => $request->titre,
                'direction_id' => $request->direction_id,
                'responsable_id' => $request->responsable_id,
                'for_dg' => $request->for == 1 ? 1 : 0,
                'for_dga' => $request->for == 2 ? 1 : 0,
            ]);

            // Création de la fonction si elle n'existe pas
            Fonction::firstOrCreate(
                ['titre' => $request->titre],
                ['direction_id' => $request->direction_id]
            );

            // ⚠️ On ne modifie pas le fonction_id de l'agent ici

            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'success',
                'message' => 'Secrétariat modifié avec succès',
            ]);
        } catch (\Throwable $th) {
            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'La modification du Secrétariat a échoué !',
            ]);
        }

        Session::put('session', $content);
        return back();
    }

    public function destroy($id)
    {
        try {
            $secretariat = Secretariat::findOrFail($id);
            $secretariat->delete();

            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'success',
                'message' => 'Secrétariat supprimé avec succès',
            ]);
        } catch (\Throwable $th) {
            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'La suppression du Secrétariat a échoué !',
            ]);
        }

        session()->flash('session', $content);
        return back();
    }
}
