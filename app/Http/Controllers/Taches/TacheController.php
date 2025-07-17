<?php

namespace App\Http\Controllers\Taches;

use App\Events\TacheCreated;
use App\Http\Controllers\Controller;
use App\Http\Controllers\File;
use App\Models\Agent;
use App\Models\ArchivePermission;
use App\Models\Classeur;
use App\Models\Direction;
use App\Models\Division;
use App\Models\Document;
use App\Models\Dossier;
use App\Models\Priorite;
use App\Models\Section;
use App\Models\Service;
use App\Models\Tache;
use App\Models\CourrierTraitement;
use App\Models\Courrier;
use App\Models\TacheObjectif;
use App\Mail\DocumentPasswordMail;
use App\Models\TachesStatut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Http\Controllers\Courriers\CourrierController as CourrierController;
use App\Models\Historique;

class TacheController extends Controller
{
    public function index()
    {
       
         if (Auth::user()->agent->isDG()) {
             $taches = Tache::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->paginate(10);
         } else {
             $taches = collect();
             $y = Tache::getTachesForCurrentUser();
             $z = Tache::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->get();
             $taches = $taches->merge($y)->merge($z);
             $taches = $taches->unique('id');
         }

         $num = $taches->count();

        return view('regidoc.pages.taches.index')->with([
             'taches' => $taches,
             'num' => $num,
         ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (Auth::user()->agent->isDG()) {
            if ($request->to == "direction") {
                # code...
                $data = [
                    'directions' => Direction::where('id', '!=', Auth::user()->agent->direction_id)->get(),
                    'priorites' => Priorite::select('id', 'titre')->get(),
                    'to' => 'direction',
                ];
            } elseif ($request->to == "agent") {
                # code...
                $data = [
                    'agents' => Agent::select('id', 'nom', 'prenom')
                        ->where('id', '!=', Auth::id())
                        ->get(),
                    'priorites' => Priorite::select('id', 'titre')->get(),
                    'to' => 'agent',
                ];
            } else {
                $data = [
                    'directions' => Direction::where('id', '!=', Auth::user()->agent->direction_id)->get(),
                    'priorites' => Priorite::select('id', 'titre')->get(),
                    'to' => null,
                ];

            }
        } else {
            $data = [
                'agents' => Agent::select('id', 'nom', 'prenom')
                    ->where('id', '!=', Auth::id())
                    ->where('direction_id', '=', Auth::user()->agent->direction_id)
                    ->get(),
                'priorites' => Priorite::select('id', 'titre')->get(),
                'to' => null,
            ];
        }

        if ($request->newdoc == 1 && $request->textSelected && $request->fileName) {
            $fileName = $request->fileName;
            $text = $request->textSelected;

            $name = $text . date('_dmYHi') . '.pdf';
            $data['isNewdoc'] = true;
            $data['docname'] = $name;
            $data['filename'] = $fileName;
            $data['dossiername'] = $text;
        } else {
            $data['isNewdoc'] = false;
        }

        if ($request->doc != null) {
            $id = intval($request->doc);
            $document = Document::findOrFail($id);
            $data['document'] = $document;
        } else {
            $data['document'] = null;
        }

        if ($request->parent_id != null) {

            $data['isSubTask'] = true;
            $data['tache'] = Tache::findOrFail($request->parent_id);

        } else {
            $data['isSubTask'] = false;
        }

        if ($request->courrier_id != null) {
            $data['courrier_id'] = $request->courrier_id;
        }

        return view('regidoc.pages.taches.new-task', $data);
    }

    public function createTache(Request $request, $followers = null)
    {
        $tache = Tache::create([
            'titre' => $request->titre,
            'description' => $request->description,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'priorite_id' => $request->priorite_id,
            'user_id' => Auth::user()->id,
            'parent_id' => $request->parent_id ?? null,
            'tache_statut_id' => 1,
            'courrier_id' => $request->courrier_id ?? null,
        ]);
        if ($followers) {
            # code...
            $this->createTacheDoc($request, $tache, $followers);
        }

        return $tache;
    }

    public function createTacheDoc(Request $request, $tache, $followers)
    {
        if ($request->has('parent_id')) {
            $newDoc = $tache->tacheParent?->documents->first();
            if ($newDoc) {
                $tache->documents()->attach($newDoc->id);

                $newDoc->followers()->attach($followers->pluck('id'));

                if ($newDoc->confidentiel) {
                    if (is_countable($followers)) {
                        $users = $followers->map(function ($agent) {
                            if ($agent) {
                                return $agent->user;
                            }
                        });
                        // foreach ($users as $user) {
                        //     # code...
                        //     Mail::to($user)->send(new DocumentPasswordMail($newDoc->password, $user));
                        // }
                    } else {
                        // Mail::to($followers->user)->send(new DocumentPasswordMail($newDoc->password, $followers->user));
                    }

                }
            }
        }

        if ($request->has('doc_id')) {
            $newDoc = Document::findOrFail($request->doc_id);
            $tache->documents()->attach($newDoc->id);

            $newDoc->followers()->attach($followers->pluck('id'));

            if ($newDoc->confidentiel) {
                if (is_countable($followers)) {
                    $users = $followers->map(function ($agent) {
                        return $agent->user;
                    });
                    // foreach ($users as $user) {
                    //     # code...
                    //     Mail::to($user)->send(new DocumentPasswordMail($newDoc->password, $user));
                    // }
                } else {
                    // Mail::to($followers->user)->send(new DocumentPasswordMail($newDoc->password, $followers->user));
                }

            }
        }

        if ($request->has('newdoc') && $request->newdoc == 1 && $request->docname && $request->filename && $request->dossiername) {

            $fileName = $request->filename . '.pdf';
            $dossierName = $request->dossiername;
            $docName = $request->docname;
            $path = 'public' . DIRECTORY_SEPARATOR . 'documents' . DIRECTORY_SEPARATOR . date('FY') . DIRECTORY_SEPARATOR;

            if (Storage::disk('local')->exists('tmp/' . $fileName)) {
                $doc = Storage::disk('local')->get('tmp/' . $fileName);
                Storage::disk('local')->put($path . $docName, $doc);
                Storage::disk('local')->delete('tmp/' . $fileName);
            }
            $classer = Classeur::where('direction_id', Auth::user()->agent->direction_id)->where('titre', 'Classeur Tâches ' . Auth::user()->agent->direction->titre)->first();
            if ($classer == null) {

                $classer = Classeur::firstOrCreate(
                    [
                        'direction_id' => Auth::user()->agent->direction_id,
                        'titre' => 'Tâches',
                    ],
                    [
                        'reference' => Auth::user()->agent->direction?->code . '/' . Classeur::count(),
                        'description' => 'Classeur des documents de vos tâches ' . Auth::user()->agent?->direction->titre,
                        'created_by' => Auth::user()->agent->id,
                        'updated_by' => Auth::user()->agent->id,
                    ]
                );
            }
            $dossier = Dossier::where('reference', 'DC/' . Auth::user()->agent?->matricule, )->first();
            if ($dossier == null) {
                $dossier = Dossier::firstOrCreate(
                    [
                        'classeur_id' => $classer->id,
                        'titre' => $dossierName,
                    ],
                    [
                        'reference' => 'DT/' . Auth::user()->agent?->matricule,
                        'confidentiel' => 0,
                        'description' => 'Dossier des documents créés par l\'agent ' . Auth::user()->agent?->nom,
                        'created_by' => Auth::user()->agent->id,
                        'updated_by' => Auth::user()->agent->id,
                    ]
                );
            }
            $filesPath = [];
            array_push($filesPath, [
                'download_link' => 'documents' . DIRECTORY_SEPARATOR . date('FY') . DIRECTORY_SEPARATOR . $docName,
                'original_name' => $docName,
            ]);
            $document = Document::create([
                'dossier_id' => $dossier->id,
                'libelle' => $docName,
                'category_id' => 6,
                'reference' => 'DT/' . Auth::user()->agent?->matricule,
                'type' => 3,
                'document' => json_encode($filesPath),
                'user_id' => Auth::user()->id,
                'statut_id' => 1,
                'created_by' => Auth::user()->agent->id,
            ]);

            // ArchivePermission::create([
            //     'agent_id' => Auth::user()->agent->id,
            //     'permissionable_id' => $document->id,
            //     'permissionable_type' => 'App\Models\Document',
            //     'key' => 'view_document',
            // ]);

            $tache->documents()->attach($document->id);

            $document->followers()->attach($followers);
        }

        if ($request->hasFile('documents')) {
            $classer = Classeur::where('direction_id', Auth::user()->agent?->direction_id)->where('titre', 'Classeur Tâches ' . Auth::user()->agent?->direction->titre)->first();
            if ($classer == null) {
                $classer = Classeur::firstOrCreate(
                    [
                        'direction_id' => Auth::user()->agent?->direction_id,
                        'titre' => 'Tâches',
                    ],
                    [
                        'reference' => Auth::user()->agent?->direction?->code,
                        'description' => 'Ce classeur contient tous les documents liés à vos tâches',
                        'created_by' => Auth::user()->agent->id,
                        'updated_by' => Auth::user()->agent->id,
                    ]
                );
            }

            $dossier = Dossier::firstOrCreate(
                [
                    'classeur_id' => $classer->id,
                    'titre' => 'Taches',
                ],
                [
                    'reference' => 'DIR' . Str::padLeft(Dossier::count() + 1, 4, 0),
                    'description' => 'Ce dossier contient les documents liés aux tâches',
                    'confidentiel' => 0,
                    'created_by' => Auth::user()->agent->id,
                    'updated_by' => Auth::user()->agent->id,
                ]
            );

            foreach ($request->file('documents') as $key => $doc) {
                // dd($doc->getClientOriginalName());
                $document = Document::create([
                    'dossier_id' => $dossier->id,
                    'libelle' => Str::beforeLast($doc->getClientOriginalName(), '.'),
                    'category_id' => 6,
                    'reference' => 'DT/' . Auth::user()->agent?->matricule,
                    'type' => 3,
                    'document' => (new File)->handle($doc, 'document', 'documents'),
                    'user_id' => Auth::user()->id,
                    'statut_id' => 1,
                    'created_by' => Auth::user()->agent->id,
                ]);

                $tache->documents()->attach($document->id);
                foreach ($followers as $follower) {
                    $document->followers()->attach($follower);
                }
            }
        }
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
            $followers = collect();

            if ($request->has('direction_id')) {
                $directions = Direction::find($request->input('direction_id'));

                foreach ($directions as $direction) {

                    $responsable = $direction->responsable;
                    $secretaires = $direction->secretaires->map(function ($secretaire) {
                        return $secretaire->responsable;
                    });
                    $secretaires2 = $secretaires;
                    $followers->push($secretaires2->add($responsable));
                    $followers = $followers->flatten();

                    $tache = $this->createTache($request, $followers);
                    $tache->titre = $tache->titre . ' pour ' . $direction->titre;
                    $tache->save();

                    if ($responsable) {
                        // dd($responsable);
                        $tache->agents()->attach($responsable, [
                            'type' => Direction::class,
                            'type_id' => $direction->id,
                        ]);


                        if ($responsable->id != Auth::user()->agent->id) {
                            event(new TacheCreated($tache, $responsable->id, "Une nouvelle tâche vous a été assignée par " . Auth::user()->agent->nom . " " . Auth::user()->agent->prenom . ", cliquez sur 'TRAITER' pour commencer le traitement"));
                        }

                         if ($secretaires->count()) {

                             $tache->agents()->attach($secretaires, [
                                 'type' => Direction::class,
                                 'type_id' => $direction->id,
                             ]);

                        // if (!empty($secretaires)) {
                        //     foreach ($secretaires as $secretaire) {
                        //         if ($secretaire && isset($secretaire->id)) {
                        //             $tache->agents()->attach($secretaire->id, [
                        //                 'type' => Direction::class,
                        //                 'type_id' => $direction->id,
                        //             ]);
                        //         }
                        //     }
                        

                            foreach ($secretaires as $secretaire) {
                                event(new TacheCreated($tache, $secretaire->id, 'Une nouvelle tâche a été assignée à votre Directeur'));
                            }
                        }

                        if (isset($request->input('objects')[$direction->id])) {
                            $objects = $request->input('objects')[$direction->id];
                            foreach ($objects as $object) {
                                if ($object) {
                                    TacheObjectif::create([
                                        'libelle' => $object,
                                        'tache_id' => $tache->id,
                                        'user_id' => Auth::user()->id,
                                        'statut' => 0,
                                        'agent_id' => $responsable->id,
                                    ]);
                                }
                            }
                        } else {
                            TacheObjectif::create([
                                'libelle' => $request->description ?? " ",
                                'tache_id' => $tache->id,
                                'user_id' => Auth::user()->id,
                                'statut' => 0,
                                'agent_id' => $responsable->id,
                            ]);
                        }
                    }
                }

            } elseif ($request->has('division_id')) {
                $divisions = Division::find($request->input('division_id'));
                foreach ($divisions as $division) {
                    $responsable = $division->responsable;
                    $followers->push($responsable);

                    if ($responsable) {
                        $tache = $this->createTache($request, $followers);
                        $tache->titre = $tache->titre . ' pour ' . $division->libelle;
                        $tache->save();
                        $tache->agents()->attach($responsable, [
                            'type' => Division::class,
                            'type_id' => $division->id,
                        ]);

                        event(new TacheCreated($tache, $responsable->id, "Une nouvelle tâche vous a été assignée par " . Auth::user()->agent->nom . " " . Auth::user()->agent->prenom . ", cliquez sur 'TRAITER' pour commencer le traitement"));

                        if (isset($request->input('objects')[$division->id])) {
                            $objects = $request->input('objects')[$division->id];
                            foreach ($objects as $object) {
                                if ($object) {
                                    TacheObjectif::create([
                                        'libelle' => $object,
                                        'tache_id' => $tache->id,
                                        'user_id' => Auth::user()->id,
                                        'statut' => 0,
                                        'agent_id' => $responsable->id,
                                    ]);
                                }
                            }
                        } else {
                            TacheObjectif::create([
                                'libelle' => $request->description ?? " ",
                                'tache_id' => $tache->id,
                                'user_id' => Auth::user()->id,
                                'statut' => 0,
                                'agent_id' => $responsable->id,
                            ]);
                        }
                    }
                }

            } elseif ($request->has('service_id')) {

                $services = Service::find($request->input('service_id'));

                foreach ($services as $service) {

                    $responsable = $service->responsable;
                    $followers->push($responsable);

                    if ($responsable) {
                        $tache = $this->createTache($request, $followers);
                        $tache->titre = $tache->titre . ' / ' . $service->titre;
                        $tache->save();
                        $tache->agents()->attach($responsable, [
                            'type' => Service::class,
                            'type_id' => $service->id,
                        ]);

                        event(new TacheCreated($tache, $responsable->id, "Une nouvelle tâche vous a été assignée par " . Auth::user()->agent->nom . " " . Auth::user()->agent->prenom . ", cliquez sur 'TRAITER' pour commencer le traitement"));

                        if (isset($request->input('objects')[$service->id])) {
                            $objects = $request->input('objects')[$service->id];
                            foreach ($objects as $object) {
                                if ($object) {
                                    TacheObjectif::create([
                                        'libelle' => $object,
                                        'tache_id' => $tache->id,
                                        'user_id' => Auth::user()->id,
                                        'statut' => 0,
                                        'agent_id' => $responsable->id,
                                    ]);
                                }
                            }
                        } else {
                            TacheObjectif::create([
                                'libelle' => $request->description ?? " ",
                                'tache_id' => $tache->id,
                                'user_id' => Auth::user()->id,
                                'statut' => 0,
                                'agent_id' => $responsable->id,
                            ]);
                        }
                    }
                }

            } elseif ($request->has('section_id')) {
                $sections = Section::find($request->input('section_id'));

                foreach ($sections as $section) {

                    $responsable = $section->responsable;
                    $followers->push($responsable);

                    if ($responsable) {
                        $tache = $this->createTache($request, $followers);
                        $tache->titre = $tache->titre . ' / ' . $section->titre;
                        $tache->save();
                        $tache->agents()->attach($responsable, [
                            'type' => Section::class,
                            'type_id' => $section->id,
                        ]);

                        event(new TacheCreated($tache, $responsable->id, "Une nouvelle tâche vous a été assignée par " . Auth::user()->agent->nom . " " . Auth::user()->agent->prenom . ", cliquez sur 'TRAITER' pour commencer le traitement"));

                        if (isset($request->input('objects')[$section->id])) {
                            $objects = $request->input('objects')[$section->id];
                            foreach ($objects as $object) {
                                if ($object) {
                                    TacheObjectif::create([
                                        'libelle' => $object,
                                        'tache_id' => $tache->id,
                                        'user_id' => Auth::user()->id,
                                        'statut' => 0,
                                        'agent_id' => $responsable->id,
                                    ]);
                                }
                            }
                        } else {
                            TacheObjectif::create([
                                'libelle' => $request->description ?? " ",
                                'tache_id' => $tache->id,
                                'user_id' => Auth::user()->id,
                                'statut' => 0,
                                'agent_id' => $responsable->id,
                            ]);
                        }
                    }
                }
            }

            if (!$request->has('direction_id') && !$request->has('division_id') && !$request->has('section_id') && !$request->has('service_id')) {
                $agents = Agent::find($request->input('agent_id'));

                foreach ($agents as $agent) {
                    $followers->push($agent);
                    if ($agent) {
                        $tache = $this->createTache($request, $followers);
                        $tache->agents()->attach($agent, [
                            'type' => Agent::class,
                            'type_id' => $agent->id,
                        ]);

                        event(new TacheCreated($tache, $agent, "Une nouvelle tâche vous a été assignée par " . Auth::user()->agent->nom . " " . Auth::user()->agent->prenom . ", cliquez sur 'TRAITER' pour commencer le traitement"));

                        if (isset($request->input('objects')[$agent->id])) {
                            $objects = $request->input('objects')[$agent->id];
                            foreach ($objects as $object) {
                                if ($object) {
                                    TacheObjectif::create([
                                        'libelle' => $object,
                                        'tache_id' => $tache->id,
                                        'user_id' => Auth::user()->id,
                                        'statut' => 0,
                                        'agent_id' => $agent->id,
                                    ]);
                                }
                            }
                        } else {
                            TacheObjectif::create([
                                'libelle' => $request->description ?? " ",
                                'tache_id' => $tache->id,
                                'user_id' => Auth::user()->id,
                                'statut' => 0,
                                'agent_id' => $agent->id,
                            ]);
                        }
                    }
                }
            }


            $content = json_encode([
                'name' => 'Gestion de tâches',
                'statut' => 'success',
                'message' => 'L\'ajout de la tâche a réussi avec succès !',
            ]);

        } catch (\Throwable $th) {
            // dd($th);
            $content = json_encode([
                'name' => 'Gestion de tâches',
                'statut' => 'error',
                'message' => 'L\'ajout de la tâche a échoué !',
            ]);
        }

        session()->flash(
            'session',
            $content
        );

        return redirect()->route('regidoc.taches.index');
    }

    public function show($id)
    {
        $tache = Tache::find($id);
        return view('regidoc.pages.taches.show-task')->with(['tache' => $tache]);
    }

    public function edit($id)
    {
        $tache = Tache::findOrFail($id);
        if ($tache->user_id == Auth::user()->id) {
            # code...
            $agents = Agent::select('id', 'nom', 'prenom')->get();
            $priorites = Priorite::select('id', 'titre')->get();
            return view('regidoc.pages.taches.edit-task', compact('tache', 'priorites', 'agents'));
        } else {
            # code...
            $content = json_encode([
                'name' => 'Gestion de tâches',
                'statut' => 'error',
                'message' => 'Accès non autorisé !',
            ]);
            session()->flash(
                'session',
                $content
            );
            return back();
        }

    }

    public function update(Request $request, $id)
    {
        $tache = Tache::find($id)->update([
            'titre' => $request->titre,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'priorite_id' => $request->priorite_id,
            'description' => $request->description,
        ]);
        if ($request->hasFile('documents')) {
            $classer = Classeur::where('direction_id', Auth::user()->agent?->direction_id)->where('titre', 'Classeur Tâches ' . Auth::user()->agent?->direction->titre)->first();
            if ($classer == null) {
                # code...
                $classer = Classeur::firstOrCreate(
                    [
                        'direction_id' => Auth::user()->agent?->direction_id,
                        'titre' => 'Classeur Tâches ' . Auth::user()->agent?->direction->titre,
                    ],
                    [
                        'reference' => Auth::user()->agent?->direction?->code,
                        'description' => 'Ce Classeur contient tous les documents liés à vos tâches',
                        'created_by' => Auth::user()->agent->id,
                        'updated_by' => Auth::user()->agent->id,
                    ]
                );
            }

            $dossier = Dossier::firstOrCreate(
                [
                    'classeur_id' => $classer->id,
                    'titre' => 'Taches',
                    'reference' => 'DIR' . Str::padLeft(Dossier::count() + 1, 4, 0),
                ],
                [
                    'description' => 'Dossier pour les documents de tâches',
                    'confidentiel' => 0,
                    'created_by' => Auth::user()->agent->id,
                    'updated_by' => Auth::user()->agent->id,
                ]
            );

            foreach ($request->file('documents') as $key => $doc) {

                $document = Document::create([
                    'dossier_id' => $dossier->id,
                    'libelle' => Str::beforeLast($doc->getClientOriginalName(), '.'),
                    'category_id' => 6,
                    'reference' => 'DT/' . Auth::user()->agent?->matricule,
                    'type' => 3,
                    'document' => (new File)->handle($doc, 'document', 'documents'),
                    'user_id' => Auth::user()->id,
                    'statut_id' => 1,
                    'created_by' => Auth::user()->agent->id,
                ]);

                ArchivePermission::create([
                    'agent_id' => Auth::user()->agent->id,
                    'permissionable_id' => $document->id,
                    'permissionable_type' => 'App\Models\Document',
                    'key' => 'view_document',
                ]);

                // $doc->move($path, $name . '.' . $ext);
                $tache->documents()->attach($document->id);
            }
        }
        if ($tache == 1) {
            $content = json_encode([
                'name' => 'Gestion de tâche',
                'statut' => 'success',
                'message' => 'Tâche modifiée avec succès !',
            ]);
        } else {
            $content = json_encode([
                'name' => 'Gestion de tâche',
                'statut' => 'error',
                'message' => "La modification de la tâche a échoué !",
            ]);
        }

        session()->flash(
            'session',
            $content
        );

        return redirect()->route('regidoc.taches.index');
    }

    public function destroy($id)
    {
        $tache = Tache::find($id);

        $agents = [];
        foreach ($tache->objectifs->sortByDesc('id')->unique('agent_id') as $obj) {
            $agents[] = $obj->agent_id;
        }
        // $tache->update([
        //     'statut_id' => '4',
        // ]);
        $tache->delete();

        event(new TacheCreated($tache, $agents, 'La Tâche ' . $tache->titre . ' a été supprimé par son auteur'));

        if ($tache) {
            $content = json_encode([
                'name' => 'Gestion de tâche',
                'statut' => 'success',
                'message' => 'Tâche supprimée avec succès !',
            ]);
        } else {
            $content = json_encode([
                'name' => 'Gestion de tâche',
                'statut' => 'error',
                'message' => 'La suppression de la tâche a échoué !',
            ]);
        }

        session()->flash(
            'session',
            $content
        );

        return back();
    }

    public function finish($id)
    {
        try {
            $tache = Tache::findOrFail($id);

            if ($tache->tache_statut_id == 3) {
                $tache->update([
                    'tache_statut_id' => '2',
                ]);
            } else {
                $tache->update([
                    'tache_statut_id' => '3',
                ]);
            }

            $documents = $tache->documents->map(function ($document) {
                $document->statut_id = 6;
                $document->save();
                return $document;
            });

            if (Auth::user()->agent->isDG()) {
                if ($tache->courrier) {
                    $courrier = $tache->courrier;
                    foreach ($tache->documents as $key => $document) {
                        if ($key > 0) {
                            $destinateurs = Direction::find(1)->dgSecretaires->pluck('responsable_id');

                            $doc = (new CourrierController)->createDocument(null, $destinateurs->first(), $document);
                            // $document->followers()

                            // I save traitement
                            $traitement = new CourrierTraitement();
                            $traitement->agent_id = Auth::user()->agent->id;
                            $traitement->note = '';
                            $traitement->document_url = $doc->document;
                            $traitement->save();

                            $courrier->traitements()->attach($traitement);
                        }
                    }
                    $courrier->document->statut_id = 6;
                    $courrier->document->save();

                    // (new CourrierController)->traitement($courrier);
                }
            }

            if ($tache->parent_id !== null) {
                // $tache->tacheParent->documents()->sync($documents);
                // $tache->tacheParent->documents()->attach($documents);
                // dd($tache->tacheParent->documents);
                foreach ($documents as $document) {
                    if (!in_array($document->id, $tache->tacheParent->documents->pluck('id')->toArray())) {
                        $tache->tacheParent->documents()->attach($document);
                    }
                }
            }

            $content = json_encode([
                'name' => 'Gestion de tâche',
                'statut' => 'success',
                'message' => 'La tâche a été marquée comme terminée !',
            ]);

        } catch (\Throwable $th) {
            dd($th);
            $content = json_encode([
                'name' => 'Gestion de tâches',
                'statut' => 'error',
                'message' => 'Opération echouée !' . $th->getMessage(),
            ]);
        }

        session()->flash(
            'session',
            $content
        );

        return redirect()->route('regidoc.taches.index');
    }

    public function remettreEncours($id)
    {
        try {
            $tache = Tache::findOrFail($id);

            if ($tache->tache_statut_id == 3) {
                $tache->update([
                    'tache_statut_id' => '2',
                ]);
            } else {
                $tache->update([
                    'tache_statut_id' => '3',
                ]);
            }

            $content = json_encode([
                'name' => 'Gestion de tâche',
                'statut' => 'success',
                'message' => 'La tâche a été marquée comme terminée !',
            ]);

            session()->flash(
                'session',
                $content
            );
        } catch (\Throwable $th) {
            // dd($th);
            $content = json_encode([
                'name' => 'Gestion de tâches',
                'statut' => 'error',
                'message' => 'L\'ajout de la tâche a échoué !',
            ]);
        }

        session()->flash(
            'session',
            $content
        );

        return redirect()->back();
    }

    public function createDocument($request, $document = null)
    {
        if ($document) {
            $doc = $document;
        }

        $classer = Classeur::firstOrCreate(
            [
                'direction_id' => Auth::user()->agent?->direction_id,
                'titre' => 'Taches ' . Auth::user()->agent?->direction->titre,
            ],
            [
                'reference' => 'CL/' . Str::padLeft(Classeur::count() + 1, 4, 0),
                'description' => 'Ce classeur contient les documents liés aux tâches',
                'created_by' => Auth::user()->agent->id,
                'updated_by' => Auth::user()->agent->id,
            ]
        );
        $dossier = Dossier::firstOrCreate(
            [
                'classeur_id' => $classer->id,
                'titre' => 'Taches',
            ],
            [
                'reference' => 'DT/' . Str::padLeft(Dossier::count() + 1, 4, 0),
                'description' => 'Dossier des documents liés aux tâches',
                'confidentiel' => 0,
                'created_by' => Auth::user()->agent->id,
                'updated_by' => Auth::user()->agent->id,
            ]
        );

        $document = Document::create([
            'dossier_id' => $dossier->id,
            'libelle' => $doc ? Str::beforeLast($doc->libelle, '.') : 'Document (signé)',
            'category_id' => 6,
            'reference' => 'DT/' . Str::padLeft(Document::count() + 1, 4, 0),
            'type' => 3,
            'document' => (new File)->handle($request, 'document', 'documents'),
            'user_id' => Auth::user()->id,
            'statut_id' => 1,
            'created_by' => Auth::user()->agent->id,
        ]);

        return $document;

    }

    public function saveSignature(Request $request)
    {
        // $filesPath = [];
        // $pdfFile = $request->file('document');
        // $path = 'documents/' . date('FY') . '/';
        // $filename = $this->generateFileName($pdfFile, $path);
        // $filename = $filename . '.' . $pdfFile->getClientOriginalExtension();

        // Storage::putFileAs('public/' . $path, $pdfFile, $filename);

        // array_push($filesPath, [
        //     'download_link' => $path . $filename,
        //     'original_name' => $pdfFile->getClientOriginalName(),
        // ]);

        $tache = Tache::find($request->tache_id);
        $document = null;

        if ($request->is_original) {
            $document = $this->createDocument($request, $tache->documents?->first());
            $tache->documents()->attach($document);
        } else {
            $document = Document::find($request->doc_id);
            $document->document = (new File)->handle($request, 'document', 'documents');
            $document->save();
        }

        Historique::create([
            "key" => "Signature",
            "historiquecable_id" => $request->tache_id,
            "historiquecable_type" => Tache::class,
            "description" => "A signé le document",
            "user_id" => Auth::user()->id,
        ]);

        $destinateursToNotify = $tache->agents->where('id', '!=', Auth::user()->agent->id);
        $document->followers()->sync($destinateursToNotify);

        // if (count($destinateursToNotify)) {
        //     event(new CourrierCreated($courrier, $destinateursToNotify, 'A signé le document du courrier'));
        // }

        // $tache = Tache::find($request->tache_id);
        // $doc = Document::find($request->doc_id);

        // if ($tache && $doc) {
        //     $document = $this->createDocument($request, $doc);
        //     $tache->documents()->attach($document->id);
        //     event(new TacheCreated($tache, $tache->user_id, 'Un nouveau fichié est attachée à la tâche !'));
        //     return response()->json(['file' => files($document->document)->link]);
        // }
        return response()->json(['file' => files($document->document)->link]);
    }

    public function generateFileName($file, $path)
    {
        $filename = Str::random(20);
        $ext = '';
        if (is_string($file)) {
            $ext = $file;
        } else {
            $ext = $file->getClientOriginalExtension();
        }

        // Make sure the filename does not exist, if it does, just regenerate
        while (Storage::disk('public')->exists($path . $filename . '.' . $ext)) {
            $filename = Str::random(20);
        }

        return $filename;
    }

    public function storefichier(Request $request)
    {
        // Validation des fichiers
        $request->validate([
            'fichiers' => 'required',
            'fichiers.*' => 'file|mimes:pdf,doc,docx,xlsx,xls|max:2048', // Limite de taille de 2MB
            'contrat_id' => 'required|exists:contrats,id',
            'user_id' => 'required|exists:users,id',
        ]);

        try {
            if ($request->hasfile('fichiers')) {
                foreach ($request->file('fichiers') as $file) {

                    // Générer un nom unique pour le fichier
                    $filename = 'doc_' . $request->contrat_id . '-' . $request->user_id . '-' . time() . '.' . $file->getClientOriginalExtension();

                    // Stocker le fichier dans le répertoire spécifié
                    $filePath = $file->storeAs('public/pdfs/documents', $filename);

                    // Enregistrer les détails du fichier dans la base de données
                    Fichier::create([
                        'libelle' => $file->getClientOriginalName(),
                        'autre_contrat_id' => $request->contrat_id,
                        'user_id' => $request->user_id,
                        'type' => $file->getClientOriginalExtension(),
                        'path' => $filename,
                    ]);
                }

                // Message de succès
                return redirect()->back()->with('success', 'Fichiers ajoutés avec succès !');
            } else {
                return redirect()->back()->with('error', 'Aucun fichier n\'a été téléchargé.');
            }

        } catch (\Exception $e) {
            // En cas d'erreur, on enregistre le message d'erreur dans les logs et on retourne un message d'erreur à l'utilisateur
            \Log::error($e->getMessage());
            return redirect()->back()->with('error', 'L\'ajout des fichiers a échoué. Veuillez réessayer.');
        }
    }
}
