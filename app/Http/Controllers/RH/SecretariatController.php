<?php

namespace App\Http\Controllers\RH;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Departement;
use App\Models\Direction;
use App\Models\Division;
use App\Models\Fonction;
use App\Models\Secretariat;
use App\Models\Statut;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SecretariatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('regidoc.pages.systems.secretariat');
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
            Secretariat::create([
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

            $agent = Agent::find($request->responsable_id);
            $agent->update([
                'fonction_id' => $fonction->id,
                'direction_id' => $request->direction_id
            ]);
            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'success',
                'message' => "Secretariat ajouté avec succès",
            ]);
        } catch (\Throwable $th) {
            // dd($th);
            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'L\'ajout de la Secretariat a échoué !',
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
            $secretariat = Secretariat::find($id);
            $ancienAgent = Agent::find($secretariat->responsable_id);

            $ancienAgent->update([
                'fonction_id' => null
            ]);

            $secretariat->update([
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

            $agent = Agent::find($request->responsable_id);
            $agent->update([
                'fonction_id' => $fonction->id,
                'direction_id' => $request->direction_id
            ]);

            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'success',
                'message' => "Secretariat modifié avec succès",
            ]);

        } catch (\Throwable $th) {
            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'La modification de la Secretariat a échoué !',
            ]);
        }

        Session::put(
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
            $Secretariat = Secretariat::findOrFail($id);

            $Secretariat->delete();

            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'success',
                'message' => "Secretariat Supprimé avec succès",
            ]);
        } catch (\Throwable $th) {
            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'La suppression de la Secretariat a échoué !',
            ]);
        }

        session()->flash(
            'session',
            $content
        );

        return back();
    }
}
