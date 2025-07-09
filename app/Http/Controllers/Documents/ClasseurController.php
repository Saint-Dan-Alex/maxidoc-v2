<?php

namespace App\Http\Controllers\Documents;

use App\Http\Controllers\Controller;
use App\Models\ArchivePermission;
use App\Models\Classeur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ClasseurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(true);
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
        try {
            $classeur = Classeur::create([
                'titre' => Auth::user()->agent->direction?->lieu?->titre ?? 'Region inconnu',
                'reference' => 'DIR'.Str::padLeft(Classeur::count() + 1,4,0),
                // 'titre' => $request->titre,
                'direction_id' => Auth::user()->agent->direction_id,
                'description' => $request->description,
                // 'reference' => $request->reference,
                'created_by' => Auth::user()->agent->id,
                'updated_by' => Auth::user()->agent->id,
            ]);

            ArchivePermission::create([
                'agent_id' => Auth::user()->agent->id,
                'permissionable_id' => $classeur->id,
                'permissionable_type' => 'App\Models\Classeur',
                'key' => 'view_classeur',
            ]);

            $content = json_encode([
                'name' => 'Document / Classeur',
                'statut' => 'success',
                'message' => 'Classeur créé avec succès !',
            ]);
        } catch (\Throwable $th) {
            // dd($th);
            $content = json_encode([
                'name' => 'Document / Classeur',
                'statut' => 'error',
                'message' => 'Impossible de créer le classeur, une errer s\'est produite',
            ]);
        }

        session()->flash(
            'session',
            $content
        );

        return redirect()->back();
    }

    public function voirdossiers()
    {  
        return view("regidoc.pages.documents.dossiersrepo");
    }

    public function voircourriers()
    {  
        return view("regidoc.pages.documents.dossiercourriers");
    }

    public function voirtaches()
    {  
        return view("regidoc.pages.documents.dossiertaches");
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Classeur $classeur)
    {
        $classeurs = Classeur::all();
        return view("regidoc.pages.documents.dossiers")->with([
            'classeurs' => $classeurs,
            'classeur' => $classeur,
            'dossiers' => $classeur->dossiers
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Classeur $classeur)
    {
        try {
            $classeur->update([
                // 'departement_id' => Auth::user()->agent->departement?->id,
                'reference' => $request->reference,
                'titre' => $request->titre,
                'description' => $request->description,
                'created_by' => Auth::user()->agent->id,
                'updated_by' => Auth::user()->agent->id,
            ]);

            $content = json_encode([
                'name' => 'Document / Classeur',
                'statut' => 'success',
                'message' => 'Classeur modifié avec succès !',
            ]);
        } catch (\Throwable $th) {
            $content = json_encode([
                'name' => 'Document / Classeur',
                'statut' => 'error',
                'message' => 'Impossible de modifier le classeur, une errer s\'est produite',
            ]);
        }

        session()->flash(
            'session',
            $content
        );

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Classeur $classeur)
    {
        $classeur->delete();
        $content = json_encode([
            'name' => 'Document / Classeur',
            'statut' => 'success',
            'message' => 'Classeur supprimé avec succès !',
        ]);

        session()->flash(
            'session',
            $content
        );
        return redirect()->back();
    }
}
