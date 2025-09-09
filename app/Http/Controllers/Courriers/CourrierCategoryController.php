<?php

namespace App\Http\Controllers\Courriers;

use App\Http\Controllers\Controller;
use App\Models\CourrierCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CourrierCategoryController extends Controller
{
    public function index()
    {
        $categories = CourrierCategory::latest()->paginate(10);
        
        if (request()->wantsJson()) {
            return response()->json($categories);
        }
        
        return view('regidoc.pages.systems.courrier-category', [
            'categories' => $categories
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255'
            ]);

            $category = CourrierCategory::create($validated);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Catégorie créée avec succès',
                    'data' => $category
                ]);
            }

            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'success',
                'message' => 'Catégorie créée avec succès',
            ]);
            return redirect()->route('regidoc.categories.index')->with('session', $content);
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
                    'message' => 'Erreur lors de la création de la catégorie',
                ], 500);
            }
            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'La création de la Catégorie a échoué !',
            ]);
            return back()->with('session', $content);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $category = CourrierCategory::findOrFail($id);
            
            $validated = $request->validate([
                'title' => 'required|string|max:255'
            ]);

            $category->update($validated);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Catégorie mise à jour avec succès',
                    'data' => $category
                ]);
            }

            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'success',
                'message' => 'Catégorie mise à jour avec succès',
            ]);
            return redirect()->route('regidoc.categories.index')->with('session', $content);

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
                    'message' => 'Erreur lors de la mise à jour de la catégorie',
                ], 500);
            }
            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'La mise à jour de la Catégorie a échoué !',
            ]);
            return back()->with('session', $content);
        }
    }

    public function destroy($id)
    {
        try {
            $category = CourrierCategory::findOrFail($id);
            $category->delete();

            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'success',
                'message' => 'Catégorie supprimée avec succès',
            ]);
            return redirect()->route('regidoc.categories.index')->with('session', $content);
            
        } catch (\Throwable $th) {
            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'La suppression de la Catégorie a échoué !',
            ]);
            return redirect()->back()->with('session', $content);
        }
    }
}
