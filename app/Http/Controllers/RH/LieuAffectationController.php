<?php

namespace App\Http\Controllers\RH;

use App\Http\Controllers\Controller;
use App\Models\LieuAffectation;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LieuAffectationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $data = [
        //     'lieus' => LieuAffectation::select('id','titre')->orderBy('titre')->paginate(10),
        // ];
        return view('regidoc.pages.systems.lieu');
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
            $validated = $request->validate([
                'titre' => 'required|string|max:255',
            ]);

            $lieu = LieuAffectation::create([
                'titre' => $validated['titre'],
            ]);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => "Lieu d'Affectation ajouté avec succès",
                    'data' => $lieu,
                ]);
            }

            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'success',
                'message' => "Lieu d'Affectation ajouté avec succès",
            ]);
            return redirect()->route('regidoc.lieux.index')->with('session', $content);
        } catch (ValidationException $e) {
            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'La validation a échoué. Veuillez vérifier le formulaire.',
            ]);
            return back()->with('session', $content)->withErrors($e->errors())->withInput();
        } catch (\Throwable $th) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => "Erreur lors de la création du Lieu d'Affectation",
                ], 500);
            }
            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => "L'ajout du Lieu d'Affectation a échoué !",
            ]);
            return back()->with('session', $content);
        }
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
            $lieu = LieuAffectation::findOrFail($id);

            $validated = $request->validate([
                'titre' => 'required|string|max:255',
            ]);

            $lieu->update([
                'titre' => $validated['titre'],
            ]);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Lieu d\'Affectation mis à jour avec succès',
                    'data' => $lieu,
                ]);
            }

            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'success',
                'message' => "Lieu d'Affectation mis à jour avec succès",
            ]);
            return redirect()->route('regidoc.lieux.index')->with('session', $content);
        } catch (ValidationException $e) {
            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'La validation a échoué. Veuillez vérifier le formulaire.',
            ]);
            return back()->with('session', $content)->withErrors($e->errors())->withInput();
        } catch (\Throwable $th) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de la mise à jour du Lieu d\'Affectation',
                ], 500);
            }
            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'La mise à jour du Lieu d\'Affectation a échoué !',
            ]);
            return back()->with('session', $content);
        }
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
            $lieu = LieuAffectation::findOrFail($id);
            $lieu->delete();

            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'success',
                'message' => "Lieu d'Affectation supprimé avec succès",
            ]);
            if (request()->wantsJson()) {
                return response()->json(['success' => true, 'message' => "Lieu d'Affectation supprimé avec succès"]);
            }
            return redirect()->route('regidoc.lieux.index')->with('session', $content);
        } catch (\Throwable $th) {
            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => "La suppression du Lieu d'Affectation a échoué !",
            ]);
            if (request()->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Erreur lors de la suppression'], 500);
            }
            return back()->with('session', $content);
        }
    }
}