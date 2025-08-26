<?php

namespace App\Http\Controllers\Courriers;

use App\Events\CourrierCreated;
use App\Http\Controllers\Controller;
use App\Http\Controllers\File;
use App\Http\Controllers\ScanFile;
use Illuminate\Support\Facades\File as FileFacade;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Models\Agent;
use App\Models\Classeur;
use App\Models\Courrier;
use App\Models\CourrierNature;
use App\Models\CourriersAnnotation;
use App\Models\CourrierTraitement;
use App\Models\CourrierType;
use App\Models\CourrierTypesTraitement;
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
use App\Models\CourrierDestinateurExterne;
use App\Models\PieceJointe;
use App\Models\AccuseReception;
use Illuminate\Support\Facades\View; // Import manquant ajouté

class CourrierController extends Controller
{
    use SoftDeletes;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * Téléverse une pièce jointe pour un courrier
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Courrier  $courrier
     * @return \Illuminate\Http\Response
     */
    public function uploadPieceJointe(Request $request, Courrier $courrier)
    {
        $request->validate([
            'piece_jointe' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:10240', // 10MB max
        ]);

        try {
            if ($request->hasFile('piece_jointe')) {
                $file = $request->file('piece_jointe');
                $year = now()->format('Y');
                $month = now()->format('m');
                $fileName = time() . '_' . Str::random(8) . '_' . $file->getClientOriginalName();
                
                // Créer la structure de dossiers si elle n'existe pas
                $basePath = "pieces-jointes/{$year}/{$month}/courrier-{$courrier->id}";
                $destinationPath = storage_path('app/public/' . $basePath);
                
                if (!FileFacade::exists($destinationPath)) {
                    FileFacade::makeDirectory($destinationPath, 0755, true);
                }
                
                // Déplacer le fichier téléversé
                $path = $file->storeAs($basePath, $fileName, 'public');
                
                // Enregistrer la pièce jointe dans la base de données
                $pieceJointe = new PieceJointe([
                    'nom' => $file->getClientOriginalName(),
                    'chemin' => $path,
                    'taille' => $file->getSize(),
                    'mime_type' => $file->getMimeType(),
                    'courrier_id' => $courrier->id,
                    'uploaded_by' => auth()->id(),
                ]);
                
                $courrier->piecesJointes()->save($pieceJointe);
                
                // Retourner la réponse au format JSON attendu
                $content = json_encode([
                    'name' => 'Courrier',
                    'statut' => 'error',
                    'message' => 'Ajout d\'une pièce jointe'
                ]);
            
        
            session()->flash('session', $content);
            return redirect()->back();
            
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Aucun fichier n\'a été téléversé.'
            ], 400);
        } catch (\Exception $e) {
            Log::error('Erreur lors du téléversement de la pièce jointe : ' . $e->getMessage());
            $content = json_encode([
                'name' => 'Courrier',
                'statut' => 'error',
                'message' => 'Impossible d\'ajouter une pièce jointe'
            ]);
        
    
        session()->flash('session', $content);
        return redirect()->back();
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
        $sec = Direction::find(1)->dgSecretaires->pluck('responsable_id');
        $isSec = $sec->contains(auth()->id());

        return view('regidoc.pages.courriers.courriers', compact('isSec'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create(Request $request)
    // {

    //     if ($request->has('newdoc')) {
    //         $types = CourrierType::all();
    //         $services = Service::all();
    //         $agents = Agent::actif()->select('id','user_id','direction_id','nom','post_nom','prenom','division_id','service_id','fonction_id')->get();
    //         $natures = CourrierNature::select('id', 'titre')->get();
    //         $sec = Direction::find(1)->dgSecretaires->pluck('responsable_id');
    //         $isDestinateur = $sec->contains(auth()->id());
    //         $newDoc = $request->newdoc;
    //         $textSelected = $request->textSelected;
    //         $fileName = $request->fileName;

    //         return view('regidoc.pages.courriers.new-doc')->with([
    //             'types' => $types,
    //             'services' => $services,
    //             'agents' => $agents,
    //             'natures' => $natures,
    //             'newDoc' => $newDoc,
    //             'textSelected' => $textSelected,
    //             'fileName' => $fileName,
    //             'sec'=> $sec,
    //             'isDestinateur' => $isDestinateur,
    //         ]);

    //     } else {
    //         $agents = Agent::actif()->select('id','user_id','direction_id','nom','post_nom','prenom','division_id','service_id','fonction_id')->get();

    //         $types = CourrierType::select('id', 'titre')->get();
    //         $services = Service::select('id', 'titre','responsable_id')->get();
    //         $natures = CourrierNature::select('id', 'titre')->get();
    //         $sec = Direction::find(1)->dgSecretaires->pluck('responsable_id');
    //         $isDestinateur = $sec->contains(auth()->id());


    //         return view('regidoc.pages.courriers.new-doc', compact('types', 'services', 'natures','agents','sec','isDestinateur'));
    //     }

    // }
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

    return view('regidoc.pages.courriers.new-doc', $viewData);
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
        Log::info('🟢 Début du traitement');

        // Récupération du courrier s'il s'agit d'un ID
        $courrier = $courrier instanceof Courrier ? $courrier : Courrier::find($courrier);
        Log::info('📩 Courrier chargé', ['courrier_id' => optional($courrier)->id]);

        if (!$courrier) {
            throw new \Exception('Courrier introuvable.');
        }

        // 📥 Courrier entrant
        if ($courrier->type_id == 1) {
            Log::info('➡️ Traitement du courrier entrant');

            $courrier->mark_as_done = 1;
            $courrier->save();
            Log::info('✅ Courrier marqué comme traité');

            if ($courrier->document) {
                $courrier->document->statut_id = 5; // 5 = "Traité"
                $courrier->document->save();
                Log::info('🗂️ Document marqué comme traité', ['document_id' => $courrier->document->id]);
            }

            $agentId = Auth::user()->agent->id;
            Log::info('👤 Agent identifié', ['agent_id' => $agentId]);

            $traitement = new CourrierTraitement();
            $traitement->agent_id = $agentId;
            $traitement->note = 'Document traité';
            $traitement->save();
            Log::info('📝 Traitement enregistré', ['traitement_id' => $traitement->id]);

            $courrier->traitements()->attach($traitement);
            $courrier->etapes()->attach(3); // Étape assistant
            Log::info('🔁 Traitement et étape ajoutés');

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
                Log::info('📦 Nouveau destinataire externe créé', ['dest_id' => $extern_destinataire->id]);
            }

            $oldata['type_id'] = 2; // Sortant
            $oldata['created_by'] = Auth::user()->id;
            $oldata['exped_externe'] = null;
            $oldata['exped_interne_id'] = $agentId;
            $oldata['parent_id'] = $courrier->id;
            $oldata['traitement_id'] = null;
            $oldata['mark_as_done'] = null;
            $oldata['date_du_courrier'] = $courrier->date_du_courrier;
            $oldata['reference_interne'] = $this->changeNumRef(2);
            $oldata['dest_externe_id'] = $extern_destinataire->id;
            

            $newCourrier = $this->saveCourrierSortant(new Courrier($oldata));
            Log::info('📨 Courrier sortant créé', ['new_courrier_id' => $newCourrier->id]);

            foreach ($courrier->traitements as $t) {
                $newCourrier->traitements()->attach($t);
            }

            $dgResponsables = Auth::user()->agent->direction->dgAssistanats->pluck('responsable_id');
            if ($dgResponsables->count()) {
                $newCourrier->destinateurs()->attach($dgResponsables);
                Log::info('👥 Responsables attachés', ['ids' => $dgResponsables]);
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
                Log::info('📢 Notification envoyée', ['agents' => $notifyAgents->pluck('id')]);
            }

            $courrier->statut_id = 3;
            $courrier->save();
            Log::info('🟩 Statut du courrier entrant mis à jour');
        }

        // 📨 Courrier interne
        elseif ($courrier->type_id == 3) {
            Log::info('➡️ Traitement du courrier interne');

            $courrier->mark_as_done = 1;
            $courrier->save();

            if ($courrier->document) {
                $courrier->document->statut_id = 5;
                $courrier->document->save();
                Log::info('🗂️ Document interne marqué comme traité');
            }

            $traitement = new CourrierTraitement();
            $traitement->agent_id = Auth::user()->agent->id;
            $traitement->note = 'Document traité';
            $traitement->save();

            $courrier->traitements()->attach($traitement);
            $courrier->statut_id = 3;
            $courrier->save();
            Log::info('🟩 Courrier interne mis à jour avec traitement');
        }

        $response = [
            'name' => 'Courrier',
            'statut' => 'success',
            'message' => 'Le courrier a été marqué comme traité',
        ];

        Log::info('✅ Fin du traitement avec succès');

        if (request()->ajax()) {
            return response()->json($response, 200, ['Content-Type' => 'application/json']);
        } else {
            session()->flash('session', json_encode($response));
            return redirect()->back();
        }

    } catch (\Throwable $th) {
        Log::error('❌ Erreur lors du traitement du courrier', [
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
    if ($doc == null) {

        // Cas où c’est un scan ou un document déjà sélectionné
        if (($request?->is_scan ?? false) == "true" || ($request?->has('selected_doc') && !empty($request->selected_doc))) {

            $document = new Document();
            $document->dossier_id = $dossier->id;
            $document->reference = is_array($request->get('ref')) ? implode(', ', $request->get('ref')) : $request->get('ref');
            $document->category_id = $request->get('categorie');
            $document->libelle = $request->get('title');
            $document->type = $request->get('type');

            if (($request->is_scan ?? false) == "true") {
                // Stockage du fichier scanné (à adapter selon ta logique ScanFile)
                $document->document = (new ScanFile())->handle('documents');
            } else {
                // Déplacer un fichier sélectionné déjà uploadé en temporaire
                $document->document = $this->moveCreatedDoc($request->selected_doc);
            }

            $document->user_id = Auth::user()->id;
            $document->statut_id = 1;
            $document->created_by = Auth::user()->agent->id;
            $document->save();

            return $document;
        }

        // Cas d'un upload via formulaire (input file)
        if ($request->hasFile('document') && (empty($request->document_id))) {

            $document = new Document();
            $document->dossier_id = $dossier->id;
            $document->reference = $request->get('ref');
            $document->category_id = $request->get('categorie');
            $document->libelle = $request->get('title');
            $document->type = $request->get('type');

            // Utilisation de la classe File pour stocker le fichier
            $document->document = (new File())->handle($request, 'document', 'documents');

            $document->user_id = Auth::user()->id;
            $document->statut_id = 1;
            $document->created_by = Auth::user()->agent->id;
            $document->save();

            return $document;
        } 
        
        // Cas où on utilise un document existant via son ID
        elseif ($request->has('document_id') && !empty($request->document_id)) {
            return Document::find($request->document_id);
        }

    } else {
        // Cas où on crée un nouveau document à partir d’un autre objet $doc existant
        $document = Document::create([
            'dossier_id' => $dossier->id,
            'reference' => is_array($doc->reference) ? implode(', ', $doc->reference) . '/R' : $doc->reference . '/R',
            'category_id' => $doc->category_id,
            'libelle' => $doc->libelle,
            'type' => $doc->type,
            'document' => $doc->document ?? (new File())->handle($request, 'document', 'documents'),
            'user_id' => Auth::user()->id,
            'statut_id' => 1,
            'created_by' => Auth::user()->agent->id,
        ]);

        return $document;
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

    /**
     * Génère une référence unique pour un nouveau courrier
     * 
     * @param int $type 1=Entrant, 2=Sortant, 3=Interne
     * @return string
     */
    public function changeNumRef($type)
    {
        // Vérifier que le type est valide
        if (!in_array($type, [1, 2, 3])) {
            Log::error('Type de courrier invalide:', ['type' => $type]);
            throw new \InvalidArgumentException('Type de courrier invalide. Doit être 1, 2 ou 3.');
        }
        
        // Récupérer l'abréviation de la direction
        $abbreviation = $this->abbreviateTitle(Auth::user()->agent->direction?->lieu?->titre);
        $typeText = Str::limit($type == 1 ? 'ENTRANT' : ($type == 2 ? "SORTANT" : "INTERNE"), 3, '');
        
        // Démarrer une transaction pour éviter les accès concurrentiels
        return \DB::transaction(function () use ($abbreviation, $typeText, $type) {
            // Récupérer le dernier numéro utilisé pour cette direction et ce type
            $lastRef = Courrier::where('reference_interne', 'LIKE', $abbreviation . '-%')
                ->orderBy('id', 'desc')
                ->value('reference_interne');
            
            $nextNum = 1; // Valeur par défaut si aucun enregistrement trouvé
            
            if ($lastRef) {
                // Extraire le numéro de la dernière référence
                if (preg_match('/-([0-9]+)-[A-Z]+$/', $lastRef, $matches)) {
                    $nextNum = (int)$matches[1] + 1;
                }
            }
            
            // Essayer jusqu'à 100 fois de trouver une référence unique
            $maxAttempts = 100;
            $attempt = 0;
            
            do {
                // Formater le numéro avec 4 chiffres
                $formattedNum = str_pad($nextNum, 4, '0', STR_PAD_LEFT);
                
                // Créer la nouvelle référence
                $newRef = "{$abbreviation}-{$formattedNum}-{$typeText}";
                
                // Vérifier si la référence existe déjà
                $exists = Courrier::where('reference_interne', $newRef)->exists();
                
                if (!$exists) {
                    return $newRef; // Référence unique trouvée
                }
                
                $nextNum++;
                $attempt++;
                
            } while ($attempt < $maxAttempts);
            
            // Si on arrive ici, on n'a pas trouvé de référence unique après plusieurs tentatives
            throw new \RuntimeException(
                'Impossible de générer une référence unique après ' . $maxAttempts . ' tentatives. '
                . 'Dernière référence essayée : ' . $newRef
            );
        });
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
        // dd($request);
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
     * Méthode helper pour créer un document.
     * Vous devez la définir ou vous assurer qu'elle existe.
     */
    

    public function show($id)
    {
        $courrier = Courrier::with(['document', 'views', 'type', 'accuseReceptions.user.agent'])->where('id', $id)->firstOrFail();
        
        if (!$courrier) {
            abort(404, 'Courrier non trouvé');
        }

        $viewsForThisUser = $courrier->views->where('user_id', Auth::id())->count();

        $this->authorize('view', $courrier);

        views($courrier)->once($viewsForThisUser > 0)->record();

        // Vérifier si l'utilisateur est DG et créer un accusé de réception si nécessaire
        $user = Auth::user();
        if ($user->agent && $user->agent->isDG()) {
            $existingAccuse = AccuseReception::where('user_id', $user->id)
                ->where('courrier_id', $courrier->id)
                ->first();

            if (!$existingAccuse) {
                AccuseReception::create([
                    'user_id' => $user->id,
                    'courrier_id' => $courrier->id,
                ]);
            }
        }

        $classeurs = Classeur::all();
        $dossiers = Dossier::all();
        $directions = Direction::all();
        $traitements = Auth::user()->agent->isDG() || Auth::user()->agent->isDGA()  
            ? CourrierTypesTraitement::withTrashed()->select('id', 'titre')->get() 
            : CourrierTypesTraitement::withTrashed()->select('id', 'titre')->get();
        $priorites = Priorite::select('id', 'titre')->get();

        return view('regidoc.pages.courriers.show-courrier', compact('directions', 'courrier', 'classeurs', 'dossiers','traitements','priorites'));
    }

 
    public function edit(Courrier $courrier)
    {
        $types = CourrierType::all();
        $services = Service::all();
        $agents = Agent::all();
        $natures = CourrierNature::select('id', 'titre')->get();
        
        return view('regidoc.pages.courriers.edit-doc', compact('courrier', 'types', 'services', 'agents', 'natures'));
    }
 
    protected function updateDocument(Request $request, Document $document, $dossierId)
{
    $document->dossier_id = $dossierId;
    $document->reference = is_array($request->get('ref')) 
        ? implode(', ', $request->get('ref')) 
        : $request->get('ref');
    $document->category_id = $request->get('categorie');
    $document->libelle = $request->get('title');
    $document->type = 1;
    $document->description = $request->get('description') ?? $document->description;

    $document->confidentiel = $request->has('confidentiel') && 
                              ($request->confidentiel == 'on' || $request->confidentiel == 1) 
                              ? 1 : 0;

    if ($request->hasFile('document')) {
        if (!empty($document->document) && Storage::disk('documents')->exists($document->document)) {
            Storage::disk('documents')->delete($document->document);
        }
        $document->document = (new File())->handle($request, 'document', 'documents');
    }

    $document->user_id = Auth::user()->id;
    $document->statut_id = 1;
    $document->save();

    return $document;
}

public function update(Request $request, $id)
{
    $content = json_encode([
        'name' => 'Courrier',
        'statut' => 'error',
        'message' => 'Impossible de modifier le courrier, une erreur s\'est produite.',
    ]);
//  dd($request);
    try {
        $courrier = Courrier::find($id);
        if (!$courrier) {
            $content = json_encode([
                'name' => 'Courrier',
                'statut' => 'error',
                'message' => 'Courrier introuvable pour la modification.',
            ]);
            session()->flash('session', $content);
            return redirect()->route('regidoc.courriers.index');
        }

        $destinateur = $request->get('destination');
        $isConfidentiel = ($request->confidentiel == 'on' || $request->confidentiel == 1) ? 1 : 0;
        $copie = $request->get('copie', []);

        if ($isConfidentiel) {
            $destinateur = 1;
            $copie = [1];
        }

        if (!$request->has('copie') && !$isConfidentiel) {
            $copie = [];
        }

        $document = null;

        if ($courrier->document) {
            $dossierId = $courrier->document->dossier_id;
            $document = $this->updateDocument($request, $courrier->document, $dossierId);
        } else {
            $document = $this->createDocument($request, $courrier->dest_interne_id ?? $destinateur);
        }

        $courrier->category_id = $request->get('categorie');
        $courrier->traitement_id = $request->get('traitement_id');
        $courrier->exped_interne_id = $request->get('exp_int');
        $courrier->exped_externe = $request->get('exp');
        $courrier->dest_interne_id = $destinateur;

        if ($courrier->type_id == 3 && $destinateur) {
            $destinataireAgent = Agent::find($destinateur);
            $courrier->departement_id = $destinataireAgent->departement_id ?? null;
            $courrier->service_id = $destinataireAgent->service_id ?? null;
            $courrier->service_traitant_id = $destinataireAgent->direction_id ?? null;
        } else {
            // $courrier->departement_id = $request->get('service');
            $courrier->service_id = $request->get('service');
            $courrier->service_traitant_id = $request->get('service_traitant');
        }

        $courrier->title = $request->get('title');
        $courrier->reference_courrier = $request->get('ref');
        $courrier->confidentiel = $isConfidentiel ? '1' : '0';
        $courrier->priorite_id = $request->get('priorite');
        $courrier->date_du_courrier = $request->get('date-doc');
        // $courrier->date_arrive = $request->get('date-arriv');
        $courrier->date_fin = $request->get('date-limite');
        $courrier->nature_id = $request->get('nature');
        $courrier->objet = $request->get('objet');
        $courrier->document_id = $document?->id;
        $courrier->etape = 'termine';
        $courrier->save();

        if ($courrier->type_id == 1 && $destinateur) {
            $courrier->destinateurs()->sync([$destinateur]);
        } elseif ($courrier->type_id == 3 && $destinateur) {
            $courrier->destinateurs()->sync([$destinateur]);
        }

        if (!empty($copie)) {
            $courrier->followers()->sync($copie);
        } else {
            $courrier->followers()->detach();
        }

        Historique::create([
            "key" => "Mise à jour du courrier",
            "historiquecable_id" => $courrier->id,
            "historiquecable_type" => Courrier::class,
            "description" => "A mis à jour le courrier.",
            "user_id" => Auth::user()->id,
        ]);

        $content = json_encode([
            'name' => 'Courriers',
            'statut' => 'success',
            'message' => 'Courrier mis à jour avec succès !',
        ]);
    } catch (\Throwable $th) {
        dd([
            'message' => $th->getMessage(),
            'file' => $th->getFile(),
            'line' => $th->getLine(),
            'trace' => $th->getTraceAsString(),
        ]);
    }

    session()->flash('session', $content);
    return redirect()->route('regidoc.courriers.show', $courrier->id);
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
     * Traiter un courrier (changer son état à 'en_saisie')
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function traiter($id)
    {
        try {
            $courrier = Courrier::findOrFail($id);
            
            // Vérifier que le courrier est bien à l'état 'termine'
            if ($courrier->etape !== 'termine') {
                return response()->json([
                    'success' => false,
                    'message' => 'Le courrier n\'est pas dans un état permettant d\'être traité.'
                ], 422);
            }
            
            // Mettre à jour l'état à 'en_saisie'
            $courrier->etape = 'en_saisie';
            $courrier->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Le courrier a été marqué comme étant en traitement.'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors du traitement du courrier: ' . $e->getMessage()
            ], 500);
        }
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
     * Valider un document
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
            $oldata['date_du_courrier'] = $courrier->date_du_courrier;
             // Use type_id 2 for outgoing mail (Sortant)
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
        Log::error('Erreur lors de la validation du courrier', [
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
     * Rejeter un document
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
        Log::error('Erreur lors du rejet du courrier', [
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
}
