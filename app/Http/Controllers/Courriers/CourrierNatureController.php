<?php

namespace App\Http\Controllers\Courriers;

use App\Http\Controllers\Controller;
use App\Models\CourrierNature;
use Illuminate\Http\Request;

class CourrierNatureController extends Controller
{
    public function index()
    {
        $natures = CourrierNature::latest()->paginate(10);
        
        if (request()->wantsJson()) {
            return response()->json($natures);
        }
        
        return view('livewire.systems.courrier-nature', [
            'natures' => $natures
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'libelle' => 'required|string|max:255',
            'description' => 'nullable|string',
            'couleur' => 'nullable|string|max:50',
            'delai_traitement' => 'nullable|integer|min:1',
        ]);

        $nature = CourrierNature::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Nature de courrier créée avec succès',
            'data' => $nature
        ]);
    }

    public function update(Request $request, $id)
    {
        $nature = CourrierNature::findOrFail($id);
        
        $validated = $request->validate([
            'libelle' => 'required|string|max:255',
            'description' => 'nullable|string',
            'couleur' => 'nullable|string|max:50',
            'delai_traitement' => 'nullable|integer|min:1',
        ]);

        $nature->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Nature de courrier mise à jour avec succès',
            'data' => $nature
        ]);
    }

    public function destroy($id)
    {
        $nature = CourrierNature::findOrFail($id);
        $nature->delete();

        return response()->json([
            'success' => true,
            'message' => 'Nature de courrier supprimée avec succès'
        ]);
    }
}
