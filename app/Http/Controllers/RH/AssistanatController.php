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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('regidoc.pages.systems.assistanat');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            Assistanat::create([
                "titre" => $request->titre,
                "direction_id" => $request->direction_id,
                "responsable_id" => $request->responsable_id,
                "for_dg" => $request->for == 1 ? 1 : 0,
                "for_dga" => $request->for == 2 ? 1 : 0,
            ]);
            $fonction = Fonction::firstOrCreate([
                'titre' => $request->titre,
            ], [
                "direction_id" => $request->direction_id,
            ]);

            $agent = Agent::findOrFail($request->responsable_id);
            $agent->update([
                'fonction_id' => $fonction->id,
                'direction_id' => $request->direction_id
            ]);
            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'success',
                'message' => "assistant ajouté avec succès",
            ]);
        } catch (\Throwable $th) {
            // dd($th);
            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'L\'ajout de la assistant a échoué !',
            ]);
        }

        session()->flash(
            'session',
            $content
        );

        return back();
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $assistant = Assistanat::findOrFail($id);
            $ancienAgent = Agent::findOrFail($assistant->responsable_id);
            $ancienAgent->update([
                'fonction_id' => null
            ]);
            $assistant->update([
                "titre" => $request->titre,
                "direction_id" => $request->direction_id,
                "responsable_id" => $request->responsable_id,
                "for_dg" => $request->for == 1 ? 1 : 0,
                "for_dga" => $request->for == 2 ? 1 : 0,
            ]);
            $fonction = Fonction::firstOrCreate([
                'titre' => $request->titre,
            ], [
                "direction_id" => $request->direction_id,
            ]);

            $agent = Agent::findOrFail($request->responsable_id);
            $agent->update([
                'fonction_id' => $fonction->id,
                'direction_id' => $request->direction_id
            ]);

            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'success',
                'message' => "assistant modifié avec succès",
            ]);
        } catch (\Throwable $th) {
            // dd($th);
            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'La modification de la assistant a échoué !',
            ]);
        }

        session()->flash(
            'session',
            $content
        );

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

        session()->flash(
            'session',
            $content
        );

        return back();
    }
}
