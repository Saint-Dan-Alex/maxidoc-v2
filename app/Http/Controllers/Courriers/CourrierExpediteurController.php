<?php

namespace App\Http\Controllers\Courriers;

use App\Http\Controllers\Controller;
use App\Models\CourrierExpediteur;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CourrierExpediteurController extends Controller
{
    public function index()
    {
        $expediteurs = CourrierExpediteur::latest()->paginate(10);
        
        if (request()->wantsJson()) {
            return response()->json($expediteurs);
        }
        
        return view('regidoc.pages.systems.courrier-expediteur', [
            'expediteurs' => $expediteurs
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nom' => 'required|string|max:255',
                'category_id' => 'required|exists:courrier_categories,id',
            ]);

            $expediteur = CourrierExpediteur::create($validated);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Expéditeur créé avec succès',
                    'data' => $expediteur
                ]);
            }

            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'success',
                'message' => 'Expéditeur créé avec succès',
            ]);
            return redirect()->route('regidoc.expediteurs.index')->with('session', $content);
        } catch (ValidationException $e) {
            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'La validation a échoué. Veuillez vérifier le formulaire.',
            ]);
            return redirect()->back()->with('session', $content)->withErrors($e->errors())->withInput();
        } catch (\Throwable $th) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de la création de l\'expéditeur',
                ], 500);
            }
            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'La création de l\'expéditeur a échoué !',
            ]);
            return redirect()->back()->with('session', $content);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $expediteur = CourrierExpediteur::findOrFail($id);
            
            $validated = $request->validate([
                'nom' => 'required|string|max:255',
                'category_id' => 'required|exists:courrier_categories,id',
            ]);

            $expediteur->update($validated);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Expéditeur mis à jour avec succès',
                    'data' => $expediteur
                ]);
            }

            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'success',
                'message' => 'Expéditeur mis à jour avec succès',
            ]);
            return redirect()->route('regidoc.expediteurs.index')->with('session', $content);
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
                    'message' => 'Erreur lors de la mise à jour de l\'expéditeur',
                ], 500);
            }
            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'La mise à jour de l\'expéditeur a échoué !',
            ]);
            return back()->with('session', $content);
        }
    }

    public function destroy($id)
    {
        try {
            $expediteur = CourrierExpediteur::findOrFail($id);
            $expediteur->delete();

            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'success',
                'message' => 'Expéditeur supprimé avec succès',
            ]);
            if (request()->wantsJson()) {
                return response()->json(['success' => true, 'message' => 'Expéditeur supprimé avec succès']);
            }
            return redirect()->route('regidoc.expediteurs.index')->with('session', $content);
        } catch (\Throwable $th) {
            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'La suppression de l\'expéditeur a échoué !',
            ]);
            if (request()->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Erreur lors de la suppression'], 500);
            }
            return redirect()->route('regidoc.expediteurs.index')->with('session', $content);
        }
    }
}
