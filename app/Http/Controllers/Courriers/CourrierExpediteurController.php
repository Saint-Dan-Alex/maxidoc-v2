<?php

namespace App\Http\Controllers\Courriers;

use App\Http\Controllers\Controller;
use App\Models\CourrierExpediteur;
use Illuminate\Http\Request;

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

        return redirect()->route('regidoc.expediteurs.index')
            ->with('success', 'Expéditeur créé avec succès');
    }

    public function update(Request $request, $id)
    {
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

        return redirect()->route('regidoc.expediteurs.index')
            ->with('success', 'Expéditeur mis à jour avec succès');
    }

    public function destroy($id)
    {
        $expediteur = CourrierExpediteur::findOrFail($id);
        $expediteur->delete();

        return response()->json([
            'success' => true,
            'message' => 'Expéditeur supprimé avec succès'
        ]);
    }
}
