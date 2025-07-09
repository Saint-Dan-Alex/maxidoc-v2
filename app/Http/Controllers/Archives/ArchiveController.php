<?php

namespace App\Http\Controllers\Archives;

use App\Http\Controllers\Controller;
use App\Models\Classeur;
use App\Models\Document;
use App\Models\DocumentArchivage;
use App\Models\Dossier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ArchiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classeurs = Classeur::select('id', 'titre')->get()->filter(function ($classeur) {
            return Gate::allows('view_classeur', $classeur);
        });

        $dossiers = Dossier::select('id', 'titre')->get()->filter(function ($dossier) {
            return Gate::allows('view_dossier', $dossier);
        });

        $files = Document::archive()->select('id', 'libelle')->get()->filter(function ($document) {
            return Gate::allows('view_document', $document);
        });

        return view("regidoc.pages.archives.index")->with([
            'countClasseurs' => $classeurs->count(),
            'countDossiers' => $dossiers->count(),
            'countFiles' => $files->count(),
            'classeurs' => $classeurs,
            'dossiers' => $dossiers,
            'files' => $files,
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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