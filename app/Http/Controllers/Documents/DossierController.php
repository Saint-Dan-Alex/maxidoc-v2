<?php

namespace App\Http\Controllers\Documents;

use App\Http\Controllers\Controller;
use App\Models\ArchivePermission;
use App\Models\Classeur;
use App\Models\Dossier;
use App\Models\DossierPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DossierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        try {
            if ($request->confidentiel === 1) {

                if ($request->password === $request->password_confirm) {
                    $dossier = Dossier::create([
                        'titre' => $request->titre,
                        'classeur_id' => $request->classeur_id,
                        'reference' => $request->reference,
                        'description' => $request->description,
                        'confidentiel' => $request->confidentiel,
                        'created_by' => Auth::user()->agent->id,
                        'updated_by' => Auth::user()->agent->id,
                    ]);

                    DossierPassword::create([
                        'dossier_id' => $dossier->id,
                        'password' => Hash::make($request->password),
                    ]);

                    ArchivePermission::create([
                        'agent_id' => Auth::user()->agent->id,
                        'permissionable_id' => $dossier->id,
                        'permissionable_type' => 'App\Models\Dossier',
                        'key' => 'view_dossier',
                    ]);

                    $content = json_encode([
                        'name' => 'Dossier',
                        'statut' => 'success',
                        'message' => 'La creation du dossier a réussie avec succès !',
                    ]);

                } else {
                    $content = json_encode([
                        'name' => 'Dossier',
                        'statut' => 'error',
                        'message' => 'La création du dossier a échouée, les deux mot de passe ne correspondent pas',
                    ]);
                }

            } else {

                $dossier = Dossier::create([
                    'titre' => $request->titre,
                    'classeur_id' => $request->classeur_id,
                    'reference' => $request->reference,
                    'description' => $request->description,
                    'confidentiel' => $request->confidentiel,
                    'created_by' => Auth::user()->agent->id,
                    'updated_by' => Auth::user()->agent->id,
                ]);

                ArchivePermission::create([
                    'agent_id' => Auth::user()->agent->id,
                    'permissionable_id' => $dossier->id,
                    'permissionable_type' => 'App\Models\Dossier',
                    'key' => 'view_dossier',
                ]);

                // dd($dossier);

                $content = json_encode([
                    'name' => 'Dossier',
                    'statut' => 'success',
                    'message' => 'La creation du dossier a réussie avec succès !',
                ]);
            }
        } catch (\Throwable $th) {
            // dd($th);
            $content = json_encode([
                'name' => 'Dossier',
                'statut' => 'error',
                'message' => 'La création du dossier a échouée, une erreur innattendue s\'est produite. vérifiez que la référence du dossier n\'existe pas',
            ]);
        }

        session()->flash(
            'session',
            $content
        );

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Classeur $classeur, Dossier $dossier)
    {
        // $classeurs = Classeur::all();
        // dd($dossier->documents);
        return view("regidoc.pages.documents.document-details")->with([
            'dossier' => $dossier,
            'documents' => $dossier->documents,
            // 'classeurs' => $classeurs,
        ]);
    }

    public function access(Request $request)
    {
        // dd($dossier);
        $dossier = Dossier::find($request->dossier_id);
        if (Hash::check($request->password, $dossier->access->password)) {
            $content = json_encode([
                'name' => 'Dossier',
                'statut' => 'success',
                'message' => 'Accès authorisé',
            ]);
            session()->flash(
                'session',
                $content
            );
            return redirect()->route('regidoc.dossiers.show', $dossier);
        }

        $content = json_encode([
            'name' => 'Dossier',
            'statut' => 'error',
            'message' => 'Mot de passe incorrect',
        ]);

        session()->flash(
            'session',
            $content
        );

        return redirect()->back();
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
    public function update(Request $request, Dossier $dossier)
    {
        try {
            if ($request->confidentiel === '1') {
                if ($request->has('password') && $request->password != null) {
                    if ($request->password === $request->password_confirm) {
                        $dossier->update([
                            'titre' => $request->titre,
                            // 'classeur_id' => $request->classeur_id,
                            'reference' => $request->reference,
                            'description' => $request->description,
                            'confidentiel' => $request->confidentiel,
                            'created_by' => Auth::user()->agent->id,
                            'updated_by' => Auth::user()->agent->id,
                        ]);

                        DossierPassword::updateOrCreate(
                            [
                                'dossier_id' => $dossier->id
                            ],
                            [
                                'password' => Hash::make($request->password),
                            ]
                        );

                        // $dossier->access->password = Hash::make($request->password);
                        // $dossier->access->save();

                        $content = json_encode([
                            'name' => 'Dossier',
                            'statut' => 'success',
                            'message' => 'La modification du dossier a réussie avec succès !',
                        ]);
                    } else {
                        $content = json_encode([
                            'name' => 'Dossier',
                            'statut' => 'error',
                            'message' => 'La modification du dossier a échouée, les deux mot de passe ne correspondent pas',
                        ]);
                    }
                } else {
                    $dossier->update([
                        // 'classeur_id' => $request->classeur_id,
                        // 'confidentiel' => $request->confidentiel,
                        'titre' => $request->titre,
                        'reference' => $request->reference,
                        'description' => $request->description,
                        'created_by' => Auth::user()->agent->id,
                        'updated_by' => Auth::user()->agent->id,
                    ]);
                    $content = json_encode([
                        'name' => 'Dossier',
                        'statut' => 'success',
                        'message' => 'La modification du dossier a réussie avec succès !',
                    ]);
                }
            } else {
                $dossier->update([
                    // 'classeur_id' => $request->classeur_id,
                    // 'confidentiel' => $request->confidentiel,
                    'titre' => $request->titre,
                    'reference' => $request->reference,
                    'description' => $request->description,
                    'created_by' => Auth::user()->agent->id,
                    'updated_by' => Auth::user()->agent->id,
                ]);
                $content = json_encode([
                    'name' => 'Dossier',
                    'statut' => 'success',
                    'message' => 'La modification du dossier a réussie avec succès !',
                ]);
            }
        } catch (\Throwable $th) {
            $content = json_encode([
                'name' => 'Dossier',
                'statut' => 'error',
                'message' => 'La modification du dossier a échouée, une erreur innattendue s\'est produite. vérifiez que la référence du dossier n\'existe pas',
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
    public function destroy($id)
    {
        $dossier = Dossier::find($id);
        $dossier->delete();

        $content = json_encode([
            'name' => 'Dossier',
            'statut' => 'success',
            'message' => 'Dossier supprimé avec succès !',
        ]);

        session()->flash(
            'session',
            $content
        );

        return redirect()->route('regidoc.classeurs.show', $dossier->classeur);
    }
}
