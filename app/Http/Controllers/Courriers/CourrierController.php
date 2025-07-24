<?php

namespace App\Http\Controllers\Courriers;

use App\Events\CourrierCreated;
use App\Http\Controllers\Controller;
use App\Http\Controllers\File;
use App\Http\Controllers\ScanFile;
use App\Models\Agent;
use App\Models\Classeur;
use App\Models\Courrier;
use App\Models\CourrierNature;
use App\Models\CourriersAnnotation;
use App\Models\CourrierTraitement;
use App\Models\CourrierType;
use App\Models\CourrierTypesTraitement;
use App\Models\CourrierCategory;
use App\Models\Departement;
use App\Models\Direction;
use App\Models\Document;
use App\Models\Dossier;
use App\Models\Historique;
use App\Models\Priorite;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Nette\Utils\Random;
use App\Mail\DocumentPasswordMail;
use App\Models\CourrierDestinateurExterne;
use Illuminate\Support\Collection;

use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class CourrierController extends Controller
{
    use SoftDeletes;

    /**
     * Handle the initial document upload for incoming mail
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
 
    public function uploadInitial(Request $request)
{
    try {
        // Vérification de l'authentification
        if (!Auth::check()) {
            return $request->expectsJson()
                ? response()->json([
                    'success' => false,
                    'message' => 'Utilisateur non authentifié',
                ], 401)
                : redirect()->route('login')->with('error', 'Utilisateur non authentifié');
        }

        $user = Auth::user();

        // Vérifier que l'utilisateur a un agent associé
        if (!$user->agent) {
            return $request->expectsJson()
                ? response()->json([
                    'success' => false,
                    'message' => 'Aucun agent associé à cet utilisateur',
                ], 400)
                : redirect()->back()->with('error', 'Aucun agent associé à cet utilisateur');
        }

        // Validation de la requête
        $request->validate([
            'document' => 'required|file|mimes:pdf|max:10240', // 10MB max
            'type' => 'required|in:1', // Uniquement type 1 pour courrier entrant
        ]);

        // Récupération des assistants du DG
        $direction = Direction::find(1);
        if (!$direction || !$direction->assistanats) {
            $message = 'Aucune direction ou assistanats trouvés';
            return $request->expectsJson()
                ? response()->json(['success' => false, 'message' => $message], 400)
                : redirect()->back()->with('error', $message);
        }

        $assistantsDG = $direction->assistanats->map(function ($assistant) {
            return $assistant->responsable;
        })->filter();

        if ($assistantsDG->isEmpty()) {
            $message = 'Aucun assistant du DG trouvé';
            return $request->expectsJson()
                ? response()->json(['success' => false, 'message' => $message], 400)
                : redirect()->back()->with('error', $message);
        }

        $premierAssistant = $assistantsDG->first();
        if (!$premierAssistant || !$premierAssistant->id) {
            $message = 'Assistant du DG invalide';
            return $request->expectsJson()
                ? response()->json(['success' => false, 'message' => $message], 400)
                : redirect()->back()->with('error', $message);
        }

        // Création du document
        $document = $this->createDocument($request, $premierAssistant->id);
        if (!$document) {
            $message = 'Erreur lors de la création du document';
            return $request->expectsJson()
                ? response()->json(['success' => false, 'message' => $message], 500)
                : redirect()->back()->with('error', $message);
        }

        // Génération du numéro d'enregistrement
        $lastCourrier = Courrier::whereNotNull('reference_interne')
            ->where('reference_interne', 'like', 'DG-%')
            ->orderBy('id', 'desc')
            ->first();

        $nextNumber = 1;
        if ($lastCourrier && preg_match('/DG-(\d+)-/', $lastCourrier->reference_interne, $matches)) {
            $nextNumber = (int)$matches[1] + 1;
        }

        $referenceInterne = sprintf('DG-%04d-ENT', $nextNumber);

        // Création du courrier
        $courrier = new Courrier([
            'type_id' => 1,
            'document_id' => $document->id,
            'created_by' => $user->agent->id,
            'statut_id' => 1,
            'etape' => 'en_attente',
            'date_arrive' => now(),
            'reference_interne' => $referenceInterne,
            'is_intern' => 1,
        ]);
        
        $courrier->save();

        // Attacher les destinataires
        $courrier->destinateurs()->attach($assistantsDG->pluck('id')->toArray());

        // Attacher l'étape initiale
        $courrier->etapes()->attach(1);

        // Notification
        event(new CourrierCreated($courrier, $assistantsDG, 'Un nouveau document a été déposé et nécessite votre saisie'));

        // Historique
        Historique::create([
            'key' => 'Dépôt initial du document',
            'historiquecable_id' => $courrier->id,
            'historiquecable_type' => Courrier::class,
            'description' => 'A déposé un document pour numérisation',
            'user_id' => $user->id,
        ]);

        // Réponse de succès conditionnelle
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Document déposé avec succès',
                'courrier_id' => $courrier->id,
            ]);
        } else {
            return redirect()->route('regidoc.courriers.index')
                ->with('success', 'Document déposé avec succès');
        }

    } catch (\Exception $e) {
        $message = 'Erreur lors du dépôt du document: ' . $e->getMessage();

        return $request->expectsJson()
            ? response()->json(['success' => false, 'message' => $message], 500)
            : redirect()->back()->with('error', $message);
    }
}


    /**
     * Display the initial upload form for incoming mail.
     *
     * @return \Illuminate\View\View
     */
    public function showInitialUploadForm()
    {
        return view('regidoc.pages.courriers.initial-upload');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            // Vérifier que l'utilisateur est authentifié
            if (!Auth::check()) {
                return redirect()->route('login')->with('error', 'Veuillez vous connecter pour accéder à cette page.');
            }

            // Vérifier que l'utilisateur a un agent associé
            if (!Auth::user()->agent) {
                return redirect()->back()->with('error', 'Aucun agent associé à votre compte.');
            }

            // Récupérer le courrier avec ses relations
            $courrier = Courrier::with(['document', 'views'])->findOrFail($id);

            // Vérifier les autorisations
            $this->authorize('view', $courrier);

            // Compter les vues de l'utilisateur actuel
            $viewsForThisUser = $courrier->views->where('user_id', Auth::id())->count();

            // Enregistrer la vue si nécessaire
            views($courrier)->once($viewsForThisUser > 0)->record();

            // Charger les données nécessaires pour la vue
            $classeurs = Classeur::all();
            $dossiers = Dossier::all();
            $directions = Direction::all();
            
            // Déterminer les traitements disponibles en fonction du rôle de l'utilisateur
            $isDGorDGA = Auth::user()->agent->isDG() || Auth::user()->agent->isDGA();
            $traitements = $isDGorDGA 
                ? CourrierTypesTraitement::select('id', 'titre')->get() 
                : CourrierTypesTraitement::select('id', 'titre')->where('id', '!=', 3)->get();
                
            $priorites = Priorite::select('id', 'titre')->get();

            return view('regidoc.pages.courriers.show-courrier', compact(
                'directions', 
                'courrier', 
                'classeurs', 
                'dossiers',
                'traitements',
                'priorites'
            ));
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Gérer le cas où le courrier n'est pas trouvé
            return redirect()->route('regidoc.courriers.index')
                ->with('error', 'Le courrier demandé est introuvable.');
                
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            // Gérer les erreurs d'autorisation
            return redirect()->route('regidoc.courriers.index')
                ->with('error', 'Vous n\'êtes pas autorisé à accéder à ce courrier.');
                
        } catch (\Exception $e) {
            // Gérer toutes les autres exceptions
            return redirect()->route('regidoc.courriers.index')
                ->with('error', 'Une erreur est survenue lors du chargement du courrier.');
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $files = Courrier::notClassified()->get();
        // , compact('files')

        return view('regidoc.pages.courriers.courriers');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        if ($request->has('newdoc')) {
            $types = CourrierType::all();
            $services = Service::all();
            $agents = Agent::actif()->select('id','user_id','direction_id','nom','post_nom','prenom','division_id','service_id','fonction_id')->get();
            $natures = CourrierNature::select('id', 'titre')->get();

            $newDoc = $request->newdoc;
            $textSelected = $request->textSelected;
            $fileName = $request->fileName;

            return view('regidoc.pages.courriers.new-doc')->with([
                'types' => $types,
                'services' => $services,
                'agents' => $agents,
                'natures' => $natures,
                'newDoc' => $newDoc,
                'textSelected' => $textSelected,
                'fileName' => $fileName,
            ]);

        } else {
            $agents = Agent::actif()->select('id','user_id','direction_id','nom','post_nom','prenom','division_id','service_id','fonction_id')->get();

            $types = CourrierType::select('id', 'titre')->get();
            $services = Service::select('id', 'titre','responsable_id')->get();
            $natures = CourrierNature::select('id', 'titre')->get();
            return view('regidoc.pages.courriers.new-doc', compact('types', 'services', 'natures','agents'));
        }

    }

    


    public function relance(Courrier $courrier)
    {

        try {

            $annotation = new CourriersAnnotation();
            $annotation->user_id = Auth::user()->id;
            $annotation->courrier_id = $courrier->id;
            $annotation->note = "Relance pour le courrier " . $courrier->reference_interne . " provenent de " . ($courrier->expediteur ? $courrier->expediteur->nom : $courrier->externExpediteur->nom) . " reçu le " . $courrier->date_arrive . " qui n'est toujours pas traité à ce jour";
            $annotation->is_done = 0;
            $annotation->save();

            $content = json_encode([
                'name' => 'Courriers',
                'statut' => 'success',
                'message' => 'Courrier relancé avec succès !',
            ]);

        } catch (\Throwable $th) {
            $content = json_encode([
                'name' => 'Courrier',
                'statut' => 'error',
                'message' => 'Impossible de relance le courrier, une erreur s\'est produite',
            ]);
        }

        session()->flash(
            'session',
            $content
        );

        return redirect()->back();
    }

    public function createDoc()
    {
        $types = CourrierType::all();
        $services = Service::all();
        $agents = Agent::all();
        $natures = CourrierNature::select('id', 'titre')->get();

        return view('regidoc.pages.courriers.new-doc', compact('types', 'agents', 'services', 'natures'));
    }

    public function signer($id)
    {
        $courrier = Courrier::find($id);
        $agents = Agent::select('id', 'prenom', 'nom')->where('id', '!=', Auth::user()->agent->id)->get();

        return view('regidoc.pages.courriers.signiature')->with([
            'courrier' => $courrier,
            'agents' => $agents,
        ]);
    }

    public function classify($id)
    {
        try {
            $courrier = Courrier::find($id);
            $courrier->is_classified = 1;
            $courrier->save();

            $courrier->document->statut_id = 6;
            $courrier->document->save();

            $content = json_encode([
                'name' => 'Courriers',
                'statut' => 'success',
                'message' => 'Courrier classé avec succès !',
            ]);
        } catch (\Throwable $th) {
            // dd($th);
            $content = json_encode([
                'name' => 'Courrier',
                'statut' => 'error',
                'message' => 'Impossible de classer le courrier, une erreur s\'est produite',
            ]);
        }

        session()->flash(
            'session',
            $content
        );
        return redirect()->route('regidoc.courriers.index');
    }
 
    public function saveTraitementSignature(Request $request)
    {
        $courrier = Courrier::find($request->courrier_id);
        $traitement = null;

        if ($courrier->traitements->count() == 0 || $request->is_original) {
            // I save traitement
            $traitement = new CourrierTraitement();
            $traitement->agent_id = Auth::user()->agent->id;
            $traitement->note = 'Document validé';
            $traitement->save();

            $courrier->document->statut_id = 6;
            $courrier->document->save();

            $courrier->traitements()->attach($traitement);
        }else{
            if(!$request->is_original){
                $traitement = CourrierTraitement::find($request->doc_id);
                if($traitement->document_url != null){
                    // delete the old file
                    Storage::delete($traitement->document_url);
                }
            }else{
                $traitement = $courrier->traitements->last();
                if($traitement->document_url != null){
                    // delete the old file
                    Storage::delete($traitement->document_url);
                }
            }
        } 
        // I change the stap
        $courrier->etapes()->attach(4);
        $courrier->destinateurs()->attach(Auth::user()->agent->direction->responsable);

        $traitement->document_url = (new File)->handle($request, 'document', 'documents');
        $traitement->save();

        Historique::create([
            "key" => "Signature",
            "historiquecable_id" => $request->courrier_id,
            "historiquecable_type" => Courrier::class,
            "description" => "A signé le document du courrier",
            "user_id" => Auth::user()->id,
        ]);

        $destinateursToNotify = $courrier->destinateurs->where('id', '!=', Auth::user()->agent->id);

        if (count($destinateursToNotify)) {
            event(new CourrierCreated($courrier, $destinateursToNotify, 'A signé le document du courrier'));
        }

        return $traitement;
    }

    public function saveSignature(Request $request)
    {
        $traitement = $this->saveTraitementSignature($request);
        return response()->json(['file' => files($traitement->document_url)->link]);
    }


    public function saveCourrierSortant($courrier)
    {
        $courrier->save();
        return $courrier;
    }

    
public function traitement($courrier)
{
    try {
        \Log::info('🟢 Début du traitement');

        // Récupération du courrier s'il s'agit d'un ID
        $courrier = $courrier instanceof Courrier ? $courrier : Courrier::find($courrier);
        \Log::info('📩 Courrier chargé', ['courrier_id' => optional($courrier)->id]);

        if (!$courrier) {
            throw new \Exception('Courrier introuvable.');
        }

        // 📥 Courrier entrant
        if ($courrier->type_id == 1) {
            \Log::info('➡️ Traitement du courrier entrant');

            $courrier->mark_as_done = 1;
            $courrier->save();
            \Log::info('✅ Courrier marqué comme traité');

            if ($courrier->document) {
                $courrier->document->statut_id = 5; // 5 = "Traité"
                $courrier->document->save();
                \Log::info('🗂️ Document marqué comme traité', ['document_id' => $courrier->document->id]);
            }

            $agentId = Auth::user()->agent->id;
            \Log::info('👤 Agent identifié', ['agent_id' => $agentId]);

            $traitement = new CourrierTraitement();
            $traitement->agent_id = $agentId;
            $traitement->note = 'Document traité';
            $traitement->save();
            \Log::info('📝 Traitement enregistré', ['traitement_id' => $traitement->id]);

            $courrier->traitements()->attach($traitement);
            $courrier->etapes()->attach(3); // Étape assistant
            \Log::info('🔁 Traitement et étape ajoutés');

            // 📤 Création du courrier sortant
            $oldata = $courrier->getAttributes();
            unset($oldata['id'], $oldata['updated_at'], $oldata['created_at']);

            $nomExp = optional($courrier->externExpediteur)->nom;
            if (!$nomExp) {
                throw new \Exception('Nom de l’expéditeur externe non disponible.');
            }

            $nouveau_destinataire = CourrierDestinateurExterne::where('nom', $nomExp)->first();
            $extern_destinataire = $nouveau_destinataire ?: new CourrierDestinateurExterne(['nom' => $nomExp]);

            if (!$nouveau_destinataire) {
                $extern_destinataire->save();
                \Log::info('📦 Nouveau destinataire externe créé', ['dest_id' => $extern_destinataire->id]);
            }

            $oldata['type_id'] = 2; // Sortant
            $oldata['created_by'] = Auth::user()->id;
            $oldata['exped_externe'] = null;
            $oldata['exped_interne_id'] = $agentId;
            $oldata['parent_id'] = $courrier->id;
            $oldata['traitement_id'] = null;
            $oldata['mark_as_done'] = null;
            $oldata['reference_interne'] = $this->changeNumRef(2);
            $oldata['dest_externe_id'] = $extern_destinataire->id;

            $newCourrier = $this->saveCourrierSortant(new Courrier($oldata));
            \Log::info('📨 Courrier sortant créé', ['new_courrier_id' => $newCourrier->id]);

            foreach ($courrier->traitements as $t) {
                $newCourrier->traitements()->attach($t);
            }

            $dgResponsables = Auth::user()->agent->direction->dgAssistanats->pluck('responsable_id');
            if ($dgResponsables->count()) {
                $newCourrier->destinateurs()->attach($dgResponsables);
                \Log::info('👥 Responsables attachés', ['ids' => $dgResponsables]);
            }

            $newCourrier->etapes()->attach(3);

            $notifyAgents = $newCourrier->destinateurs->where('id', '!=', $agentId);

            // Correction ici : on transforme followers en collection avant count()
            $followers = collect($newCourrier->followers);
            if ($followers->count() > 0) {
                $notifyAgents = $notifyAgents->merge($followers)->flatten();
            }

            if ($notifyAgents->count() > 0) {
                event(new CourrierCreated($courrier, $notifyAgents, 'Un nouveau courrier traité vous a été transmis !'));
                \Log::info('📢 Notification envoyée', ['agents' => $notifyAgents->pluck('id')]);
            }

            $courrier->statut_id = 3;
            $courrier->save();
            \Log::info('🟩 Statut du courrier entrant mis à jour');
        }

        // 📨 Courrier interne
        elseif ($courrier->type_id == 3) {
            \Log::info('➡️ Traitement du courrier interne');

            $courrier->mark_as_done = 1;
            $courrier->save();

            if ($courrier->document) {
                $courrier->document->statut_id = 5;
                $courrier->document->save();
                \Log::info('🗂️ Document interne marqué comme traité');
            }

            $traitement = new CourrierTraitement();
            $traitement->agent_id = Auth::user()->agent->id;
            $traitement->note = 'Document traité';
            $traitement->save();

            $courrier->traitements()->attach($traitement);
            $courrier->statut_id = 3;
            $courrier->save();
            \Log::info('🟩 Courrier interne mis à jour avec traitement');
        }

        $response = [
            'name' => 'Courrier',
            'statut' => 'success',
            'message' => 'Le courrier a été marqué comme traité',
        ];

        \Log::info('✅ Fin du traitement avec succès');

        if (request()->ajax()) {
            return response()->json($response, 200, ['Content-Type' => 'application/json']);
        } else {
            session()->flash('session', json_encode($response));
            return redirect()->back();
        }

    } catch (\Throwable $th) {
        \Log::error('❌ Erreur lors du traitement du courrier', [
            'message' => $th->getMessage(),
            'file' => $th->getFile(),
            'line' => $th->getLine(),
            'stack' => $th->getTraceAsString(),
        ]);

        $response = [
            'name' => 'Courrier',
            'statut' => 'error',
            'message' => 'Impossible de marquer le courrier comme traité, une erreur est survenue',
        ];

        if (request()->ajax()) {
            return response()->json($response, 500, ['Content-Type' => 'application/json']);
        } else {
            session()->flash('session', json_encode($response));
            return redirect()->back();
        }
    }
}
    
    // public function saveTraitement(Request $request)
    // {
    //     // dd(Auth::user()->agent->direction->dgAssistanats);
    //     try{
    //         $traitement = new CourrierTraitement();
    //         $courrier = Courrier::find($request->courrier_id);

    //         if (Auth::user()->agent->isAssistant() || Auth::user()->agent->isSecretaire()) {

    //             // I complete same remaining courrier data
    //             $courrier->priorite_id = $request->priorite_id;
    //             $courrier->date_fin = !empty($request->date_limite) || $request->date_limite != null ? $request->date_limite : null;
    //             $courrier->traitement_id = $request->traitement_id;
    //             $courrier->save();

    //             // I save traitement
    //             $traitement->agent_id = Auth::user()->agent->id;
    //             $traitement->note = $request->commentaire ?? 'Document traité';
    //             $traitement->save();

    //             $courrier->traitements()->attach($traitement);

    //             if ($courrier->type_id == 1) {

    //                 // I save annotation
    //                 if ($request->commentaire) {
    //                     $annotation = new CourriersAnnotation();
    //                     $annotation->user_id = Auth::user()->id;
    //                     $annotation->courrier_id = $courrier->id;
    //                     $annotation->note = $request->commentaire;
    //                     $annotation->save();
    //                 }

    //                 if(Auth::user()->agent->isAssistant()){
    //                     // I change the stap
    //                     $courrier->etapes()->attach(4);

    //                     $courrier->destinateurs()->attach(Auth::user()->agent->direction->responsable);
    //                     if (Auth::user()->agent->direction->responsable->delegue_id !== null) {
    //                         $courrier->destinateurs()->attach(
    //                             Auth::user()->agent->direction->responsable->delegue_id
    //                         );
    //                     }
    //                 }

    //                 if (Auth::user()->agent->isSecretaire()) {
    //                     // I change the stap
    //                     $courrier->etapes()->attach(3);
    //                     $courrier->destinateurs()->attach(Auth::user()->agent->direction->dgAssistanats->pluck('responsable_id'));
    //                 }

    //                 Historique::create([
    //                     "key" => "Accusé de reception",
    //                     "historiquecable_id" => $courrier->id,
    //                     "historiquecable_type" => Courrier::class,
    //                     "description" => "A établi un traitement à effectuer le courrier",
    //                     "user_id" => Auth::user()->id,
    //                 ]);

    //                 if (Auth::user()->agent->isSecretaire()) {
    //                     $agentsToNotify = Agent::find(Auth::user()->agent->direction->dgAssistanats->pluck('responsable_id'));
    //                     if ((is_iterable($agentsToNotify) && count($agentsToNotify)) || $agentsToNotify) {
    //                         event(new CourrierCreated($courrier, $agentsToNotify, 'Vous a transmis un nouveau courrier !'));
    //                     }
    //                 } elseif (Auth::user()->agent->isAssistant()) {
    //                     if (Auth::user()->agent->direction->responsable) {
    //                         event(new CourrierCreated($courrier, Auth::user()->agent->direction->responsable, 'Vous a transmis un nouveau courrier !'));
    //                     }
    //                 }

    //             } elseif ($courrier->type_id == 2) {

    //                 if (Auth::user()->agent->isAssistant()) {
    //                     // I change the stap
    //                     $courrier->etapes()->attach(2);
    //                     $courrier->destinateurs()->attach(Auth::user()->agent->direction->dgSecretaires); //Unikho
    //                 }

    //                 if(Auth::user()->agent->isSecretaire()){
    //                     $courrier->etapes()->attach(1);

    //                     if (Auth::user()->agent->direction->service->id == 3) {
    //                         $courrier->destinateurs()->attach(Auth::user()->agent->direction->service->id);
    //                     }
    //                 }

    //                 Historique::create([
    //                     "key" => "Accusé de reception",
    //                     "historiquecable_id" => $courrier->id,
    //                     "historiquecable_type" => Courrier::class,
    //                     "description" => "A effectué un traitement sur ce courrier",
    //                     "user_id" => Auth::user()->id,
    //                 ]);

    //                 $destinateurToNotify = $courrier->destinateurs->where('id', '!=', Auth::user()->agent->id);
    //                 if (count($destinateurToNotify)) {
    //                     event(new CourrierCreated(
    //                         $courrier,
    //                         $destinateurToNotify,
    //                         'Vous a transmi un courrier sortant !'));
    //                 }
    //             }

    //             elseif ($courrier->type_id == 3){
    //                 if ($request->commentaire) {

    //                     $annotation = new CourriersAnnotation();
    //                     $annotation->user_id = Auth::user()->id;
    //                     $annotation->courrier_id = $courrier->id;
    //                     $annotation->note = $request->commentaire;
    //                     $annotation->save();
    //                 } 

    //                 if (Auth::user()->agent->isSecretaire()) {
    //                     // I change the stap
    //                     $courrier->etapes()->attach(4);
    //                     $courrier->destinateurs()->attach(Auth::user()->agent->direction->responsable);
    //                     if (Auth::user()->agent->direction->responsable->delegue_id !== null) {
    //                         $courrier->destinateurs()->attach(
    //                             Auth::user()->agent->direction->responsable->delegue_id
    //                         );
    //                     }
    //                 } 

    //                 Historique::create([
    //                     "key" => "Accusé de reception",
    //                     "historiquecable_id" => $courrier->id,
    //                     "historiquecable_type" => Courrier::class,
    //                     "description" => "A effectué un traitement sur ce courrier",
    //                     "user_id" => Auth::user()->id,
    //                 ]);

    //                 if (Auth::user()->agent->isSecretaire()) {
    //                     $agentsToNotify = Agent::find(Auth::user()->agent->direction->responsable);
    //                     if ((is_iterable($agentsToNotify) && count($agentsToNotify)) || $agentsToNotify) {
    //                         event(new CourrierCreated($courrier, $agentsToNotify, 'Vous a transmis un nouveau courrier !'));
    //                     }      
    //                 }

    //             }
    //         }

    //         if (count($request->document_files)) {
    //             $filesPath = [];
    //             $path = 'courrier-traitements/' . date('FY') . '/';
    //             foreach ($request->document_files as $document) {
    //                 $filename = $this->generateFileName($document, $path);
    //                 $document->storeAs(
    //                     $path,
    //                     $filename . '.' . $document->getClientOriginalExtension(),
    //                     'public'
    //                 );

    //                 array_push($filesPath, [
    //                     'download_link' => $path . $filename . '.' . $document->getClientOriginalExtension(),
    //                     'original_name' => $document->getClientOriginalName(),
    //                 ]);
    //             }

    //             $traitement->document_url = $filesPath;
    //             $traitement->save();

    //             Historique::create([
    //                 "key" => "Accusé de reception",
    //                 "historiquecable_id" => $courrier->id,
    //                 "historiquecable_type" => Courrier::class,
    //                 "description" => "A joint un fichier à ce courrier",
    //                 "user_id" => Auth::user()->id,
    //             ]);
    //         }
    //         return response()->json([
    //             'success' => 1
    //         ]);
    //     }catch(\Throwable $th){
    //         return response()->json([
    //             'error' => $th->getMessage(),
    //         ]);
    //     }

    // }
    public function saveTraitement(Request $request)
{
    try {
        // On récupère le courrier ou erreur 404
        $courrier = Courrier::findOrFail($request->courrier_id);

        $user = Auth::user();
        $agent = $user->agent;

        if ($agent->isAssistant() || $agent->isSecretaire()) {

            // Mise à jour des infos du courrier
            $courrier->priorite_id = $request->priorite_id;
            $courrier->date_fin = $request->date_limite ?? null;
            $courrier->traitement_id = $request->traitement_id;
            $courrier->save();

            // Création du traitement
            $traitement = new CourrierTraitement();
            $traitement->agent_id = $agent->id;
            $traitement->note = $request->commentaire ?? 'Document traité';
            $traitement->save();

            $courrier->traitements()->attach($traitement);

            if ($courrier->type_id == 1) {

                // Sauvegarde annotation si commentaire
                if ($request->commentaire) {
                    $annotation = new CourriersAnnotation();
                    $annotation->user_id = $user->id;
                    $annotation->courrier_id = $courrier->id;
                    $annotation->note = $request->commentaire;
                    $annotation->save();
                }

                if ($agent->isAssistant()) {
                    $courrier->etapes()->attach(4);

                    $responsable = $agent->direction->responsable;
                    if ($responsable) {
                        $courrier->destinateurs()->attach($responsable->id);
                        if ($responsable->delegue_id) {
                            $courrier->destinateurs()->attach($responsable->delegue_id);
                        }
                    }
                }

                if ($agent->isSecretaire()) {
                    $courrier->etapes()->attach(3);

                    $ids = $agent->direction->dgAssistanats->pluck('responsable_id')->toArray();
                    if (!empty($ids)) {
                        $courrier->destinateurs()->attach($ids);
                    }
                }

                Historique::create([
                    "key" => "Accusé de reception",
                    "historiquecable_id" => $courrier->id,
                    "historiquecable_type" => Courrier::class,
                    "description" => "A établi un traitement à effectuer le courrier",
                    "user_id" => $user->id,
                ]);

                if ($agent->isSecretaire()) {
                    $ids = $agent->direction->dgAssistanats->pluck('responsable_id')->toArray();
                    $agentsToNotify = Agent::whereIn('id', $ids)->get();

                    if ($agentsToNotify->isNotEmpty()) {
                        event(new CourrierCreated($courrier, $agentsToNotify, 'Vous a transmis un nouveau courrier !'));
                    }
                } elseif ($agent->isAssistant()) {
                    $responsable = $agent->direction->responsable;
                    if ($responsable) {
                        event(new CourrierCreated($courrier, collect([$responsable]), 'Vous a transmis un nouveau courrier !'));
                    }
                }

            } elseif ($courrier->type_id == 2) {

                if ($agent->isAssistant()) {
                    $courrier->etapes()->attach(2);
                    $ids = $agent->direction->dgSecretaires->pluck('id')->toArray();
                    if (!empty($ids)) {
                        $courrier->destinateurs()->attach($ids);
                    }
                }

                if ($agent->isSecretaire()) {
                    $courrier->etapes()->attach(1);

                    if ($agent->direction->service->id == 3) {
                        $courrier->destinateurs()->attach($agent->direction->service->id);
                    }
                }

                Historique::create([
                    "key" => "Accusé de reception",
                    "historiquecable_id" => $courrier->id,
                    "historiquecable_type" => Courrier::class,
                    "description" => "A effectué un traitement sur ce courrier",
                    "user_id" => $user->id,
                ]);

                $destinateurToNotify = $courrier->destinateurs->where('id', '!=', $agent->id);
                if ($destinateurToNotify->isNotEmpty()) {
                    event(new CourrierCreated($courrier, $destinateurToNotify, 'Vous a transmis un courrier sortant !'));
                }

            } elseif ($courrier->type_id == 3) {

                if ($request->commentaire) {
                    $annotation = new CourriersAnnotation();
                    $annotation->user_id = $user->id;
                    $annotation->courrier_id = $courrier->id;
                    $annotation->note = $request->commentaire;
                    $annotation->save();
                }

                if ($agent->isSecretaire()) {
                    $courrier->etapes()->attach(4);

                    $responsable = $agent->direction->responsable;
                    if ($responsable) {
                        $courrier->destinateurs()->attach($responsable->id);
                        if ($responsable->delegue_id) {
                            $courrier->destinateurs()->attach($responsable->delegue_id);
                        }
                    }
                }

                Historique::create([
                    "key" => "Accusé de reception",
                    "historiquecable_id" => $courrier->id,
                    "historiquecable_type" => Courrier::class,
                    "description" => "A effectué un traitement sur ce courrier",
                    "user_id" => $user->id,
                ]);

                if ($agent->isSecretaire()) {
                    $responsable = $agent->direction->responsable;
                    if ($responsable) {
                        event(new CourrierCreated($courrier, collect([$responsable]), 'Vous a transmis un nouveau courrier !'));
                    }
                }
            }

            // Gestion des fichiers joints
            if (!empty($request->document_files) && count($request->document_files)) {
                $filesPath = [];
                $path = 'courrier-traitements/' . date('FY') . '/';

                foreach ($request->document_files as $document) {
                    $filename = $this->generateFileName($document, $path);
                    $extension = $document->getClientOriginalExtension();
                    $document->storeAs($path, $filename . '.' . $extension, 'public');

                    $filesPath[] = [
                        'download_link' => $path . $filename . '.' . $extension,
                        'original_name' => $document->getClientOriginalName(),
                    ];
                }

                $traitement->document_url = json_encode($filesPath);
                $traitement->save();

                Historique::create([
                    "key" => "Accusé de reception",
                    "historiquecable_id" => $courrier->id,
                    "historiquecable_type" => Courrier::class,
                    "description" => "A joint un fichier à ce courrier",
                    "user_id" => $user->id,
                ]);
            }

            return response()->json(['success' => 1]);

        } else {
            return response()->json(['error' => 'Permission refusée'], 403);
        }
    } catch (\Throwable $th) {
        return response()->json(['error' => $th->getMessage()], 500);
    }
}


   


/**
 * Create a document from the uploaded file or scan
 *
 * @param  \Illuminate\Http\Request|array  $request
 * @param  int  $responsibleId
 * @param  \App\Models\Document|null  $doc
 * @return \App\Models\Document|null
 */
protected function createDocument($request, $responsibleId, $doc = null)
{
    // Déterminer si c'est un appel avec un objet Request ou un tableau
    $isRequestObject = $request instanceof \Illuminate\Http\Request;
    $isInitialUpload = !$isRequestObject && is_array($request);
    
    // Si c'est un appel avec un objet Request (nouveau workflow)
    if ($isRequestObject && $request->hasFile('document')) {
        // Créer un classeur pour les courriers entrants s'il n'existe pas
        $classeur = Classeur::firstOrCreate(
            ['titre' => 'Courriers Entrants'],
            [
                'reference' => 'CE-' . date('YmdHis'),
                'created_by' => $responsibleId
            ]
        );

        // Créer un dossier pour le mois en cours s'il n'existe pas
        $dossier = Dossier::firstOrCreate(
            [
                'titre' => date('F Y'),
                'classeur_id' => $classeur->id
            ],
            [
                'reference' => 'D-' . date('Ym'),
                'created_by' => $responsibleId
            ]
        );

        // Gérer le fichier téléchargé
        $file = $request->file('document');
        $originalName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $filename = pathinfo($originalName, PATHINFO_FILENAME) . '_' . time() . '.' . $extension;
        $path = $file->storeAs('documents/' . date('Y/m'), $filename, 'public');

        // Créer le document dans la base de données
        $document = $doc ?? new Document();
        $document->libelle = $originalName;
        $document->reference = 'DOC-' . strtoupper(Str::random(8));
        $document->document = $path;
        $document->type = 1; // 1: Entrant, 2: Sortant, 3: Interne (selon la table document_types)
        $document->dossier_id = $dossier->id;
        $document->user_id = $responsibleId;
        $document->statut_id = 1; // Statut actif
        $document->created_by = $responsibleId;
        $document->save();

        return $document;
    }
    // Si c'est un appel avec un tableau (ancien workflow)
    elseif ($isInitialUpload) {
        $requestData = $request; // C'est déjà un tableau
        $destinateur = $responsibleId; // Le second paramètre est le destinataire dans ce cas
        
        // 1. Création ou récupération du classeur
        $classeur = Classeur::firstOrCreate(
            ['titre' => Auth::user()->agent->direction?->lieu?->titre ?? 'Region inconnu'], 
            [
                'reference' => 'DIR/' . Str::padLeft(Classeur::count() + 1, 4, '0'),
                'direction_id' => Agent::find($destinateur)?->direction_id,
                'created_by' => Auth::user()->agent->id
            ]
        );

        // 2. Création ou récupération du dossier 'Courriers'
        $dossier = Dossier::firstOrCreate(
            ['titre' => 'Courriers', 'classeur_id' => $classeur->id], 
            [
                'reference' => 'DIR/' . Str::padLeft(Classeur::count() + 1, 4, '0'),
                'created_by' => Auth::user()->agent->id,
                'updated_by' => Auth::user()->agent->id,
            ]
        );

        // 3. Si pas de document existant passé en paramètre
        if ($doc === null) {
            // Cas où c'est un scan ou un document déjà sélectionné
            if (($requestData['is_scan'] ?? false) == "true" || (isset($requestData['selected_doc']) && !empty($requestData['selected_doc']))) {
                $document = new Document();
                $document->dossier_id = $dossier->id;
                $document->reference = is_array($requestData['ref'] ?? null) ? 
                    implode(', ', $requestData['ref']) : ($requestData['ref'] ?? null);
                $document->category_id = $requestData['categorie'] ?? null;
                $document->libelle = $requestData['title'] ?? 'Document sans titre';
                $document->type = $requestData['type'] ?? 'pdf';

                if (($requestData['is_scan'] ?? false) == "true") {
                    // Stockage du fichier scanné
                    $document->document = (new ScanFile())->handle('documents');
                } else {
                    // Déplacer un fichier sélectionné déjà uploadé en temporaire
                    $document->document = $this->moveCreatedDoc($requestData['selected_doc']);
                }

                $document->user_id = Auth::id();
                $document->statut_id = 1;
                $document->created_by = Auth::user()->agent->id;
                $document->save();

                return $document;
            }

            // Cas d'un upload via formulaire (input file)
            if (isset($requestData['document']) && empty($requestData['document_id'])) {
                $document = new Document();
                $document->dossier_id = $dossier->id;
                $document->reference = $requestData['ref'] ?? null;
                $document->category_id = $requestData['categorie'] ?? null;
                $document->libelle = $requestData['title'] ?? 'Document sans titre';
                $document->type = $requestData['type'] ?? 'pdf';

                // Utilisation de la classe File pour stocker le fichier
                $document->document = (new File())->handle($request, 'document', 'documents');

                $document->user_id = Auth::id();
                $document->statut_id = 1;
                $document->created_by = Auth::user()->agent->id;
                $document->save();

                return $document;
            }
            
            // Cas où on utilise un document existant via son ID
            if (!empty($requestData['document_id'])) {
                return Document::find($requestData['document_id']);
            }
        } else {
            // Cas où on crée un nouveau document à partir d'un autre objet $doc existant
            $document = Document::create([
                'dossier_id' => $dossier->id,
                'reference' => is_array($doc->reference) ? 
                    implode(', ', $doc->reference) . '/R' : 
                    ($doc->reference ? $doc->reference . '/R' : 'DOC-' . strtoupper(Str::random(8))),
                'category_id' => $doc->category_id ?? null,
                'libelle' => $doc->libelle ?? 'Document copié',
                'type' => $doc->type ?? 'pdf',
                'document' => $doc->document ?? null,
                'user_id' => Auth::id(),
                'statut_id' => 1,
                'created_by' => Auth::user()->agent->id,
            ]);

            return $document;
        }
    }

    // Par défaut, rien à retourner si aucune condition remplie
    return null;
}


    public function createDocu($request, $doc = null){
        // if ($doc == null) {
        //     if ($request?->is_scan == "true" || ($request?->has('selected_doc') && !empty($request?->selected_doc))) {
                
        //         $document = new Document();
        //         // $document->dossier_id = $dossier->id;
        //         $document->reference = $request->get('ref');
        //         $document->category_id = $request->get('categorie');
        //         $document->libelle = $request->get('title');
        //         $document->type = $request->get('type');
        //         $document->document = $request->is_scan == "true" ? (new ScanFile())->handle('documents') : $this->moveCreatedDoc($request->selected_doc);
        //         $document->user_id = Auth::user()->id;
        //         $document->statut_id = 1;
        //         $document->created_by = Auth::user()->agent->id;
        //         $document->save();

        //         return $document;
        //     }

        //     if ($request?->hasFile('document') && ($request?->document_id == null || $request?->document_id == '')) {
        //         $document = new Document();
        //         // $document->dossier_id = $dossier->id;
        //         $document->reference = $request->get('ref');
        //         $document->category_id = $request->get('categorie');
        //         $document->libelle = $request->get('title');
        //         $document->type = $request->get('type');
        //         $document->document = (new File())->handle($request, 'document', 'documents');
        //         $document->user_id = Auth::user()->id;
        //         $document->statut_id = 1;
        //         $document->created_by = Auth::user()->agent->id;
        //         $document->save();

        //         return $document;

        //     } elseif ($request->has('document_id') && ($request->document_id != null || $request->document_id != '')) {
        //         $document = Document::find($request->document_id);
        //         return $document;
        //     }
        // } else {

            $document = Document::create([
                // 'dossier_id' => $dossier->id,
                'reference' => $doc->reference . '/R',
                'category_id' => $doc->category_id,
                'libelle' => $doc->libelle,
                'type' => $doc->type,
                'document' => $doc ? $doc->document : (new File())->handle($request, 'document', 'documents'),
                'user_id' => Auth::user()->id,
                'statut_id' => 1,
                'created_by' => Auth::user()->agent->id,
            ]);

            return $document;
        // }

    }

    public function changeNumRef($type)
    {
        $lastNum = Courrier::whereIn('service_id', Auth::user()->agent->direction?->services->pluck('id')->toArray())
            ->orWhereNull('service_id')
            ->where('reference_interne', 'LIKE', '%' . $this->abbreviateTitle(Auth::user()->agent->direction?->lieu?->titre).'-%')
            ->count();
        $num = (int) $lastNum;
        $num += 1;
        $num = Str::padLeft($num, 4, '0');
        $num = $this->abbreviateTitle(Auth::user()->agent->direction?->lieu?->titre) . '-' . $num . '-' . Str::limit($type == 1 ? 'ENTRANT' : ($type == 2 ? "SORTANT" : "INTERNE"), 3, '');
        return $num;
    }

    public function abbreviateTitle($title)
    {
        // Divise le titre en mots
        $words = explode(' ', $title);

        // Initialise une variable pour stocker l'abréviation
        $abbreviation = '';

        // Parcourt chaque mot et prend la première lettre
        foreach ($words as $word) {
            $abbreviation .= strtoupper($word[0]);
        }

        return $abbreviation;
    }

    public function confidentiel($id)
    {
        try {
            $courrier = Courrier::find($id);
            $courrier->confidentiel = 1;
            $courrier->save();

            $password = Random::generate(6,'0-9');

            $courrier->document?->update([
                'confidentiel' => 1,
                'password' => $password,
            ]);

            Mail::to(Auth::user())->send(new DocumentPasswordMail($password,/* Utilisateur à envoyer */));

            $content = json_encode([
                'name' => 'Courriers',
                'statut' => 'success',
                'message' => 'Courrier rendu confidentiel avec succès !',
            ]);

        } catch (\Throwable $th) {
            $content = json_encode([
                'name' => 'Courrier',
                'statut' => 'error',
                'message' => 'Impossible de rendre le courrier confidentiel, une erreur s\'est produite',
            ]);
        }

        session()->flash(
            'session',
            $content
        );

        return redirect()->back();
    }

    public function nonconfidentiel($id)
    {
        try {
            $courrier = Courrier::find($id);
            $courrier->confidentiel = 0;
            $courrier->save();

            $content = json_encode([
                'name' => 'Courriers',
                'statut' => 'success',
                'message' => 'Courrier rendu non confidentiel avec succès !',
            ]);
        } catch (\Throwable $th) {
            $content = json_encode([
                'name' => 'Courrier',
                'statut' => 'error',
                'message' => 'Impossible de rendre le courrier non confidentiel, une erreur s\'est produite',
            ]);
        }

        session()->flash(
            'session',
            $content
        );

        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   

    public function store(Request $request)
    {
        // Initialiser $content pour s'assurer qu'il est toujours défini.
        $content = json_encode([
            'name' => 'Courrier',
            'statut' => 'error',
            'message' => 'Type de courrier non supporté pour la numérisation.', // Message par défaut
        ]);

        try {
            // Récupérer la valeur de 'copie' si elle est présente dans la requête.
            // On l'initialise à un tableau vide si elle n'existe pas.
            $copie = $request->get('copie', []); 

            if ($request->get('type') == 1) { // Logique pour Courrier Entrant
                // Récupérer les assistants du DG via la relation assistanats()
                $assistantsDG = Direction::find(1)->assistanats->pluck('responsable_id');

                if ($assistantsDG->isEmpty()) {
                    $content = json_encode([
                        'name' => 'Courrier',
                        'statut' => 'error',
                        'message' => 'Impossible d\'envoyer le courrier, aucun assistant du DG trouvé.',
                    ]);
                    session()->flash('session', $content);
                    return redirect()->route('regidoc.courriers.index');
                }

                // Création du document avec le premier assistant DG comme responsable
                // Assurez-vous que la méthode createDocument existe et est accessible (private, protected, ou helper)
                $document = $this->createDocument($request, $assistantsDG->first());

                // Création du courrier
                $courrier = new Courrier;
                $courrier->type_id = $request->get('type');
                $courrier->category_id = $request->get('categorie');
                $courrier->exped_externe = $request->get('exp');
                $courrier->reference_courrier = $request->get('ref');
                $courrier->reference_interne = $request->get('ref_interne');
                $courrier->confidentiel = $request->get('confidentiel') ? '1' : '0';
                $courrier->title = $request->get('title');
                $courrier->nature_id = $request->get('nature');
                $courrier->date_du_courrier = $request->get('date-doc');
                $courrier->date_arrive = $request->get('date-arriv');
                $courrier->objet = $request->get('objet');
                $courrier->document_id = $document?->id;
                $courrier->created_by = Auth::user()->agent->id;
                $courrier->statut_id = 1; // Statut initial
                $courrier->save();

                // Attacher les assistants DG comme destinataires
                $courrier->destinateurs()->attach($assistantsDG);

                // Attacher l'étape (exemple : étape 2)
                $courrier->etapes()->attach(2);

                // Notification aux assistants DG sauf le créateur
                $notifyAgents = $courrier->destinateurs->where('id', '!=', Auth::user()->agent->id);
                if ($notifyAgents->count()) {
                    event(new CourrierCreated($courrier, $notifyAgents, 'A créé un nouveau courrier !'));
                }

                // Historique
                Historique::create([
                    "key" => "Numérisation du courrier",
                    "historiquecable_id" => $courrier->id,
                    "historiquecable_type" => Courrier::class,
                    "description" => "A numérisé un courrier",
                    "user_id" => Auth::user()->id,
                ]);

                $content = json_encode([
                    'name' => 'Courriers',
                    'statut' => 'success',
                    'message' => 'Courrier numérisé et envoyé aux assistants du DG avec succès !',
                ]);

            } elseif ($request->get('type') == 3) { // Logique pour Courrier Interne (Destinataire est un agent)
                $destinataireAgentId = $request->get('destination2');
                // dd( $destinataireAgentId);
                // Vérifier si l'agent destinataire existe
                $destinataireAgent = Agent::find($destinataireAgentId);
                if (!$destinataireAgent) {
                    $content = json_encode([
                        'name' => 'Courrier',
                        'statut' => 'error',
                        'message' => 'Agent destinataire interne introuvable.',
                    ]);
                    session()->flash('session', $content);
                    return redirect()->route('regidoc.courriers.index');
                }

                // Créer le document avec l'agent destinataire comme responsable
                $document = $this->createDocument($request, $destinataireAgent->id);

                $courrier = new Courrier;
                $courrier->type_id = $request->get('type');
                $courrier->category_id = $request->get('categorie');
                $courrier->traitement_id = $request->get('traitement_id');
                $courrier->exped_interne_id = $request->get('exp_int');
                $courrier->dest_interne_id = $destinataireAgent->id; // L'ID de l'agent est le destinataire interne
                // Vous pouvez déduire le département/service de l'agent si nécessaire, ou le prendre de la requête
                $courrier->departement_id = $destinataireAgent->departement_id ?? $request->get('service_init');
                $courrier->service_id = $destinataireAgent->service_id ?? $request->get('service_init');
                $courrier->service_traitant_id = $destinataireAgent->direction_id ?? null; // ID de la direction de l'agent si applicable
                $courrier->title = $request->get('title');
                $courrier->reference_courrier = $request->get('ref');
                $courrier->reference_interne = $request->get('ref_interne');
                $courrier->confidentiel = $request->get('confidentiel') ? '1' : '0';
                $courrier->priorite_id = $request->get('priorite');
                $courrier->created_by = Auth::user()->id;
                $courrier->date_du_courrier = $request->get('date-doc');
                $courrier->date_arrive = $request->get('date-arriv');
                $courrier->date_fin = $request->get('date-limite');
                $courrier->nature_id = $request->get('nature');
                $courrier->objet = $request->get('objet');
                $courrier->document_id = $document->id;
                $courrier->is_intern = 1; // Toujours 1 pour courrier interne
                $courrier->statut_id = 1; // Statut initial
                $courrier->save();

                // Attacher l'agent destinataire principal
                $courrier->destinateurs()->attach($destinataireAgent->id);

                // Gérer les copies (followers) qui restent basées sur les directions
                $secretairesCopie = collect();
                $responsablesCopie = collect();

                if (is_array($copie) && count($copie)) {
                    $directionsCopie = Direction::find($copie);
                    foreach ($directionsCopie as $directionItem) {
                        if ($directionItem?->secretaires->count()) {
                            $secretairesCopie->push($directionItem->secretaires->pluck('responsable_id')->toArray());
                        }
                        if ($directionItem?->responsable_id) {
                            $responsablesCopie->push($directionItem->responsable_id);
                        }
                    }
                    $secretairesCopie = $secretairesCopie->flatten()->unique();
                    $responsablesCopie = $responsablesCopie->unique();
                }

                if ($secretairesCopie->count()) {
                    $courrier->followers()->attach($secretairesCopie->toArray());
                }
                if ($responsablesCopie->count()) {
                    $courrier->followers()->attach($responsablesCopie->toArray());
                }

                $courrier->etapes()->attach(2); // Étape 2 (si applicable)

                // Notification à l'agent destinataire principal
                $notifyAgents = collect([$destinataireAgent])->where('id', '!=', Auth::user()->agent->id); // On notifie l'agent destinataire s'il n'est pas le créateur
                if ($notifyAgents->count()) {
                    event(new CourrierCreated($courrier, $notifyAgents, 'Un nouveau courrier interne vous a été envoyé !'));
                }

                // Notification aux followers (ceux en copie) qui ne sont pas déjà notifiés
                // On exclut l'agent créateur et l'agent destinataire principal
                $idsToExclude = collect([Auth::user()->agent->id, $destinataireAgent->id])->unique()->toArray();
                $notifyFollowers = $courrier->followers->whereNotIn('id', $idsToExclude);

                if ($notifyFollowers->count()) {
                    event(new CourrierCreated($courrier, $notifyFollowers, 'Votre direction a été mise en copie d\'un nouveau courrier interne !'));
                }

                // Historique
                Historique::create([
                    "key" => "Numérisation du courrier interne",
                    "historiquecable_id" => $courrier->id,
                    "historiquecable_type" => Courrier::class,
                    "description" => "A numérisé le courrier interne destiné à l'agent " . $destinataireAgent->nom_complet, // Exemple d'amélioration
                    "user_id" => Auth::user()->id
                ]);

                $content = json_encode([
                    'name' => 'Courriers',
                    'statut' => 'success',
                    'message' => 'Courrier interne numérisé et envoyé à l\'agent avec succès !',
                ]);

            }  else { // BLOC ELSE GÉNÉRAL : Pour tous les types non 1 ou 3
                // Le message d'erreur par défaut défini au début sera utilisé.
            }

        } catch (\Throwable $th) {
            Log::error("Erreur store courrier : " . $th->getMessage(), [
                'file' => $th->getFile(),
                'line' => $th->getLine(),
                'trace' => $th->getTraceAsString(),
            ]);

            $content = json_encode([
                'name' => 'Courrier',
                'statut' => 'error',
                'message' => 'Impossible de numériser le courrier, une erreur s\'est produite.',
            ]);
        }

        session()->flash('session', $content);
        return redirect()->route('regidoc.courriers.index');
    }

    /**
     * Show the form for completing courrier information
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showCompleteForm($id)
    {
        $courrier = Courrier::with([
            'document', 
            'type', 
            'nature', 
            'categorie',
            'expediteur',
            'externExpediteur',
            'externDestinateur',
            'priorite',
            'service',
            'destinateurs'
        ])->findOrFail($id);
        
        // Vérifier que le courrier est en attente de saisie
        if ($courrier->etape !== 'en_attente') {
            $content = json_encode([
                'name' => 'Courrier',
                'statut' => 'error',
                'message' => 'Ce document a déjà été traité',
            ]);
            session()->flash('session', $content);
            return redirect()->route('regidoc.courriers.index');
        }

        // Charger les données nécessaires pour le formulaire
        $types = CourrierType::all();
        $natures = CourrierNature::all();
        $categories = CourrierCategory::all();
        $services = Service::all();
        $directions = Direction::all();
        $agents = Agent::actif()->get();
        $priorites = Priorite::all();
        $traitements = CourrierTypesTraitement::all();
        $selectedDoc = false; // Initialisation de la variable
        $isFormValid = true; // Initialisation de la variable pour la validation du formulaire

        return view('regidoc.pages.courriers.complete-form', [
            'courrier' => $courrier,
            'types' => $types,
            'natures' => $natures,
            'directions' => $directions,
            'categories' => $categories,
            'services' => $services,
            'agents' => $agents,
            'priorites' => $priorites,
            'traitements' => $traitements,
            'selectedDoc' => $selectedDoc,
            'isFormValid' => $isFormValid,]);
        }
    public function complete(Request $request, $id)
    {
        try {
            $courrier = Courrier::findOrFail($id);
            
            // Vérifier que le courrier est en attente de saisie
            if ($courrier->etape !== 'en_attente') {
                return response()->json([
                    'success' => false,
                    'message' => 'Ce document a déjà été traité',
                ], 400);
            }

            // Valider les données du formulaire
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'expediteur' => 'required|string|max:255',
                'reference_courrier' => 'required|string|max:100',
                'date_du_courrier' => 'required|date',
                'date_arrive' => 'required|date',
                'objet' => 'required|string',
                'nature_id' => 'required|exists:courrier_natures,id',
                'categorie_id' => 'required|exists:courrier_categories,id',
                'priorite_id' => 'nullable|exists:priorites,id',
                'traitement_id' => 'nullable|exists:courrier_types_traitements,id',
                'confidentiel' => 'boolean',
            ]);

            // Mettre à jour le courrier avec les informations fournies
            $courrier->update([
                'title' => $validatedData['title'],
                'exped_externe' => $validatedData['expediteur'],
                'reference_courrier' => $validatedData['reference_courrier'],
                'date_du_courrier' => $validatedData['date_du_courrier'],
                'date_arrive' => $validatedData['date_arrive'],
                'objet' => $validatedData['objet'],
                'nature_id' => $validatedData['nature_id'],
                'category_id' => $validatedData['categorie_id'],
                'priorite_id' => $validatedData['priorite_id'] ?? null,
                'traitement_id' => $validatedData['traitement_id'] ?? null,
                'confidentiel' => $request->has('confidentiel') ? 1 : 0,
                'etape' => 'termine', // Marquer comme terminé
                'statut_id' => 2, // Marquer comme traité
            ]);

            // Ajouter une entrée d'historique
            Historique::create([
                "key" => "Saisie des informations",
                "historiquecable_id" => $courrier->id,
                "historiquecable_type" => Courrier::class,
                "description" => "A complété les informations du courrier",
                "user_id" => Auth::id(),
            ]);

            // Notifier les utilisateurs concernés
            // (À implémenter selon vos besoins)

            return response()->json([
                'success' => true,
                'message' => 'Informations enregistrées avec succès',
                'redirect' => route('regidoc.courriers.show', $courrier->id)
            ]);

        } catch (\Exception $e) {
            Log::error('Erreur lors de la complétion du courrier: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de l\'enregistrement des informations',
                'error' => $e->getMessage()
            ], 500);
        }
    }

 
    public function edit(Courrier $courrier)
    {
        $types = CourrierType::all();
        $services = Service::all();
        $agents = Agent::all();
        $natures = CourrierNature::select('id', 'titre')->get();

        return view('regidoc.pages.courriers.edit-doc', compact('courrier', 'types', 'services', 'agents', 'natures'));
    }
 
    public function update(Request $request, $id)
    {
        try {

            $destinateur = $request->get('destination');
            $isConfidentiel = ($request->confidentiel == 'on' || $request->confidentiel == 1) ? 1 : 0;
            $copie = $request->get('copie');

            if ($isConfidentiel) {
                $destinateur = 1;
                $copie = [1];
            }

            if (!$request->has('copie')) {
                $copie = [1];
            }

            $document = null;

            if ($request->hasFile('document') && ($request->document_id == null || $request->document_id == '')) {

                $classeur = Classeur::firstOrCreate([
                    'titre' => Auth::user()->agent->direction?->lieu?->titre ?? 'Region inconnu',
                ],[
                    'reference' => 'DIR'.Str::padLeft(Classeur::count() + 1,4,0),
                    'direction_id' => Agent::find($destinateur)?->direction_id,
                    'created_by' => Auth::user()->agent->id
                ]);

                $dossier = Dossier::firstOrCreate([
                    'titre' => 'Courriers',
                    'classeur_id' => $classeur->id,
                ],[
                    'reference' => 'DIR'.Str::padLeft(Classeur::count() + 1,4,0),
                    'created_by' => Auth::user()->agent->id,
                    'updated_by' => Auth::user()->agent->id,
                ]);

                // $dossier = Dossier::where('titre', 'Courriers')->first();
                // $classeur = null;

                // if ($dossier != null) {
                //     if ($dossier->classeur) {
                //         $classeur = $dossier->classeur;
                //     } else {
                //         $classeur = Classeur::create(['titre' => 'Courriers']);
                //     }
                // } else {
                //     $classeur = Classeur::create([
                //         'titre' => 'Courriers',
                //         'reference' => $request->get('ref'),
                //         'direction_id' => Auth::user()->agent->direction_id,
                //         'created_by' => Auth::user()->agent?->id,
                //         'updated_by' => Auth::user()->agent?->id,
                //     ]);

                //     $dossier = Dossier::create([
                //         'titre' => 'Courriers',
                //         'reference' => $request->get('ref'),
                //         'classeur_id' => $classeur?->id,
                //         'created_by' => Auth::user()->agent?->id,
                //         'updated_by' => Auth::user()->agent?->id,
                //     ]);
                // }

                $document = new Document();
                $document->dossier_id = $dossier?->id;
                $document->reference = $request->get('ref');
                $document->category_id = $request->get('categorie');
                $document->libelle = $request->get('title');
                $document->type = $request->get('type');
                $document->document = (new File())->handle($request, 'document', 'documents');
                $document->user_id = Auth::user()?->id;
                $document->statut_id = 1;
                $document->created_by = Auth::user()->agent?->id;
                $document->save();
            } elseif ($request->has('document_id') && ($request->document_id != null || $request->document_id != '')) {
                $document = Document::find($request->document_id);
            }

            $courrier = Courrier::find($id);
            $courrier->type_id = $request->get('type');
            $courrier->category_id = $request->get('categorie');
            $courrier->traitement_id = $request->get('traitement_id');
            $courrier->exped_interne_id = $request->get('exp_int');
            $courrier->exped_externe = $request->get('exp');
            $courrier->dest_interne_id = $destinateur;
            $courrier->departement_id = $request->get('service');
            $courrier->service_id = $request->get('service');
            $courrier->service_traitant_id = $request->get('service_traitant');
            $courrier->title = $request->get('title');
            $courrier->reference_courrier = $request->get('ref');
            $courrier->confidentiel = $request->get('confidentiel') == true ? '1' : '0';
            $courrier->priorite_id = $request->get('priorite');
            $courrier->created_by = Auth::user()->id;
            $courrier->date_du_courrier = $request->get('date-doc');
            $courrier->date_arrive = $request->get('date-arriv');
            $courrier->date_fin = $request->get('date-limite');
            $courrier->nature_id = $request->get('nature');
            $courrier->objet = $request->get('objet');
            $courrier->traitement_id = $request->get('traitement_id');
            $courrier->document_id = $document?->id;
            $courrier->save();

            if (count($copie)) {
                $courrier->followers()->attach($copie);
            }

            $content = json_encode([
                'name' => 'Courriers',
                'statut' => 'success',
                'message' => 'Courrier modifié avec succès !',
            ]);
        } catch (\Throwable $th) {
            // dd($th);
            $content = json_encode([
                'name' => 'Courrier',
                'statut' => 'error',
                'message' => 'Impossible de modifier le courrier, une erreur s\'est produite',
            ]);
        }

        session()->flash(
            'session',
            $content
        );

        return redirect()->route('regidoc.courriers.index')->with('success', 'le courrier a étè créee avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $courrier = Courrier::find($id);
        $courrier->delete();
        return redirect()->route('regidoc.courriers.index');
    }

    /**
     * Exporte l'historique d'un courrier au format PDF
     *
     * @param int $id ID du courrier
     * @return \Illuminate\Http\Response
     */
    public function exportHistoriquePdf($id)
    {
        $courrier = Courrier::with(['document', 'historiques' => function($query) {
            $query->orderBy('created_at', 'desc');
        }, 'historiques.user.agent'])->findOrFail($id);

        $pdf = PDF::loadView('regidoc.pages.courriers.pdf.historique', compact('courrier'))
                 ->setPaper('a4', 'portrait')
                 ->setOptions([
                     'isHtml5ParserEnabled' => true,
                     'isRemoteEnabled' => true,
                     'defaultFont' => 'Arial'
                 ]);

        $filename = 'historique-courrier-' . $courrier->id . '-' . now()->format('Y-m-d') . '.pdf';
        
        return $pdf->download($filename);
    }

    /**
     * Valider un courrier
     *
     * @param  \App\Models\Courrier  $courrier
     * @return \Illuminate\Http\Response
     */
    
    public function valider(Courrier $courrier)
{
    try {
        // S'assurer que $courrier est un objet valide
        if (!($courrier instanceof Courrier)) {
            $courrier = Courrier::find($courrier);
            if (!$courrier) {
                return response()->json([
                    'success' => false,
                    'message' => 'Courrier introuvable.'
                ], 404);
            }
        }

        // Traitement selon type_id
        if ($courrier->type_id == 1) { // Courrier entrant
            $courrier->mark_as_done = 1;
            $courrier->save();

            // Marquer document comme "Traité"
            if ($courrier->document) {
                $courrier->document->statut_id = 5; // Traité
                $courrier->document->save();
            }

            $traitement = new CourrierTraitement();
            $traitement->agent_id = Auth::user()->agent->id;
            $traitement->note = 'Document traité';
            $traitement->save();

            $courrier->traitements()->attach($traitement);
            $courrier->etapes()->attach(3); // Étape assistant

            // Création du courrier sortant
            $oldata = $courrier->getAttributes();
            unset($oldata['id'], $oldata['updated_at'], $oldata['created_at']);

            $nouveau_destinataire = CourrierDestinateurExterne::where('nom', $courrier->externExpediteur->nom)->first();
            $extern_destinataire = $nouveau_destinataire ?: new CourrierDestinateurExterne(['nom' => $courrier->externExpediteur->nom]);
            if (!$nouveau_destinataire) {
                $extern_destinataire->save();
            }

            $oldata['type_id'] = 2; // Sortant
            $oldata['created_by'] = Auth::user()->id;
            $oldata['exped_externe'] = null;
            $oldata['exped_interne_id'] = Auth::user()->agent->id;
            $oldata['parent_id'] = $courrier->id;
            $oldata['traitement_id'] = null;
            $oldata['mark_as_done'] = null;
            $oldata['reference_interne'] = $this->changeNumRef(2);
            $oldata['dest_externe_id'] = $extern_destinataire->id;

            $newCourrier = $this->saveCourrierSortant(new Courrier($oldata));

            foreach ($courrier->traitements as $traitement) {
                $newCourrier->traitements()->attach($traitement);
            }

            if (Auth::user()->agent->direction->dgAssistanats->pluck('responsable_id')->count()) {
                $newCourrier->destinateurs()->attach(Auth::user()->agent->direction->dgAssistanats->pluck('responsable_id'));
            }

            $newCourrier->etapes()->attach(3);

            $notifyAgents = $newCourrier->destinateurs->where('id', '!=', Auth::user()->agent->id);
            if (count($newCourrier->followers ?? []) > 0) {
                $notifyAgents = $notifyAgents->merge($newCourrier->followers)->flatten();
            }

            if (count($notifyAgents)) {
                event(new CourrierCreated($courrier, $notifyAgents, 'Un nouveau courrier traité vous a été transmis !'));
            }

            $courrier->statut_id = 3;
            $courrier->save();

        } elseif ($courrier->type_id == 3) { // Courrier interne
            $courrier->mark_as_done = 1;
            $courrier->save();

            if ($courrier->document) {
                $courrier->document->statut_id = 5;
                $courrier->document->save();
            }

            $traitement = new CourrierTraitement();
            $traitement->agent_id = Auth::user()->agent->id;
            $traitement->note = 'Document traité';
            $traitement->save();

            $courrier->traitements()->attach($traitement);
            $courrier->statut_id = 3;
            $courrier->save();

        } else {
            // Cas autres types de courrier ? Possibilité d'ajouter ici selon besoin.
            $courrier->statut_id = 3;
            $courrier->save();
        }

        // Ajouter une entrée dans l'historique
        $historique = new Historique();
        $historique->user_id = Auth::id();
        $historique->key = 'courrier_valide';
        $historique->description = 'Le courrier a été marqué comme validé';
        $historique->historiquecable()->associate($courrier);
        $historique->save();

        return response()->json([
            'success' => true,
            'message' => 'Le courrier a été validé et traité avec succès.'
        ]);

    } catch (\Throwable $e) {
        \Log::error('Erreur lors de la validation du courrier', [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString(),
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Une erreur est survenue lors de la validation du courrier: ' . $e->getMessage()
        ], 500);
    }
}

    
    /**
     * Rejeter un courrier
     *
     * @param  \App\Models\Courrier  $courrier
     * @return \Illuminate\Http\Response
     */
//    public function rejeter(Courrier $courrier)
// {
//     try {
//         // Mettre à jour le statut à 4 (rejeté)
//         $courrier->statut_id = 3;
//         $courrier->save();

//         // Ajouter une entrée dans l'historique
//         $historique = new Historique();
//         $historique->user_id = Auth::id();
//         $historique->key = 'courrier_rejete';
//         $historique->description = 'Le courrier a été marqué comme rejeté';
//         $historique->historiquecable()->associate($courrier);
//         $historique->save();

//         return response()->json([
//             'success' => true,
//             'message' => 'Le courrier a été rejeté avec succès.'
//         ]);
//     } catch (\Exception $e) {
//         return response()->json([
//             'success' => false,
//             'message' => 'Une erreur est survenue lors du rejet du courrier: ' . $e->getMessage()
//         ], 500);
//     }
// }
public function rejeter(Courrier $courrier)
{
    try {
        // S'assurer que $courrier est bien un objet
        if (!($courrier instanceof Courrier)) {
            $courrier = Courrier::find($courrier);
            if (!$courrier) {
                return response()->json([
                    'success' => false,
                    'message' => 'Courrier introuvable.'
                ], 404);
            }
        }

        // Traitement en fonction du type de courrier
        if ($courrier->type_id == 1) { // Courrier entrant
            $courrier->mark_as_done = 1;
            $courrier->save();

            // Marquer le document comme traité (statut_id = 5)
            if ($courrier->document) {
                $courrier->document->statut_id = 5;
                $courrier->document->save();
            }

            // Ajouter le traitement "rejeté"
            $traitement = new CourrierTraitement();
            $traitement->agent_id = Auth::user()->agent->id;
            $traitement->note = 'Document rejeté';
            $traitement->save();

            $courrier->traitements()->attach($traitement);
            $courrier->etapes()->attach(3); // Étape 3 (assistant ?)

            $courrier->statut_id = 3; // 4 = Rejeté
            $courrier->save();

        } elseif ($courrier->type_id == 3) { // Courrier interne
            $courrier->mark_as_done = 1;
            $courrier->save();

            if ($courrier->document) {
                $courrier->document->statut_id = 5;
                $courrier->document->save();
            }

            $traitement = new CourrierTraitement();
            $traitement->agent_id = Auth::user()->agent->id;
            $traitement->note = 'Document rejeté';
            $traitement->save();

            $courrier->traitements()->attach($traitement);

            $courrier->statut_id = 3; // 4 = Rejeté
            $courrier->save();

        } else {
            // Autres types de courrier
            $courrier->statut_id = 3;
            $courrier->save();
        }

        // Historique du rejet
        $historique = new Historique();
        $historique->user_id = Auth::id();
        $historique->key = 'courrier_rejete';
        $historique->description = 'Le courrier a été marqué comme rejeté';
        $historique->historiquecable()->associate($courrier);
        $historique->save();

        return response()->json([
            'success' => true,
            'message' => 'Le courrier a été rejeté avec succès.'
        ]);
    } catch (\Throwable $e) {
        \Log::error('Erreur lors du rejet du courrier', [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString(),
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Une erreur est survenue lors du rejet du courrier: ' . $e->getMessage()
        ], 500);
    }
}

    public function scan(Request $request)
    {
        return response(['status' => $request]);
        try {
            $fileName = 'file.pdf';
            $path = $request->file('pdf')->storeAs('public' . DIRECTORY_SEPARATOR . 'tmp_scanne', $fileName);
            return response()->json(['message' => 'Fichier PDF téléchargé avec succès'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => "Une erreur s'est produite lors du téléchargement du fichier PDF."], 500);
        }
    }



    /**
     * Generate a unique filename
     *
     * @param  mixed  $file
     * @param  string  $path
     * @return string
     */
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

    /**
     * Move a created document to its final location
     *
     * @param  string  $fileName
     * @return string
     */
    public function moveCreatedDoc($fileName)
    {
        $filesPath = [];
        $path = 'documents' . DIRECTORY_SEPARATOR . date('FY') . DIRECTORY_SEPARATOR;
        $file = Storage::disk('public')->get('tmp/' . $fileName . '.pdf');

        $filename = $this->generateFileName($file, 'pdf');

        Storage::disk('public')->put($file, $path . $filename . '.pdf');

        array_push($filesPath, [
            'download_link' => $path . $filename . '.' . Str::afterLast($file, '.'),
            'original_name' => 'ads ' . now()->format('dmYhms'),
        ]);

        return json_encode($filesPath);
    }
    
    /**
     * Gère la requête AJAX pour le changement de référence
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeNumRefAjax(Request $request)
    {
        try {
            $typeId = $request->input('type_id');
            $reference = $this->changeNumRef($typeId);
            
            return response()->json([
                'success' => true,
                'reference' => $reference
            ]);
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la génération de la référence: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la génération de la référence.'
            ], 500);
        }
    }
}
