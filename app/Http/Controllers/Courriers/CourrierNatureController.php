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
        
        return view('regidoc.pages.systems.courrier-nature', [
            'natures' => $natures
        ]);
    }

    public function store(Request $request)
    {
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

        return redirect()->route('regidoc.natures.index')
            ->with('success', 'Nature de courrier créée avec succès');
    }

    public function update(Request $request, $id)
    {
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

        return redirect()->route('regidoc.natures.index')
            ->with('success', 'Nature de courrier mise à jour avec succès');
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
