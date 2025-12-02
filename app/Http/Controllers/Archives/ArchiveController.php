<?php

namespace App\Http\Controllers\Archives;

use App\Http\Controllers\Controller;
use App\Models\Classeur;
use App\Models\Document;
use App\Models\DocumentArchivage;
use App\Models\Dossier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Agent;
use App\Models\Service;
use App\Models\CourrierType;
use App\Models\CourrierNature;
use App\Models\CourrierCategory;
use App\Models\Direction;
use App\Http\Controllers\File;
use App\Http\Controllers\ScanFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Courrier;
use App\Models\Historique;
use App\Models\Priorite;
use App\Models\Statut;  
use App\Models\User; 
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use Illuminate\Support\Arr;
use App\Events\DocumentCreated;
use Carbon\Carbon;

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
    public function create(Request $request)
    {
        $types = CourrierType::all();
    $services = Service::all();
    $agents = Agent::actif()->select('id','user_id','direction_id','nom','post_nom','prenom','division_id','service_id','fonction_id')->get();
    $natures = CourrierNature::select('id', 'titre')->get();
    $sec = Direction::find(1)->dgSecretaires->pluck('responsable_id');
    $isDestinateur = $sec->contains(auth()->id());

    // Variables communes
    $viewData = [
        'types' => $types,
        'services' => $services,
        'agents' => $agents,
        'natures' => $natures,
        'sec' => $sec,
        'isDestinateur' => $isDestinateur,
    ];

    // Si newdoc est présent, ajoute les champs supplémentaires
    if ($request->has('newdoc')) {
        $viewData['newDoc'] = $request->newdoc;
        $viewData['textSelected'] = $request->textSelected;
        $viewData['fileName'] = $request->fileName;
    }

    // return view('regidoc.pages.courriers.new-doc', $viewData);
        return view('regidoc.pages.archives.create',$viewData);
    }

    public function createDocument($request, $destinateur, $doc = null) 
    {
        // 1. Création ou récupération du classeur
        $classeur = Classeur::firstOrCreate(
            ['titre' => Auth::user()->agent->direction?->lieu?->titre ?? 'Region inconnu'], 
            [
                'reference' => 'DIR/' . Str::padLeft(Classeur::count() + 1, 4, '0'),
                'direction_id' => Agent::find($destinateur)?->direction_id,
                'created_by' => Auth::user()->agent->id
            ]
        );

        // 2. Création ou récupération du dossier du service
        $service = Auth::user()->agent->service;
        $serviceDossier = Dossier::firstOrCreate(
            [
                'titre' => $service ? $service->titre : 'Sans service', 
                'classeur_id' => $classeur->id,
                'parent_id' => null
            ], 
            [
                'reference' => 'SVC/' . Str::padLeft(Classeur::count() + 1, 4, '0'),
                'created_by' => Auth::user()->agent->id,
                'updated_by' => Auth::user()->agent->id,
                'description' => $service ? 'Dossier du service ' . $service->nom : 'Dossier par défaut',
            ]
        );

        // 3. Création ou récupération du dossier de catégorie
        $categorie = CourrierCategory::find($request->get('categorie'));
        $categorieDossier = Dossier::firstOrCreate(
            [
                'titre' => $categorie ? $categorie->title : 'Sans catégorie',
                'classeur_id' => $classeur->id,
                'parent_id' => $serviceDossier->id
            ],
            [
                'reference' => 'CAT/' . Str::padLeft(Dossier::count() + 1, 4, '0'),
                'created_by' => Auth::user()->agent->id,
                'updated_by' => Auth::user()->agent->id,
                'description' => $categorie ? 'Dossier de la catégorie ' . $categorie->title : 'Catégorie non spécifiée',
            ]
        );

        // 4. Création ou récupération du dossier de nature
        $nature = CourrierNature::find($request->get('nature'));
        $dossier = Dossier::firstOrCreate(
            [
                'titre' => $nature ? $nature->titre : 'Sans nature',
                'classeur_id' => $classeur->id,
                'parent_id' => $categorieDossier->id
            ],
            [
                'reference' => 'NAT/' . Str::padLeft(Dossier::count() + 1, 4, '0'),
                'created_by' => Auth::user()->agent->id,
                'updated_by' => Auth::user()->agent->id,
                'description' => $nature ? 'Dossier de la nature ' . $nature->titre : 'Nature non spécifiée',
            ]
        );

        // 3. Si pas de document existant passé en paramètre
        if ($doc == null) {

            // Cas où c'est un scan ou un document déjà sélectionné
            if (($request?->is_scan ?? false) == "true" || ($request?->has('selected_doc') && !empty($request->selected_doc))) {

                $document = new Document();
                $document->dossier_id = $dossier->id;
                $document->reference = is_array($request->get('ref')) ? implode(', ', $request->get('ref')) : $request->get('ref');
                $document->reference_interne = $request->get('ref_interne');
                $document->category_id = $request->get('categorie');
                $document->libelle = $request->get('title');
                $document->type = $request->get('type');
                $document->nature_id = $request->get('nature');
                $document->priorite_id = $request->get('priorite');
                $document->date_du_courrier = $request->get('date-doc');
                $document->date_arrive = $request->get('date-arriv');
                $document->description = $request->get('objet');

                if (($request->is_scan ?? false) == "true") {
                    try {
                        // Récupérer le nom du fichier scanné s'il existe
                        $scannedFileName = $request->get('scanned_file_name');
                        
                        Log::info('📄 Traitement du fichier scanné pour archivage', [
                            'scanned_file_name' => $scannedFileName
                        ]);
                        
                        $scanResult = (new ScanFile())->handle('documents', null, $scannedFileName);
                        if (empty($scanResult)) {
                            throw new \Exception('Le scan n\'a pas retourné de fichier valide');
                        }
                        $document->document = $scanResult;
                    } catch (\Exception $e) {
                        Log::error('Erreur lors du scan du document d\'archivage', [
                            'error' => $e->getMessage(),
                            'trace' => $e->getTraceAsString()
                        ]);
                        throw new \Exception('Erreur lors du scan du document : ' . $e->getMessage());
                    }
                } else {
                    // Déplacer un fichier sélectionné déjà uploadé en temporaire
                    $document->document = $this->moveCreatedDoc($request->selected_doc);
                }

                $document->user_id = Auth::user()->id;
                $document->statut_id = 6;
                $document->created_by = Auth::user()->agent->id;
                $document->save();

                return $document;
            }

            // Cas d'un upload via formulaire (input file)
            if ($request->hasFile('document') && (empty($request->document_id))) {

                $document = new Document();
                $document->dossier_id = $dossier->id;
                $document->reference = $request->get('ref');
                $document->reference_interne = $request->get('ref_interne');
                $document->category_id = $request->get('categorie');
                $document->libelle = $request->get('title');
                $document->type = $request->get('type');
                $document->nature_id = $request->get('nature');
                $document->priorite_id = $request->get('priorite');
                $document->date_du_courrier = $request->get('date-doc');
                $document->date_arrive = $request->get('date-arriv');
                $document->description = $request->get('objet');

                $document->emetteur = $request->get('expediteur_externe');
                $document->destination_id = $request->get('destination');
                $document->observations = $request->get('observations');                
                $document->redacteur_id = $request->get('redacteur');
                $document->redacteur_id = $request->get('redacteur');
                $document->lieu_id = Auth::user()->agent->lieu_id;
                $document->service_id = Auth::user()->agent->service_id;


                // Utilisation de la classe File pour stocker le fichier
                $document->document = (new File())->handle($request, 'document', 'documents');

                $document->user_id = Auth::user()->id;
                $document->statut_id = 6;
                $document->created_by = Auth::user()->agent->id;
                $document->save();

                return $document;
            } 
            
            // Cas où on utilise un document existant via son ID
            elseif ($request->has('document_id') && !empty($request->document_id)) {
                return Document::find($request->document_id);
            }

        } else {
            // Cas où on crée un nouveau document à partir d'un autre objet $doc existant
            $document = Document::create([
                'dossier_id' => $dossier->id,
                'reference' => is_array($doc->reference) ? implode(', ', $doc->reference) . '/R' : $doc->reference . '/R',
                'category_id' => $doc->category_id,
                'libelle' => $doc->libelle,
                'type' => $doc->type,
                'document' => $doc->document ?? (new File())->handle($request, 'document', 'documents'),
                'user_id' => Auth::user()->id,
                'statut_id' => 6,
                'created_by' => Auth::user()->agent->id,
            ]);

            return $document;
        }

        // Si aucune des conditions ci-dessus n'est remplie (ex: pas de fichier), 
        // on crée quand même un document avec les métadonnées.
        $document = new Document();
        $document->dossier_id = $dossier->id;
        $document->reference = $request->get('ref');
        $document->reference_interne = $request->get('ref_interne');
        $document->category_id = $request->get('categorie');
        $document->libelle = $request->get('title');
        $document->type = $request->get('type');
        $document->nature_id = $request->get('nature');
        $document->priorite_id = $request->get('priorite');
        $document->date_du_courrier = $request->get('date-doc');
        $document->date_arrive = $request->get('date-arriv');
        $document->description = $request->get('objet');
        $document->redacteur = $request->get('redacteur');
        $document->emetteur = $request->get('expediteur_externe');
        $document->destination = $request->get('destination');
        $document->observations = $request->get('observations');
        $document->user_id = Auth::user()->id;
        $document->statut_id = 6; // Statut 'Archivé' ou autre à définir
        $document->created_by = Auth::user()->agent->id;
        $document->save();

        return $document;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        try {
            // 1. Création du document via la méthode existante
            // Le destinataire est l'utilisateur authentifié par défaut pour un archivage
            $document = $this->createDocument($request, Auth::user()->agent->id);

            if (!$document) {
                 throw new \Exception('La création du document a échoué.');
            }

            // Génération de la référence interne basée sur la date du document (date_du_courrier)
            $docDate = $document->date_du_courrier ?? $request->input('date-doc') ?? $document->date_arrive ?? now();
            $year = Carbon::parse($docDate)->year;
            $prefix = sprintf('Arc-%d-', $year);
            $lastRef = Document::where('reference_interne', 'like', $prefix . '%')
                ->orderBy('reference_interne', 'desc')
                ->value('reference_interne');
            $next = 1;
            if ($lastRef) {
                $lastSeq = (int) substr($lastRef, -8);
                $next = $lastSeq + 1;
            }
            $document->reference_interne = $prefix . str_pad((string) $next, 8, '0', STR_PAD_LEFT);

            // 2. Mettre à jour le document avec les informations d'archivage
            $document->archived_at = $request->input('date-arriv', now());
            $document->confidentiel = $request->has('confidentiel');
            // Vous pouvez ajouter ici d'autres champs du modèle Document à mettre à jour
            // Exemple: $document->reference = $request->input('ref_interne');
            $document->save();

            // 3. Création de l'historique
            Historique::create([
                "key" => "Archivage de document",
                "historiquecable_id" => $document->id,
                "historiquecable_type" => Document::class,
                "description" => "A archivé un document",
                "user_id" => Auth::user()->id,
            ]);

            // 4. Préparation du message de succès
            $content = json_encode([
                'name' => 'Archive',
                'statut' => 'success',
                'message' => 'Document archivé avec succès !',
            ]);

        } catch (\Throwable $th) {
            Log::error("Erreur lors de l'archivage : " . $th->getMessage(), [
                'file' => $th->getFile(),
                'line' => $th->getLine(),
                'trace' => $th->getTraceAsString(),
            ]);

            $content = json_encode([
                'name' => 'Archive',
                'statut' => 'error',
                'message' => 'Impossible d\'archiver le document, une erreur s\'est produite.',
            ]);
        }

        // 5. Redirection avec le message flash
        session()->flash('session', $content);
        if (isset($document) && $document) {
            return redirect()->route('regidoc.archive-classeurs.archive-dossiers.show', [
                'archive_classeur' => $document->dossier->classeur_id,
                'archive_dossier' => $document->dossier_id,
            ]);
        }
        return redirect()->route('regidoc.archivages.index');
    }

    /**
     * Traite un fichier PDF scanné et le stocke dans le dossier temporaire
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function scan(Request $request)
    {
        // Log ultra-détaillé pour déboguer Asprise Scanner
        Log::info('🔍 scan() appelée', [
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'has_file_pdf' => $request->hasFile('pdf'),
            'all_files' => array_keys($request->allFiles()),
            'content_type' => $request->header('Content-Type'),
            'content_length' => $request->header('Content-Length'),
        ]);

        try {
            // Vérifier qu'un fichier a été envoyé
            $file = null;
            if ($request->hasFile('pdf')) {
                $file = $request->file('pdf');
            } elseif (count($request->allFiles()) > 0) {
                $file = Arr::first($request->allFiles());
            }

            if (!$file || !$file->isValid()) {
                 Log::warning('❌ Scan: Aucun fichier reçu ou fichier invalide');
                return response()->json([
                    'success' => false,
                    'message' => 'Aucun fichier PDF n\'a été envoyé ou le fichier est invalide.'
                ], 400);
            }
            
            // Vérifier que le fichier est un PDF
            $extension = strtolower($file->getClientOriginalExtension());
            if ($extension !== 'pdf') {
                return response()->json([
                    'success' => false,
                    'message' => 'Le fichier doit être au format PDF.'
                ], 400);
            }

            // Créer un nom de fichier unique
            $fileName = 'scan_' . uniqid() . '.pdf';
            $relativePath = 'tmp_scanne';
            
            // LOGIQUE INSPIRÉE DE uploadPieceJointe POUR HOSTINGER
            $fullPath = '';
            
            if (config('app.env') === 'production') {
                // Sur Hostinger, DOCUMENT_ROOT pointe vers public_html
                $documentRoot = $_SERVER['DOCUMENT_ROOT'];
                
                // Si le chemin contient /public, le remplacer par /public_html si nécessaire
                if (strpos($documentRoot, '/public') !== false && strpos($documentRoot, '/public_html') === false) {
                    $documentRoot = str_replace('/public', '/public_html', $documentRoot);
                }
                
                $basePath = $documentRoot . '/storage';
                
                // Créer le dossier storage s'il n'existe pas
                if (!file_exists($basePath)) {
                    @mkdir($basePath, 0755, true);
                }
                
                $fullPath = $basePath . '/' . $relativePath;
            } else {
                // En local
                $fullPath = storage_path('app/public/' . $relativePath);
            }

            // Créer le dossier s'il n'existe pas
            if (!file_exists($fullPath)) {
                // Essayer de créer avec error suppression pour capturer l'erreur
                set_error_handler(function($errno, $errstr) {
                    throw new \Exception("Erreur mkdir: $errstr");
                });
                
                try {
                    mkdir($fullPath, 0755, true);
                    restore_error_handler();
                } catch (\Exception $e) {
                    restore_error_handler();
                    Log::error('Erreur création dossier scan', ['path' => $fullPath, 'error' => $e->getMessage()]);
                    // On continue, peut-être qu'il existe déjà ou qu'on a un problème de droits
                }
            }
            
            Log::info('💾 Tentative de stockage (méthode manuelle)', [
                'full_path' => $fullPath,
                'filename' => $fileName,
                'env' => config('app.env')
            ]);

            // Déplacer le fichier manuellement
            $targetFile = $fullPath . '/' . $fileName;
            
            // On utilise move() de l'objet UploadedFile qui gère proprement le déplacement
            try {
                $file->move($fullPath, $fileName);
                Log::info('✅ Fichier déplacé avec succès', ['target' => $targetFile]);
            } catch (\Exception $e) {
                Log::error('❌ Erreur move()', ['error' => $e->getMessage()]);
                throw new \Exception("Impossible de déplacer le fichier: " . $e->getMessage());
            }

            // Vérification
            if (!file_exists($targetFile)) {
                throw new \Exception('Le fichier semble avoir été enregistré mais est introuvable à: ' . $targetFile);
            }
            
            $fileNameWithoutExt = pathinfo($fileName, PATHINFO_FILENAME);
            
            // IMPORTANT: Retourner le JSON avec les bonnes données
            $response = [
                'success' => true,
                'message' => 'Fichier PDF téléchargé avec succès',
                'file_name' => $fileNameWithoutExt
            ];
            
            return response()->json($response, 200, [], JSON_UNESCAPED_SLASHES);
            
        } catch (\Exception $e) {
            Log::error('❌ Exception dans scan()', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue: ' . $e->getMessage()
            ], 500);
        }
    }

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