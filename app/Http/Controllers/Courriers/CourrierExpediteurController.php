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
        
        return view('livewire.systems.courrier-expediteur', [
            'expediteurs' => $expediteurs
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'type' => 'required|in:interne,externe',
            'adresse' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        $expediteur = CourrierExpediteur::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Expéditeur créé avec succès',
            'data' => $expediteur
        ]);
    }

    public function update(Request $request, $id)
    {
        $expediteur = CourrierExpediteur::findOrFail($id);
        
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'type' => 'required|in:interne,externe',
            'adresse' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        $expediteur->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Expéditeur mis à jour avec succès',
            'data' => $expediteur
        ]);
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
