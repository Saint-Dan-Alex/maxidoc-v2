<?php

namespace App\Http\Controllers\RH;

use App\Http\Controllers\Controller;
use App\Models\Direction;
use App\Models\Division;
use App\Models\Fonction;
use App\Models\Section;
use App\Models\Service;
use App\Models\Statut;
use App\Models\User;
use Illuminate\Http\Request;

class FonctionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'fonctions' => Fonction::all(),
            'users' => User::select('name', 'id')->get(),
            'services' => Service::select('titre', 'id')->get(),
            'sections' => Section::select('titre', 'id')->get(),
            'directions' => Direction::select('titre', 'id')->get(),
            'divisions' => Division::select('libelle', 'id')->get(),
            'statuts' => Statut::select('libelle', 'id')->get(),
        ];
        return view('regidoc.pages.systems.fonction', $data);
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
            Fonction::create([
                "titre" => $request->libelle,
                "section_id" => $request->section_id ?? null,
                "service_id" => $request->service_id ?? null,
                "division_id" => $request->division_id ?? null,
                "direction_id" => $request->direction_id ?? null,
                "description" => $request->description ?? null,
            ]);

            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'success',
                'message' => "Fonction ajoutée avec succès",
            ]);
        } catch (\Throwable $th) {
            // dd($th);
            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'L\'ajout de la Fonction a échoué !',
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
            $Fonction = Fonction::findOrFail($id);

            $Fonction->update([
                "titre" => $request->libelle,
                "section_id" => $request->section_id ?? null,
                "service_id" => $request->service_id ?? null,
                "division_id" => $request->division_id ?? null,
                "direction_id" => $request->direction_id ?? null,
                "description" => $request->description ?? null,
            ]);

            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'success',
                'message' => "Fonction modifiée avec succès",
            ]);
        } catch (\Throwable $th) {
            // dd($th);
            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'La modification de la Fonction a échoué !',
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
            $Fonction = Fonction::findOrFail($id);

            $Fonction->delete();

            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'success',
                'message' => "Fonction Supprimée avec succès",
            ]);
        } catch (\Throwable $th) {
            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'La suppression de la Fonction a échoué !',
            ]);
        }

        session()->flash(
            'session',
            $content
        );

        return back();
    }
}
