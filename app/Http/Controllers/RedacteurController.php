<?php

namespace App\Http\Controllers;

use App\Models\Redacteur;
use Illuminate\Http\Request;

class RedacteurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $redacteurs = Redacteur::latest()->paginate(10);
        
        if (request()->wantsJson()) {
            return response()->json($redacteurs);
        }
        
        return view('regidoc.pages.settings.redacteurs.index', [
            'redacteurs' => $redacteurs
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:redacteurs,nom'
        ]);

        $redacteur = Redacteur::create($validated);
        
        if ($request->wantsJson()) {
            return response()->json($redacteur, 201);
        }
        
        return redirect()->route('redacteurs.index')
            ->with('success', 'Rédacteur créé avec succès.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Redacteur  $redacteur
     * @return \Illuminate\Http\Response
     */
    public function show(Redacteur $redacteur)
    {
        if (request()->wantsJson()) {
            return response()->json($redacteur);
        }
        
        return view('regidoc.pages.settings.redacteurs.show', [
            'redacteur' => $redacteur
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Redacteur  $redacteur
     * @return \Illuminate\Http\Response
     */
    public function edit(Redacteur $redacteur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Redacteur  $redacteur
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Redacteur $redacteur)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:redacteurs,nom,' . $redacteur->id
        ]);

        $redacteur->update($validated);
        
        if ($request->wantsJson()) {
            return response()->json($redacteur);
        }
        
        return redirect()->route('redacteurs.index')
            ->with('success', 'Rédacteur mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Redacteur  $redacteur
     * @return \Illuminate\Http\Response
     */
    public function destroy(Redacteur $redacteur)
    {
        try {
            // Vérifier si le rédacteur est utilisé dans des documents
            if ($redacteur->documents()->exists()) {
                $message = 'Impossible de supprimer ce rédacteur car il est associé à des documents.';
                
                if (request()->wantsJson()) {
                    return response()->json(['message' => $message], 422);
                }
                
                return back()->with('error', $message);
            }
            
            $redacteur->delete();
            
            if (request()->wantsJson()) {
                return response()->json(['message' => 'Rédacteur supprimé avec succès']);
            }
            
            return redirect()->route('redacteurs.index')
                ->with('success', 'Rédacteur supprimé avec succès');
            
        } catch (\Exception $e) {
            $message = 'Une erreur est survenue lors de la suppression du rédacteur';
            
            if (request()->wantsJson()) {
                return response()->json([
                    'message' => $message,
                    'error' => $e->getMessage(),
                ], 500);
            }
            
            return back()->with('error', $message);
        }
    }
}
