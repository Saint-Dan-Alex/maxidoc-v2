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
     */
    public function store(Request $request)
    {
        $request->validate([
            'libelle' => 'required|string|max:255',
            'section_id' => 'nullable|exists:sections,id',
            'service_id' => 'nullable|exists:services,id',
            'division_id' => 'nullable|exists:divisions,id',
            'direction_id' => 'nullable|exists:directions,id',
            'description' => 'nullable|string',
        ]);

        try {
            Fonction::firstOrCreate([
                "titre" => $request->libelle,
                "section_id" => $request->section_id,
                "service_id" => $request->service_id,
                "division_id" => $request->division_id,
                "direction_id" => $request->direction_id,
            ], [
                "description" => $request->description
            ]);

            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'success',
                'message' => "Fonction ajoutée avec succès",
            ]);
        } catch (\Throwable $th) {
            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'L\'ajout de la Fonction a échoué !',
            ]);
        }

        session()->flash('session', $content);
        return back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'libelle' => 'required|string|max:255',
            'section_id' => 'nullable|exists:sections,id',
            'service_id' => 'nullable|exists:services,id',
            'division_id' => 'nullable|exists:divisions,id',
            'direction_id' => 'nullable|exists:directions,id',
            'description' => 'nullable|string',
        ]);

        try {
            $fonction = Fonction::findOrFail($id);

            $fonction->update([
                "titre" => $request->libelle,
                "section_id" => $request->section_id,
                "service_id" => $request->service_id,
                "division_id" => $request->division_id,
                "direction_id" => $request->direction_id,
                "description" => $request->description,
            ]);

            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'success',
                'message' => "Fonction modifiée avec succès",
            ]);
        } catch (\Throwable $th) {
            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'La modification de la Fonction a échoué !',
            ]);
        }

        session()->flash('session', $content);
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $fonction = Fonction::findOrFail($id);
            $fonction->delete();

            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'success',
                'message' => "Fonction supprimée avec succès",
            ]);
        } catch (\Throwable $th) {
            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'La suppression de la Fonction a échoué !',
            ]);
        }

        session()->flash('session', $content);
        return back();
    }
}
