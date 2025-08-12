<?php

namespace App\Http\Controllers\RH;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Direction;
use App\Models\Assistanat;
use App\Models\Fonction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssistanatController extends Controller
{
    public function index()
    {
        return view('regidoc.pages.systems.assistanat');
    }

    public function store(Request $request)
    {
        try {
            // Création de l’assistanat
            Assistanat::create([
                "titre" => $request->titre,
                "direction_id" => $request->direction_id,
                "responsable_id" => $request->responsable_id,
                "for_dg" => $request->for == 1 ? 1 : 0,
                "for_dga" => $request->for == 2 ? 1 : 0,
            ]);

            // Création ou récupération de la fonction
            $fonction = Fonction::firstOrCreate([
                'titre' => $request->titre,
            ], [
                "direction_id" => $request->direction_id,
            ]);

            // Attribution de la fonction au responsable (sans modifier sa direction)
            $agent = Agent::findOrFail($request->responsable_id);
            $agent->update([
                'fonction_id' => $fonction->id,
            ]);

            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'success',
                'message' => "assistant ajouté avec succès",
            ]);
        } catch (\Throwable $th) {
            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'L\'ajout de la assistant a échoué !',
            ]);
        }

        session()->flash('session', $content);
        return back();
    }

    public function update(Request $request, $id)
    {
        try {
            $assistant = Assistanat::findOrFail($id);

            // On vide la fonction de l’ancien responsable
            $ancienAgent = Agent::findOrFail($assistant->responsable_id);
            $ancienAgent->update([
                'fonction_id' => null
            ]);

            // Mise à jour des données de l’assistanat
            $assistant->update([
                "titre" => $request->titre,
                "direction_id" => $request->direction_id,
                "responsable_id" => $request->responsable_id,
                "for_dg" => $request->for == 1 ? 1 : 0,
                "for_dga" => $request->for == 2 ? 1 : 0,
            ]);

            // Création ou récupération de la fonction
            $fonction = Fonction::firstOrCreate([
                'titre' => $request->titre,
            ], [
                "direction_id" => $request->direction_id,
            ]);

            // Attribution de la fonction au nouveau responsable (sans modifier sa direction)
            $agent = Agent::findOrFail($request->responsable_id);
            $agent->update([
                'fonction_id' => $fonction->id,
            ]);

            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'success',
                'message' => "assistant modifié avec succès",
            ]);
        } catch (\Throwable $th) {
            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'La modification de la assistant a échoué !',
            ]);
        }

        session()->flash('session', $content);
        return back();
    }

    public function destroy($id)
    {
        try {
            $assistant = Assistanat::findOrFail($id);
            $assistant->delete();

            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'success',
                'message' => "assistant Supprimé avec succès",
            ]);
        } catch (\Throwable $th) {
            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'La suppression de la assistant a échoué !',
            ]);
        }

        session()->flash('session', $content);
        return back();
    }
}
