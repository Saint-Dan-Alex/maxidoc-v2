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
use Illuminate\Validation\ValidationException;

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
        try {
            $request->validate([
                'libelle' => 'required|string|max:255',
            ]);
            Fonction::firstOrCreate([
                "titre" => $request->libelle,
            ], );

            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'success',
                'message' => "Fonction ajoutée avec succès",
            ]);
        } catch (ValidationException $e) {
            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => "La validation a échoué. Veuillez vérifier le formulaire.",
            ]);
            session()->flash('session', $content);
            return back()->withErrors($e->errors())->withInput();
        } catch (\Throwable $th) {
            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'L\'ajout de la Fonction a échoué !',
            ]);
        }

        return redirect()->back()->with('session', $content);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'titre' => 'required|string|max:255',
            ]);
            $fonction = Fonction::findOrFail($id);

            $fonction->update([
                "titre" => $request->titre,                
            ]);

            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'success',
                'message' => "Fonction modifiée avec succès",
            ]);
        } catch (ValidationException $e) {
            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => "La validation a échoué. Veuillez vérifier le formulaire.",
            ]);
            session()->flash('session', $content);
            return back()->withErrors($e->errors())->withInput();
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
