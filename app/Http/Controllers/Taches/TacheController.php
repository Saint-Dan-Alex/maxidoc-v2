<?php

namespace App\Http\Controllers\Taches;

use App\Events\TacheCreated;
use App\Models\Fichier;
use App\Events\TacheConsulted;
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
use App\Models\TacheView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Http\Controllers\Courriers\CourrierController as CourrierController;
use App\Models\Historique;
use Illuminate\Support\Facades\Log;

class TacheController extends Controller
{
    /**
     * Construit une URL valide pour un document en utilisant la fonction files()
     * pour assurer la cohérence avec le reste de l'application
     *
     * @param mixed $documentPath Chemin du document depuis la base de données
     * @return string URL complète du document
     */
    public static function buildDocumentUrl($documentPath)
    {
        if (empty($documentPath)) {
            return '';
        }

        // Utiliser la fonction files() pour générer l'URL de manière cohérente
        $fileInfo = files($documentPath);
        
        // Si files() retourne une collection, prendre le premier élément
        if (is_object($fileInfo) && isset($fileInfo->link)) {
            return $fileInfo->link;
        }
        
        // Si c'est une collection, prendre le premier élément
        if (is_iterable($fileInfo) && $fileInfo->isNotEmpty()) {
            return $fileInfo->first()->link ?? '';
        }
        
        // Si on arrive ici, essayer de construire l'URL manuellement
        if (is_string($documentPath)) {
            // Si c'est déjà une URL complète, la retourner telle quelle
            if (Str::startsWith($documentPath, ['http://', 'https://', '/'])) {
                return $documentPath;
            }
            
            // Nettoyer le chemin
            $documentPath = ltrim($documentPath, '[\"\'');
            $documentPath = rtrim($documentPath, '\\\"\\]}');
            
            // Remplacer les antislashs par des slashs pour la cohérence
            $documentPath = str_replace('\\', '/', $documentPath);
            
            // Nettoyer les préfixes inutiles
            $documentPath = preg_replace('#^/+#', '', $documentPath);
            $documentPath = preg_replace('#^storage/#', '', $documentPath);
            
            // Construire l'URL complète
            return asset('storage/' . $documentPath);
        }
        
        return '';
    }
    public function index()
    {
        $user = Auth::user();
        
        if ($user->agent->isDG() || $user->agent->isDelegue()) {
            // Pour les DG et délégués, afficher toutes les tâches
            $taches = Tache::with(['agents', 'objectifs', 'tache_statut'])
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else {
            // Pour les autres utilisateurs, afficher leurs tâches assignées et celles qu'ils ont créées
            $tachesAssignees = Tache::whereHas('agents', function($query) use ($user) {
                    $query->where('agent_id', $user->agent->id)
                          ->where('type', 'App\\Models\\Agent')
                          ->where('type_id', $user->agent->id);
                })
                ->with(['agents', 'objectifs', 'tache_statut'])
                ->orderBy('created_at', 'desc')
                ->get();
                
            $tachesCreees = Tache::where('user_id', $user->id)
                ->with(['agents', 'objectifs', 'tache_statut'])
                ->orderBy('created_at', 'desc')
                ->get();
                
            // Fusionner et éliminer les doublons
            $taches = $tachesAssignees->merge($tachesCreees)->unique('id');
            
            // Convertir en paginate manuellement
            $taches = new \Illuminate\Pagination\LengthAwarePaginator(
                $taches->forPage(\Illuminate\Pagination\Paginator::resolveCurrentPage(), 10),
                $taches->count(),
                10,
                null,
                ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath()]
            );
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
                $tache->documents()->attach($newDoc->id, ['created_by' => Auth::id()]);
                $newDoc->followers()->attach($followers->pluck('id'));

                if ($newDoc->confidentiel) {
                    if (is_countable($followers)) {
                        $users = [];
                        foreach ($followers as $follower) {
                            if ($follower && $follower->user) {
                                $users[] = $follower->user;
                            }
                        }
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
            $tache->documents()->attach($newDoc->id, ['created_by' => Auth::id()]);

            $newDoc->followers()->attach($followers->pluck('id'));
            
            // Notifier les followers du document
            foreach ($followers as $follower) {
                if ($follower && $follower->user) {
                    event(new TacheCreated($tache, $follower->id, 'Un nouveau document a été attaché à la tâche : ' . $tache->titre));
                }
            }

            if ($newDoc->confidentiel) {
                if (is_countable($followers)) {
                    $users = [];
                    foreach ($followers as $follower) {
                        if ($follower && $follower->user) {
                            $users[] = $follower->user;
                        }
                    }
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

            $tache->documents()->attach($document->id, ['created_by' => Auth::id()]);

            $document->followers()->attach($followers);
            
            // Notifier les followers du nouveau document
            foreach ($followers as $follower) {
                if ($follower && $follower->user) {
                    event(new TacheCreated($tache, $follower->id, 'Un nouveau document a été créé et attaché à la tâche : ' . $tache->titre));
                }
            }
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

                $tache->documents()->attach($document->id, ['created_by' => Auth::id()]);
                foreach ($followers as $follower) {
                    $document->followers()->attach($follower);
                    // Notifier chaque follower du nouveau document
                    if ($follower && $follower->user) {
                        event(new TacheCreated($tache, $follower->id, 'Un nouveau document a été téléversé et attaché à la tâche : ' . $tache->titre));
                    }
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
                
                // Créer une seule tâche pour toutes les divisions
                $tache = $this->createTache($request, $followers);
                
                // Ajouter toutes les divisions à la tâche
                foreach ($divisions as $division) {
                    $responsable = $division->responsable;
                    $followers->push($responsable);
                    
                    // Mettre à jour le titre de la tâche pour inclure toutes les divisions
                    if (strpos($tache->titre, ' pour ') === false) {
                        $tache->titre = $tache->titre . ' pour ' . $division->titre;
                    } else {
                        $tache->titre = str_replace(' pour ', ', ', $tache->titre) . ', ' . $division->titre;
                    }
                    $tache->save();

                    if ($responsable) {
                        $tache->agents()->attach($responsable, [
                            'type' => Division::class,
                            'type_id' => $division->id,
                        ]);

                        // Créer les objectifs pour chaque division
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
                        
                        // Envoyer une notification à chaque responsable de division
                        if ($responsable->id != Auth::user()->agent->id) {
                            event(new TacheCreated($tache, $responsable->id, "Une nouvelle tâche vous a été assignée par " . Auth::user()->agent->nom . " " . Auth::user()->agent->prenom . ", cliquez sur 'TRAITER' pour commencer le traitement"));
                        }
                    }
                }
            } elseif ($request->has('service_id')) {

                $services = Service::find($request->input('service_id'));
                
                // Créer une seule tâche pour tous les services
                $tache = $this->createTache($request, $followers);
                
                // Ajouter tous les services à la tâche
                foreach ($services as $service) {
                    $responsable = $service->responsable;
                    $followers->push($responsable);
                    
                    // Mettre à jour le titre de la tâche pour inclure tous les services
                    if (strpos($tache->titre, ' / ') === false) {
                        $tache->titre = $tache->titre . ' / ' . $service->titre;
                    } else {
                        $tache->titre = str_replace(' / ', ', ', $tache->titre) . ', ' . $service->titre;
                    }
                    $tache->save();
                    
                    if ($responsable) {
                        $tache->agents()->attach($responsable, [
                            'type' => Service::class,
                            'type_id' => $service->id,
                        ]);

                        // Créer les objectifs pour chaque service
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
                        
                        // Envoyer une notification au responsable du service
                        event(new TacheCreated($tache, $responsable->id, "Une nouvelle tâche vous a été assignée par " . Auth::user()->agent->nom . " " . Auth::user()->agent->prenom . ", cliquez sur 'TRAITER' pour commencer le traitement"));
                    }
                    
                    // Envoyer une notification à chaque responsable de service
                    event(new TacheCreated($tache, $service->responsable, "Une nouvelle tâche vous a été assignée par " . Auth::user()->agent->nom . " " . Auth::user()->agent->prenom . ", cliquez sur 'TRAITER' pour commencer le traitement"));
                }
            } elseif ($request->has('section_id')) {
                $sections = Section::find($request->input('section_id'));
                
                // Créer une seule tâche pour toutes les sections
                $tache = $this->createTache($request, $followers);
                
                // Ajouter toutes les sections à la tâche
                foreach ($sections as $section) {
                    $followers->push($section->responsable);
                    $tache->agents()->attach($section->responsable, [
                        'type' => Section::class,
                        'type_id' => $section->id,
                    ]);

                    // Créer les objectifs pour chaque section
                    if (isset($request->input('objects')[$section->id])) {
                        $objects = $request->input('objects')[$section->id];
                        foreach ($objects as $object) {
                            if ($object) {
                                TacheObjectif::create([
                                    'libelle' => $object,
                                    'tache_id' => $tache->id,
                                    'user_id' => Auth::user()->id,
                                    'statut' => 0,
                                    'agent_id' => $section->responsable->id,
                                ]);
                            }
                        }
                    } else {
                        TacheObjectif::create([
                            'libelle' => $request->description ?? " ",
                            'tache_id' => $tache->id,
                            'user_id' => Auth::user()->id,
                            'statut' => 0,
                            'agent_id' => $section->responsable->id,
                        ]);
                    }
                    
                    // Envoyer une notification à chaque responsable de section
                    event(new TacheCreated($tache, $section->responsable, "Une nouvelle tâche vous a été assignée par " . Auth::user()->agent->nom . " " . Auth::user()->agent->prenom . ", cliquez sur 'TRAITER' pour commencer le traitement"));
                }
            }

            if (!$request->has('direction_id') && !$request->has('division_id') && !$request->has('section_id') && !$request->has('service_id')) {
                $agents = Agent::find($request->input('agent_id'));
                
                // Créer une seule tâche pour tous les participants
                $tache = $this->createTache($request, $agents);
                
                // Ajouter tous les participants à la tâche
                foreach ($agents as $agent) {
                    $followers->push($agent);
                    if ($agent) {
                        $tache->agents()->attach($agent, [
                            'type' => Agent::class,
                            'type_id' => $agent->id,
                        ]);

                        // Créer les objectifs pour chaque participant
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
                        
                        // Envoyer une notification à chaque participant
                        event(new TacheCreated($tache, $agent, "Une nouvelle tâche vous a été assignée par " . Auth::user()->agent->nom . " " . Auth::user()->agent->prenom . ", cliquez sur 'TRAITER' pour commencer le traitement"));
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
        $tache = Tache::with(['documents', 'objectifs.agent'])->find($id);
        $documents = $tache->documents ?? collect();
        
        // Vérifier si c'est la première consultation de la tâche par l'utilisateur
        $view = TacheView::firstOrNew([
            'tache_id' => $tache->id,
            'user_id' => auth()->id(),
            'agent_id' => auth()->user()->agent->id
        ]);

        // Si c'est une nouvelle vue
        if (!$view->exists) {
            $view->is_first_view = true;
            $view->save();
            
            // Récupérer tous les agents concernés par la tâche
            $agentsConcernes = collect();
            
            // Ajouter le créateur de la tâche
            if ($tache->user && $tache->user->agent) {
                $agentsConcernes->push($tache->user->agent);
            }
            
            // Ajouter les agents assignés aux objectifs
            foreach ($tache->objectifs as $objectif) {
                if ($objectif->agent && !$agentsConcernes->contains('id', $objectif->agent->id)) {
                    $agentsConcernes->push($objectif->agent);
                }
            }
            
            // Déclencher l'événement de consultation
            if ($agentsConcernes->isNotEmpty()) {
                event(new TacheConsulted(
                    $tache,
                    auth()->user()->agent,
                    $agentsConcernes
                ));
            }
        } else if ($view->is_first_view) {
            // Mettre à jour la vue existante
            $view->is_first_view = false;
            $view->viewed_at = now();
            $view->save();
        }
        
        // Préparer les URLs des documents
        $documents->each(function($document) {
            $document->document_url = self::buildDocumentUrl($document->document);
        });
        
        return view('regidoc.pages.taches.show-task', compact('tache', 'documents'));
    }

    // public function edit($id)
    // {
    //     $tache = Tache::findOrFail($id);
    //     if ($tache->user_id == Auth::user()->id) {
    //         # code...
    //         $agents = Agent::select('id', 'nom', 'prenom')->get();
    //         $priorites = Priorite::select('id', 'titre')->get();
    //         return view('regidoc.pages.taches.edit-task', compact('tache', 'priorites', 'agents'));
    //     } else {
    //         # code...
    //         $content = json_encode([
    //             'name' => 'Gestion de tâches',
    //             'statut' => 'error',
    //             'message' => 'Accès non autorisé !',
    //         ]);
    //         session()->flash(
    //             'session',
    //             $content
    //         );
    //         return back();
    //     }

    // }
    public function edit(Request $request, $id)
    {
        // Charger la tâche AVEC les agents liés (avec pivots)
        $tache = Tache::with('agents')->findOrFail($id);

        // Vérification d'autorisation
        if ($tache->user_id != Auth::user()->id) {
            session()->flash('session', json_encode([
                'name' => 'Gestion de tâches',
                'statut' => 'error',
                'message' => 'Accès non autorisé !',
            ]));
            return back();
        }

        // Initialisation du tableau de données avec valeurs par défaut
        $data = [
            'tache' => $tache,
            'agents' => collect(),
            'directions' => collect(),
            'services' => collect(),
            'sections' => collect(),
            'priorites' => Priorite::select('id', 'titre')->get(),
            'to' => null,
            'isNewdoc' => false,
            'document' => null,
            'isSubTask' => false,
        ];

        // Cas Directeur Général
        if (Auth::user()->agent->isDG()) {
            if ($request->to === "direction") {
                $data['directions'] = Direction::where('id', '!=', Auth::user()->agent->direction_id)->get();
                $data['to'] = 'direction';
            } elseif ($request->to === "agent") {
                $data['agents'] = Agent::select('id', 'nom', 'prenom')
                    ->where('id', '!=', Auth::id())
                    ->get();
                $data['to'] = 'agent';
            } else {
                $data['directions'] = Direction::where('id', '!=', Auth::user()->agent->direction_id)->get();
            }
        } else {
            // Cas utilisateur normal
            $data['agents'] = Agent::select('id', 'nom', 'prenom')
                ->where('id', '!=', Auth::id())
                ->where('direction_id', Auth::user()->agent->direction_id)
                ->get();
        }

        // Récupération des services et sections si nécessaires
        $data['services'] = Service::all();
        $data['sections'] = Section::all();

        // Cas nouveau document attaché temporairement
        if ($request->newdoc == 1 && $request->textSelected && $request->fileName) {
            $fileName = $request->fileName;
            $text = $request->textSelected;
            $name = $text . date('_dmYHi') . '.pdf';

            $data['isNewdoc'] = true;
            $data['docname'] = $name;
            $data['filename'] = $fileName;
            $data['dossiername'] = $text;
        }

        // Cas document lié existant
        if ($request->doc != null) {
            $document = Document::findOrFail((int) $request->doc);
            $data['document'] = $document;
        }

        // Cas sous-tâche
        if ($request->parent_id != null) {
            $data['isSubTask'] = true;
            $data['tacheParent'] = Tache::findOrFail($request->parent_id);
        }

        // Cas courrier lié
        if ($request->courrier_id != null) {
            $data['courrier_id'] = $request->courrier_id;
        }

        return view('regidoc.pages.taches.edit-task', $data);
    }

    // public function update(Request $request, $id)
    // {
    //     $tache = Tache::find($id)->update([
    //         'titre' => $request->titre,
    //         'date_debut' => $request->date_debut,
    //         'date_fin' => $request->date_fin,
    //         'priorite_id' => $request->priorite_id,
    //         'description' => $request->description,
    //     ]);
    //     if ($request->hasFile('documents')) {
    //         $classer = Classeur::where('direction_id', Auth::user()->agent?->direction_id)->where('titre', 'Classeur Tâches ' . Auth::user()->agent?->direction->titre)->first();
    //         if ($classer == null) {
    //             # code...
    //             $classer = Classeur::firstOrCreate(
    //                 [
    //                     'direction_id' => Auth::user()->agent?->direction_id,
    //                     'titre' => 'Classeur Tâches ' . Auth::user()->agent?->direction->titre,
    //                 ],
    //                 [
    //                     'reference' => Auth::user()->agent?->direction?->code,
    //                     'description' => 'Ce Classeur contient tous les documents liés à vos tâches',
    //                     'created_by' => Auth::user()->agent->id,
    //                     'updated_by' => Auth::user()->agent->id,
    //                 ]
    //             );
    //         }

    //         $dossier = Dossier::firstOrCreate(
    //             [
    //                 'classeur_id' => $classer->id,
    //                 'titre' => 'Taches',
    //                 'reference' => 'DIR' . Str::padLeft(Dossier::count() + 1, 4, 0),
    //             ],
    //             [
    //                 'description' => 'Dossier pour les documents de tâches',
    //                 'confidentiel' => 0,
    //                 'created_by' => Auth::user()->agent->id,
    //                 'updated_by' => Auth::user()->agent->id,
    //             ]
    //         );

    //         foreach ($request->file('documents') as $key => $doc) {

    //             $document = Document::create([
    //                 'dossier_id' => $dossier->id,
    //                 'libelle' => Str::beforeLast($doc->getClientOriginalName(), '.'),
    //                 'category_id' => 6,
    //                 'reference' => 'DT/' . Auth::user()->agent?->matricule,
    //                 'type' => 3,
    //                 'document' => (new File)->handle($doc, 'document', 'documents'),
    //                 'user_id' => Auth::user()->id,
    //                 'statut_id' => 1,
    //                 'created_by' => Auth::user()->agent->id,
    //             ]);

    //             ArchivePermission::create([
    //                 'agent_id' => Auth::user()->agent->id,
    //                 'permissionable_id' => $document->id,
    //                 'permissionable_type' => 'App\Models\Document',
    //                 'key' => 'view_document',
    //             ]);

    //             // $doc->move($path, $name . '.' . $ext);
    //             $tache->documents()->attach($document->id);
    //         }
    //     }
    //     if ($tache == 1) {
    //         $content = json_encode([
    //             'name' => 'Gestion de tâche',
    //             'statut' => 'success',
    //             'message' => 'Tâche modifiée avec succès !',
    //         ]);
    //     } else {
    //         $content = json_encode([
    //             'name' => 'Gestion de tâche',
    //             'statut' => 'error',
    //             'message' => "La modification de la tâche a échoué !",
    //         ]);
    //     }

    //     session()->flash(
    //         'session',
    //         $content
    //     );

    //     return redirect()->route('regidoc.taches.index');
    // }

        public function update(Request $request, $id)
    {
        $tache = Tache::find($id);

        if (!$tache) {
            session()->flash('session', json_encode([
                'name' => 'Gestion de tâche',
                'statut' => 'error',
                'message' => "Tâche introuvable !",
            ]));
            return redirect()->route('regidoc.taches.index');
        }

        // Mettre à jour la tâche
        $updated = $tache->update([
            'titre' => $request->titre,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'priorite_id' => $request->priorite_id,
            'description' => $request->description,
        ]);

        if ($request->hasFile('documents')) {
            $agent = Auth::user()->agent;

            // Sécurité : vérifier que agent et direction existent
            if (!$agent || !$agent->direction) {
                session()->flash('session', json_encode([
                    'name' => 'Gestion de tâche',
                    'statut' => 'error',
                    'message' => "Agent ou direction introuvable pour l'utilisateur connecté.",
                ]));
                return redirect()->route('regidoc.taches.index');
            }

            $directionId = $agent->direction_id;
            $directionTitre = $agent->direction->titre;
            $directionCode = $agent->direction->code ?? 'UNKNOWN_CODE';

            // Récupérer ou créer le classeur
            $classer = Classeur::where('direction_id', $directionId)
                ->where('titre', 'Classeur Tâches ' . $directionTitre)
                ->first();

            if ($classer == null) {
                $classer = Classeur::firstOrCreate(
                    [
                        'direction_id' => $directionId,
                        'titre' => 'Classeur Tâches ' . $directionTitre,
                    ],
                    [
                        'reference' => $directionCode,
                        'description' => 'Ce Classeur contient tous les documents liés à vos tâches',
                        'created_by' => $agent->id,
                        'updated_by' => $agent->id,
                    ]
                );
            }

            // Récupérer ou créer le dossier
            $dossier = Dossier::firstOrCreate(
                [
                    'classeur_id' => $classer->id,
                    'titre' => 'Taches',
                    // Si tu veux, on peut changer la référence en quelque chose de plus cohérent
                    'reference' => 'DIR' . Str::padLeft(Dossier::count() + 1, 4, '0'),
                ],
                [
                    'description' => 'Dossier pour les documents de tâches',
                    'confidentiel' => 0,
                    'created_by' => $agent->id,
                    'updated_by' => $agent->id,
                ]
            );

            // Parcourir les fichiers et les enregistrer
            foreach ($request->file('documents') as $doc) {
                $document = Document::create([
                    'dossier_id' => $dossier->id,
                    'libelle' => Str::beforeLast($doc->getClientOriginalName(), '.'),
                    'category_id' => 6,
                    'reference' => 'DT/' . $agent->matricule,
                    'type' => 3,
                    'document' => (new File)->handle($doc, 'document', 'documents'),
                    'user_id' => Auth::user()->id,
                    'statut_id' => 1,
                    'created_by' => $agent->id,
                ]);

                ArchivePermission::create([
                    'agent_id' => $agent->id,
                    'permissionable_id' => $document->id,
                    'permissionable_type' => 'App\Models\Document',
                    'key' => 'view_document',
                ]);

                // Attacher le document à la tâche (relation many-to-many)
                $tache->documents()->attach($document->id, ['created_by' => Auth::id()]);
            }
        }

        if ($updated) {
            // Récupérer tous les agents assignés à cette tâche
            $agents = $tache->agents()->get();
            
            $userName = Auth::user()->agent->nom . ' ' . Auth::user()->agent->prenom;
            $message = "Mise à jour effectuée par $userName sur la tâche " ;
            
            // Envoyer une notification à chaque agent assigné
            foreach ($agents as $agent) {
                if ($agent->id != Auth::user()->agent->id) {
                    event(new TacheCreated($tache, $agent->id, $message));
                }
            }
            
            // Enregistrer dans l'historique
            Historique::create([
                'action' => 'Mise à jour de la tâche',
                'description' => $message,
                'user_id' => Auth::id(),
                'entity_type' => Tache::class,
                'entity_id' => $tache->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
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

        session()->flash('session', $content);

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
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'L\'ajout des fichiers a échoué. Veuillez réessayer.');
        }
    }
}
