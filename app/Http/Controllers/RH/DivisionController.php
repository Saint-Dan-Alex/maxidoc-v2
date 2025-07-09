<?php

namespace App\Http\Controllers\RH;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Departement;
use App\Models\Direction;
use App\Models\Division;
use App\Models\Fonction;
use App\Models\Statut;
use App\Models\User;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'divisions' => Division::with('responsable', 'direction')->select('id','libelle','direction_id','responsable_id'),
            // 'users' => User::select('name', 'id')->get(),
            'directions' => Direction::select('titre', 'id')->get(),
            // 'statuts' => Statut::select('libelle', 'id')->get(),

        ];
        return view('regidoc.pages.systems.division', $data);
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
            $division = Division::create([
                "libelle" => $request->libelle,
                "responsable_id" => $request->responsable_id,
                "statut_id" => 1,
                "direction_id" => $request->direction_id,
                "description" => $request->description,
            ]);
            $fonction = Fonction::firstOrCreate([
                'titre' => 'Responsable ' . $request->libelle,
            ], [
                "direction_id" => $request->direction_id,
                "division_id" => $division->id,
            ]);

            $agent = Agent::findOrFail($request->responsable_id);
            $agent->update([
                'fonction_id' => $fonction->id,
                'division_id' => $division->id,
                'direction_id' => $division->direction_id
            ]);

            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'success',
                'message' => "Division ajouté avec succès",
            ]);

        } catch (\Throwable $th) {
            // dd($th);
            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'L\'ajout de la Division a échoué !',
            ]);
        }

        session()->flash(
            'session',
            $content
        );

        return redirect()->back();
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
            $division = Division::findOrFail($id);
            $division->update([
                "libelle" => $request->libelle,
                "responsable_id" => $request->responsable_id,
                "statut_id" => 1,
                "direction_id" => $request->direction_id,
                "description" => $request->description,
            ]);
            if ($request->responsable_id != $division->responsable_id) {
                # code...
                $ancienAgent = Agent::findOrFail($division->responsable_id);
                $ancienAgent->update([
                    'fonction_id' => null
                ]);
                $fonction = Fonction::firstOrCreate([
                    'titre' => 'Chef ' . $request->libelle,
                ], [
                    "direction_id" => $request->direction_id,
                    "division_id" => $division->id,
                ]);

                $agent = Agent::findOrFail($request->responsable_id);
                $agent->update([
                    'fonction_id' => $fonction->id,
                    'division_id' => $division->id,
                    'direction_id' => $division->direction_id
                ]);
            }
            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'success',
                'message' => "Division modifié avec succès",
            ]);
        } catch (\Throwable $th) {
            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'La modification de la Division a échoué !',
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
            $Division = Division::findOrFail($id);

            $Division->delete();

            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'success',
                'message' => "Division Supprimée avec succès",
            ]);
        } catch (\Throwable $th) {
            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'La suppression de la Division a échoué !',
            ]);
        }

        session()->flash(
            'session',
            $content
        );

        return back();
    }
}
