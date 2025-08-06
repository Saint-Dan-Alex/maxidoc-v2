<?php

namespace App\Http\Controllers\Courriers;

use App\Http\Controllers\Controller;
use App\Models\CourrierCategory;
use Illuminate\Http\Request;

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
        $validated = $request->validate([
            'title' => 'required|string|max:255'
        ]);

        $category = CourrierCategory::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Catégorie créée avec succès',
            'data' => $category
        ]);
    }

    public function update(Request $request, $id)
    {
        $category = CourrierCategory::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255'
        ]);

        $category->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Catégorie mise à jour avec succès',
            'data' => $category
        ]);
    }

    public function destroy($id)
    {
        $category = CourrierCategory::findOrFail($id);
        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Catégorie supprimée avec succès'
        ]);
    }
}
