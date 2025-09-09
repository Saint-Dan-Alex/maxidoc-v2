<?php

namespace App\Http\Controllers\Courriers;

use App\Http\Controllers\Controller;
use App\Models\CourrierNature;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CourrierNatureController extends Controller
{
    public function index()
    {
        $natures = CourrierNature::latest()->paginate(10);
        
        if (request()->wantsJson()) {
            return response()->json($natures);
        }
        
        return view('regidoc.pages.systems.courrier-nature', [
            'natures' => $natures
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'titre' => 'required|string|max:255'
            ]);

            $nature = CourrierNature::create($validated);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Nature de courrier créée avec succès',
                    'data' => $nature
                ]);
            }

            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'success',
                'message' => 'Nature de courrier créée avec succès',
            ]);
            return redirect()->route('regidoc.natures.index')->with('session', $content);
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
                    'message' => 'Erreur lors de la création de la nature',
                ], 500);
            }
            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'La création de la Nature a échoué !',
            ]);
            return redirect()->back()->with('session', $content);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $nature = CourrierNature::findOrFail($id);
            
            $validated = $request->validate([
                'titre' => 'required|string|max:255'
            ]);

            $nature->update($validated);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Nature de courrier mise à jour avec succès',
                    'data' => $nature
                ]);
            }

            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'success',
                'message' => 'Nature de courrier mise à jour avec succès',
            ]);
            return redirect()->route('regidoc.natures.index')->with('session', $content);
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
                    'message' => 'Erreur lors de la mise à jour de la nature',
                ], 500);
            }
            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'La mise à jour de la Nature a échoué !',
            ]);
            return redirect()->back()->with('session', $content);
        }
    }

    public function destroy($id)
    {
        try {
            $nature = CourrierNature::findOrFail($id);
            $nature->delete();

            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'success',
                'message' => 'Nature de courrier supprimée avec succès',
            ]);
            if (request()->wantsJson()) {
                return response()->json(['success' => true, 'message' => 'Nature de courrier supprimée avec succès']);
            }
            return redirect()->route('regidoc.natures.index')->with('session', $content);
        } catch (\Throwable $th) {
            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'La suppression de la Nature a échoué !',
            ]);
            if (request()->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Erreur lors de la suppression'], 500);
            }
            return redirect()->route('regidoc.natures.index')->with('session', $content);
        }
    }
}
