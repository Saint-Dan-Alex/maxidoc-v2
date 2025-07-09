<?php

namespace App\Http\Controllers\Archives;

use App\Http\Controllers\Controller;
use App\Http\Controllers\File;
use App\Models\ArchivePermission;
use App\Models\Classeur;
use App\Models\Document;
use App\Models\DocumentArchivage;
use App\Models\Dossier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
  
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
        $document = new DocumentArchivage();
        $document->titre = $request->titre;
        $document->reference = $request->reference;
        $document->dossier_id = $request->dossier_id;
        $document->description = $request->description;
        if ($request->has('from_archive') && $request->from_archive == true) {
            $document->lien_fichier = $request->old_file;
        } else {
            $document->lien_fichier = (new File())->handle($request, 'lien_fichier', 'documents');
        }
        $document->created_by = Auth::user()->agent->id;
        $document->updated_by = Auth::user()->agent->id;
        $document->save();

        ArchivePermission::create([
            'agent_id' => Auth::user()->agent->id,
            'permissionable_id' => $document->id,
            'permissionable_type' => 'App\Models\DocumentArchivage',
            'key' => 'view_document',
        ]);

        $content = json_encode([
            'name' => 'Mon Profil',
            'statut' => 'success',
            'message' => 'Document archivé avec succès !',
        ]);

        session()->flash(
            'session',
            $content
        );

        return redirect()->back()->with('success', 'document créee avec succès !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $find_document = Document::find($id);
        $classeurs = Classeur::all();
        $dossiers = Dossier::all();
        return view('regidoc.pages.archives.show-doc', compact('find_document', 'classeurs', 'dossiers'));
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}