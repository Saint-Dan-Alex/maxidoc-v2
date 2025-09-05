<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $destinations = Destination::latest()->paginate(10);
        
        if (request()->wantsJson()) {
            return response()->json($destinations);
        }
        
        return view('regidoc.pages.settings.destinations.index', [
            'destinations' => $destinations
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'nom' => 'required|string|max:255|unique:destinations,nom'
        ]);

        $destination = Destination::create($validated);
        
        if ($request->wantsJson()) {
            return response()->json($destination, 201);
        }
        
        return redirect()->route('destinations.index')
            ->with('success', 'Destination créée avec succès.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Destination  $destination
     * @return \Illuminate\Http\Response
     */
    public function show(Destination $destination)
    {
        if (request()->wantsJson()) {
            return response()->json($destination);
        }
        
        return view('regidoc.pages.settings.destinations.show', [
            'destination' => $destination
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Destination  $destination
     * @return \Illuminate\Http\Response
     */
    public function edit(Destination $destination)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Destination  $destination
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Destination $destination)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:destinations,nom,' . $destination->id
        ]);

        $destination->update($validated);
        
        if ($request->wantsJson()) {
            return response()->json($destination);
        }
        
        return redirect()->route('destinations.index')
            ->with('success', 'Destination mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Destination  $destination
     * @return \Illuminate\Http\Response
     */
    public function destroy(Destination $destination)
    {
        try {
            // Vérifier si la destination est utilisée dans des documents
            if ($destination->documents()->exists()) {
                $message = 'Impossible de supprimer cette destination car elle est associée à des documents.';
                
                if (request()->wantsJson()) {
                    return response()->json(['message' => $message], 422);
                }
                
                return back()->with('error', $message);
            }
            
            $destination->delete();
            
            if (request()->wantsJson()) {
                return response()->json(['message' => 'Destination supprimée avec succès']);
            }
            
            return redirect()->route('destinations.index')
                ->with('success', 'Destination supprimée avec succès');
            
        } catch (\Exception $e) {
            $message = 'Une erreur est survenue lors de la suppression de la destination';
            
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
