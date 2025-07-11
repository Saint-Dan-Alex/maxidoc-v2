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

use Illuminate\Support\Facades\Log;

class CourrierController extends Controller
{
    use SoftDeletes;
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
                // 'agents' => $agents,
                'natures' => $natures,
                'newDoc' => $newDoc,
                'textSelected' => $textSelected,
                'fileName' => $fileName,
            ]);

        } else {
            $types = CourrierType::select('id', 'titre')->get();
            $services = Service::select('id', 'titre','responsable_id')->get();
            $natures = CourrierNature::select('id', 'titre')->get();
            return view('regidoc.pages.courriers.new-doc', compact('types', 'services', 'natures'));
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

    // public function traitement($courrier)
    // {
    //     try{
    //         $courrier = $courrier instanceOf Courrier ? $courrier : Courrier::find($courrier);
    //         // dd($courrier);
    //         if ($courrier->type_id == 1) { 
    //             $courrier->mark_as_done = 1; //courrier marqué comme traité
    //             $courrier->save();              //enregistrement de ce courrier traité

    //             $traitement = new CourrierTraitement(); //Initialisation d'un nouveau traitement
    //             $traitement->agent_id = Auth::user()->agent->id; //recuperation de l'id de l'authentifié
    //             $traitement->note = 'Document traité';
    //             $traitement->save();

    //             $courrier->traitements()->attach($traitement); //Attachement du traitement au courrier

    //             $courrier->etapes()->attach(3); //Le courrier passe chez l'assistant

    //             // Création du courrier sortant
    //             $oldata = $courrier->getAttributes(); //Initialisation d'un vieux courrier en recupérant les informations du nouveau

    //             unset($oldata['id']);   //suppression de son id
    //             unset($oldata['updated_at']); 
    //             unset($oldata['created_at']);

    //             //  $destinateurs = Direction::find(1)->dgSecretaires->pluck('responsable_id'); // à ne pas décommenter
    //             // $destinateur = Auth::user()->agent->direction->secretaire->id ?? null; // à ne pas décommenter
    //             // $doc = $courrier->traitements->where('document_url', '!=', null)->last(); // à ne pas décommenter
    //             // $document = $this->createDocument(null, $destinateurs->first(), $doc ? $doc : $courrier->document); // à ne pas décommenter
                
    //             //Unikho
               
    //             $nouveau_destinataire = CourrierDestinateurExterne::where('nom', $courrier->externExpediteur->nom)->first();
    //             $extern_destinataire = null;
    //             if ($nouveau_destinataire) {
    //                 // Si le nom est trouvé, enregistrer l'ID associé dans la variable $externes
    //                 $extern_destinataire = $nouveau_destinataire;
    //             } else {
    //                 // Si le nom n'est pas trouvé, on peut laisser $externes vide ou définir une autre valeur
    //                 $extern_destinataire = new CourrierDestinateurExterne;
    //                 $extern_destinataire->nom = $courrier->externExpediteur->nom;
    //                 $extern_destinataire->save();
    //             } 

                
    //              $oldata['type_id'] = 2;
    //              $oldata['created_by'] = Auth::user()->id;
    //              // $oldata['document_id'] = $document->id ?? null;
    //              $oldata['exped_externe'] = null;
    //              // $oldata['reference_interne'] = Str::padLeft(Courrier::count() + 2, 4, '0');
    //              $oldata['exped_interne_id'] = Auth::user()->agent->id;
    //              $oldata['parent_id'] = $courrier->id;
    //              $oldata['traitement_id'] = null;
    //              $oldata['mark_as_done'] = null;
    //              $oldata['reference_interne'] = $this->changeNumRef(2);
    //              $oldata['dest_externe_id'] = $extern_destinataire->id;
    //              // dd($oldata['dest_externe_id']);
    //              $newCourrier = $this->saveCourrierSortant(new Courrier($oldata)); //newCourrier devient courrier sortant 

    //             foreach($courrier->traitements as $traitement){
    //                 $newCourrier->traitements()->attach($traitement); //on assigne tous les traitements de l'ancien courrier
    //             }

    //             // if ($destinateurs->count()) {
    //             //     $newCourrier->destinateurs()->attach($destinateurs); 
    //             // } 
                
    //             if (Auth::user()->agent->direction->dgAssistanats->pluck('responsable_id')->count()) {
    //                 $newCourrier->destinateurs()->attach(Auth::user()->agent->direction->dgAssistanats->pluck('responsable_id')); //l'assistant est notifié
    //             }

    //             $newCourrier->etapes()->attach(3); //on le passe à l'assistant

    //             $notifyAgents = $newCourrier->destinateurs->where('id', '!=', Auth::user()->agent->id); //tous les autres concernés sont notifiés
    //             if (count($newCourrier->followers ?? []) > 0) {
    //                 $notifyAgents = $notifyAgents->push($newCourrier->followers);
    //                 $notifyAgents = $notifyAgents->flatten();
    //             }

    //             if (count($notifyAgents)) {
    //                 event(new CourrierCreated($courrier, $notifyAgents, 'Un nouveau courrier traité vous a été transmis !')); //on emet l'evenement
    //             }

    //             $courrier->statut_id = 3;
    //             $courrier->save();

    //         } elseif ($courrier->type_id == 3) {

    //             $courrier->mark_as_done = 1;
    //             $courrier->save();

    //             $traitement = new CourrierTraitement();
    //             $traitement->agent_id = Auth::user()->agent->id;
    //             $traitement->note = 'Document traité';
    //             $traitement->save();

    //             $courrier->traitements()->attach($traitement);
    //             $courrier->statut_id = 3;
    //             $courrier->save();

    //         }

    //         $content = json_encode([
    //             'name' => 'Courrier',
    //             'statut' => 'success',
    //             'message' => 'le courrier a été marqué comme traité',
    //         ]);
    //     }catch(\Throwable $th){
    //         // dd($th);
    //         $content = json_encode([
    //             'name' => 'Courrier',
    //             'statut' => 'error',
    //             'message' => 'Impossible de marquer le courrier comme traité, une erreur est survenue',
    //         ]);
    //         // $content = json_encode([
    //         //     'name' => 'Courrier',
    //         //     'statut' => 'success',
    //         //     'message' => 'le courrier a été marqué comme traité',  ]);
         
    //     }

    //     session()->flash(
    //         'session',
    //         $content
    //     );

    //     return redirect()->back();
    // }
    public function traitement($courrier)
{
    try {
        $courrier = $courrier instanceof Courrier ? $courrier : Courrier::find($courrier);

        if ($courrier->type_id == 1) { // Courrier entrant
            $courrier->mark_as_done = 1;
            $courrier->save();

            // ✅ AJOUT : Marquer le document comme "Traité"
            if ($courrier->document) {
                $courrier->document->statut_id = 5; // 5 = "Traité"
                $courrier->document->save();
            }

            $traitement = new CourrierTraitement();
            $traitement->agent_id = Auth::user()->agent->id;
            $traitement->note = 'Document traité';
            $traitement->save();

            $courrier->traitements()->attach($traitement);
            $courrier->etapes()->attach(3); // Étape : assistant

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
        }

        elseif ($courrier->type_id == 3) { // Courrier interne
            $courrier->mark_as_done = 1;
            $courrier->save();

            // ✅ AJOUT : Marquer le document comme "Traité"
            if ($courrier->document) {
                $courrier->document->statut_id = 5; // 5 = "Traité"
                $courrier->document->save();
            }

            $traitement = new CourrierTraitement();
            $traitement->agent_id = Auth::user()->agent->id;
            $traitement->note = 'Document traité';
            $traitement->save();

            $courrier->traitements()->attach($traitement);
            $courrier->statut_id = 3;
            $courrier->save();
        }

        $content = json_encode([
            'name' => 'Courrier',
            'statut' => 'success',
            'message' => 'Le courrier a été marqué comme traité',
        ]);
    } catch (\Throwable $th) {
        //  // Enregistrer l'erreur dans le log Laravel
        //     \Log::error('Erreur lors du traitement du courrier', [
        //         'message' => $th->getMessage(),
        //         'file' => $th->getFile(),
        //         'line' => $th->getLine(),
        //         'stack' => $th->getTraceAsString()
        //     ]);
        $content = json_encode([
            'name' => 'Courrier',
            'statut' => 'error',
            'message' => 'Impossible de marquer le courrier comme traité, une erreur est survenue',
        ]);
        
    }

    session()->flash('session', $content);
    return redirect()->back();
}

    
    public function saveTraitement(Request $request)
    {
        // dd(Auth::user()->agent->direction->dgAssistanats);
        try{
            $traitement = new CourrierTraitement();
            $courrier = Courrier::find($request->courrier_id);

            if (Auth::user()->agent->isAssistant() || Auth::user()->agent->isSecretaire()) {

                // I complete same remaining courrier data
                $courrier->priorite_id = $request->priorite_id;
                $courrier->date_fin = !empty($request->date_limite) || $request->date_limite != null ? $request->date_limite : null;
                $courrier->traitement_id = $request->traitement_id;
                $courrier->save();

                // I save traitement
                $traitement->agent_id = Auth::user()->agent->id;
                $traitement->note = $request->commentaire ?? 'Document traité';
                $traitement->save();

                $courrier->traitements()->attach($traitement);

                if ($courrier->type_id == 1) {

                    // I save annotation
                    if ($request->commentaire) {
                        $annotation = new CourriersAnnotation();
                        $annotation->user_id = Auth::user()->id;
                        $annotation->courrier_id = $courrier->id;
                        $annotation->note = $request->commentaire;
                        $annotation->save();
                    }

                    if(Auth::user()->agent->isAssistant()){
                        // I change the stap
                        $courrier->etapes()->attach(4);

                        $courrier->destinateurs()->attach(Auth::user()->agent->direction->responsable);
                        if (Auth::user()->agent->direction->responsable->delegue_id !== null) {
                            $courrier->destinateurs()->attach(
                                Auth::user()->agent->direction->responsable->delegue_id
                            );
                        }
                    }

                    if (Auth::user()->agent->isSecretaire()) {
                        // I change the stap
                        $courrier->etapes()->attach(3);
                        $courrier->destinateurs()->attach(Auth::user()->agent->direction->dgAssistanats->pluck('responsable_id'));
                    }

                    Historique::create([
                        "key" => "Accusé de reception",
                        "historiquecable_id" => $courrier->id,
                        "historiquecable_type" => Courrier::class,
                        "description" => "A établi un traitement à effectuer le courrier",
                        "user_id" => Auth::user()->id,
                    ]);

                    if (Auth::user()->agent->isSecretaire()) {
                        $agentsToNotify = Agent::find(Auth::user()->agent->direction->dgAssistanats->pluck('responsable_id'));
                        if ((is_iterable($agentsToNotify) && count($agentsToNotify)) || $agentsToNotify) {
                            event(new CourrierCreated($courrier, $agentsToNotify, 'Vous a transmis un nouveau courrier !'));
                        }
                    } elseif (Auth::user()->agent->isAssistant()) {
                        if (Auth::user()->agent->direction->responsable) {
                            event(new CourrierCreated($courrier, Auth::user()->agent->direction->responsable, 'Vous a transmis un nouveau courrier !'));
                        }
                    }

                } elseif ($courrier->type_id == 2) {

                    if (Auth::user()->agent->isAssistant()) {
                        // I change the stap
                        $courrier->etapes()->attach(2);
                        $courrier->destinateurs()->attach(Auth::user()->agent->direction->dgSecretaires); //Unikho
                    }

                    if(Auth::user()->agent->isSecretaire()){
                        $courrier->etapes()->attach(1);

                        if (Auth::user()->agent->direction->service->id == 3) {
                            $courrier->destinateurs()->attach(Auth::user()->agent->direction->service->id);
                        }
                    }

                    Historique::create([
                        "key" => "Accusé de reception",
                        "historiquecable_id" => $courrier->id,
                        "historiquecable_type" => Courrier::class,
                        "description" => "A effectué un traitement sur ce courrier",
                        "user_id" => Auth::user()->id,
                    ]);

                    $destinateurToNotify = $courrier->destinateurs->where('id', '!=', Auth::user()->agent->id);
                    if (count($destinateurToNotify)) {
                        event(new CourrierCreated(
                            $courrier,
                            $destinateurToNotify,
                            'Vous a transmi un courrier sortant !'));
                    }
                }

                elseif ($courrier->type_id == 3){
                    if ($request->commentaire) {

                        $annotation = new CourriersAnnotation();
                        $annotation->user_id = Auth::user()->id;
                        $annotation->courrier_id = $courrier->id;
                        $annotation->note = $request->commentaire;
                        $annotation->save();
                    } 

                    if (Auth::user()->agent->isSecretaire()) {
                        // I change the stap
                        $courrier->etapes()->attach(4);
                        $courrier->destinateurs()->attach(Auth::user()->agent->direction->responsable);
                        if (Auth::user()->agent->direction->responsable->delegue_id !== null) {
                            $courrier->destinateurs()->attach(
                                Auth::user()->agent->direction->responsable->delegue_id
                            );
                        }
                    } 

                    Historique::create([
                        "key" => "Accusé de reception",
                        "historiquecable_id" => $courrier->id,
                        "historiquecable_type" => Courrier::class,
                        "description" => "A effectué un traitement sur ce courrier",
                        "user_id" => Auth::user()->id,
                    ]);

                    if (Auth::user()->agent->isSecretaire()) {
                        $agentsToNotify = Agent::find(Auth::user()->agent->direction->responsable);
                        if ((is_iterable($agentsToNotify) && count($agentsToNotify)) || $agentsToNotify) {
                            event(new CourrierCreated($courrier, $agentsToNotify, 'Vous a transmis un nouveau courrier !'));
                        }      
                    }

                }
            }

            if (count($request->document_files)) {
                $filesPath = [];
                $path = 'courrier-traitements/' . date('FY') . '/';
                foreach ($request->document_files as $document) {
                    $filename = $this->generateFileName($document, $path);
                    $document->storeAs(
                        $path,
                        $filename . '.' . $document->getClientOriginalExtension(),
                        'public'
                    );

                    array_push($filesPath, [
                        'download_link' => $path . $filename . '.' . $document->getClientOriginalExtension(),
                        'original_name' => $document->getClientOriginalName(),
                    ]);
                }

                $traitement->document_url = $filesPath;
                $traitement->save();

                Historique::create([
                    "key" => "Accusé de reception",
                    "historiquecable_id" => $courrier->id,
                    "historiquecable_type" => Courrier::class,
                    "description" => "A joint un fichier à ce courrier",
                    "user_id" => Auth::user()->id,
                ]);
            }
            return response()->json([
                'success' => 1
            ]);
        }catch(\Throwable $th){
            return response()->json([
                'error' => $th->getMessage(),
            ]);
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
    // public function store(Request $request)
    // { 
    //     try {
    //        if ($request->get('type') == 1) {

    //         // $request->validate([
    //         //     'type' => 'required|integer',
    //         //     'categorie' => 'required|integer',
    //         //     'exp' => 'nullable|string',
    //         //     'ref' => 'required|string',
    //         //     'ref_interne' => 'required|string',
    //         //  //    'confidentiel' => 'nullable|boolean',
    //         //     'title' => 'required|string',
    //         //     'nature' => 'required|integer',
    //         //     'date-doc' => 'required|date',
    //         //      'date-arriv' => 'required|date',
    //         //     // 'objet' => 'required|string',
    //         //     // 'traitement_id' => 'nullable|integer',
    //         //     // 'exp_int' => 'nullable|integer',
    //         //     'destination2' => 'nullable|integer',
    //         //  //    'service_init' => 'nullable|integer',
    //         //  //    'service_traitant' => 'nullable|integer',
    //         //     // 'priorite' => 'nullable|integer',
    //         //     // 'date-limite' => 'nullable|date',
    //         //     'document' => 'nullable|file|mimes:pdf',
    //         //  ]);
     
    //           $destinateurs = Direction::find(1)->dgSecretaires->pluck('responsable_id');
    //           if (count($destinateurs) == 0) {
    //              $content = json_encode([
    //                 'name' => 'Courrier',
    //                 'statut' => 'error',
    //                 'message' => 'Impossible d\'envoyer le courrier, car aucun(e) Secretaire n\est affecté(e) à la direction générale',
    //              ]);
    //              session()->flash('session', $content);
    //              return redirect()->route('regidoc.courriers.index');
    //           }
    //           $document = $this->createDocument($request, $destinateurs->first());
    //           $courrier = new Courrier;
    //           $courrier->type_id = $request->get('type');
    //           $courrier->category_id = $request->get('categorie');
    //           $courrier->exped_externe = $request->get('exp');
    //           $courrier->reference_courrier = $request->get('ref');
    //           $courrier->reference_interne = $request->get('ref_interne');
    //           $courrier->confidentiel = $request->get('confidentiel') == true ? '1' : '0';
    //           $courrier->title = $request->get('title');
    //           $courrier->nature_id = $request->get('nature');
    //           $courrier->date_du_courrier = $request->get('date-doc');
    //           $courrier->date_arrive = $request->get('date-arriv');
    //           $courrier->objet = $request->get('objet');
    //           $courrier->document_id = $document?->id;
    //           $courrier->created_by = Auth::user()->agent->id;
    //           $courrier->statut_id = 1;
    //           $courrier->save();
    //           $courrier->destinateurs()->attach($destinateurs);
    //           $courrier->etapes()->attach(2);
    //           $notifyAgents = $courrier->destinateurs->where('id', '!=', Auth::user()->agent->id);
    //           if (count($notifyAgents)) {
    //              event(new CourrierCreated($courrier, $notifyAgents, 'A créé un nouveau courrier !'));  
    //           }
    //           Historique::create([
    //             "key" => "Numérisation du courrier",
    //             "historiquecable_id" => $courrier->id,
    //             "historiquecable_type" => Courrier::class,
    //             "description" => "A numérisé un courrier",
    //             "user_id" => Auth::user()->id,
    //          ]);
    //           $content = json_encode([
    //              'name' => 'Courriers',
    //              'statut' => 'success',
    //              'message' => 'Courrier numérisé avec succès !',
    //           ]);
    //        } elseif($request->get('type') == 3) {
    //           $destinateur_id = $request->get('destination2');
    //           $destinateurs = Direction::find($destinateur_id)?->secretaires->pluck('responsable_id');
    //           $document = $this->createDocument($request, $destinateurs->first());
    //           $courrier = new Courrier;
    //           $courrier->type_id = $request->get('type');
    //           $courrier->category_id = $request->get('categorie');
    //           $courrier->traitement_id = $request->get('traitement_id');
    //           $courrier->exped_interne_id = $request->get('exp_int');
    //           $courrier->dest_interne_id = $destinateurs->first();
    //           $courrier->departement_id = $request->get('service_init');
    //           $courrier->service_id = $request->get('service_init');
    //           $courrier->service_traitant_id = $destinateur_id;
    //           $courrier->title = $request->get('title');
    //           $courrier->reference_courrier = $request->get('ref');
    //           $courrier->reference_interne = $request->get('ref_interne');
    //           $courrier->confidentiel = $request->get('confidentiel') == true ? '1' : '0';
    //           $courrier->priorite_id = $request->get('priorite');
    //           $courrier->created_by = Auth::user()->id;
    //           $courrier->date_du_courrier = $request->get('date-doc');
    //           $courrier->date_arrive = $request->get('date-arriv');
    //           $courrier->date_fin = $request->get('date-limite');
    //           $courrier->nature_id = $request->get('nature');
    //           $courrier->objet = $request->get('objet');
    //           $courrier->traitement_id = $request->get('traitement_id');
    //           $courrier->document_id = $document->id;
    //           $courrier->is_intern = $request->get('type') == 1 ? 1 : 0;
    //           $courrier->statut_id = 1;
    //           $courrier->save();
    //           if ($destinateurs->count()) {
    //              $courrier->destinateurs()->attach($destinateurs);
    //           }
    //           $secretaires = collect();
    //           $responsables = collect();
    //           if (count($copie ?? [])) {
    //              $directions = Direction::find($copie);
    //              foreach ($directions as $direction) {
    //                 if ($direction?->secretaires->count()) {
    //                     $secretaires->push($direction?->secretaires?->pluck('responsable_id'));
    //                 }
    //                 if ($direction?->responsable_id) {
    //                     $responsables->push($direction?->responsable_id);
    //                 }
    //              }
    //              if ($secretaires->count()) {
    //                 $courrier->followers()->attach($secretaires->toArray());
    //              }
    //              if ($responsables->count()) {
    //                 $courrier->followers()->attach($responsables->toArray());
    //              }
    //           }
    //           $courrier->etapes()->attach(2);
    //           $notifyAgents = $courrier->destinateurs->where('id', '!=', Auth::user()->agent->id);
    //           if (count($notifyAgents)) {
    //              event(new CourrierCreated($courrier, $notifyAgents, 'A créé un nouveau courrier !')); 
    //           }
    //           $notifyFollowers = $courrier->followers()->whereNotIn('id', $responsables->pluck('id')->toArray())->get();
    //           if (count($notifyFollowers)) {
    //              event(new CourrierCreated($courrier, $notifyFollowers, 'Votre direction a ete mis en copie d\'un nouveau courrier !')); 
    //           }
    //           Historique::create([
    //             "key" => "Numérisation du courrier",
    //             "historiquecable_id" => $courrier->id,
    //             "historiquecable_type" => Courrier::class,
    //             "description" => "A numérisé le courrier", 
    //             "user_id" => Auth::user()->id
    //          ]);
    //           $content = json_encode([
    //              'name' => 'Courriers',
    //              'statut' => 'success',
    //              'message' => 'Courrier numérisé avec succès !',
    //           ]);
    //        }
    //        $viewsForThisUser = $courrier->views->where('user_id', Auth::id())->count();
    //        views($courrier)->once($viewsForThisUser > 0)->record();
    //     } catch (\Throwable $th) {
    //     //    dd($th);
    //        $content = json_encode([
    //           'name' => 'Courrier',
    //           'statut' => 'error',
    //           'message' => 'Impossible de numériser le courrier, une erreur s\'est produite',
    //        ]);
    //     }
    //     session()->flash('session', $content);
    //     return redirect()->route('regidoc.courriers.index');
    // }



// public function store(Request $request)
// {
//     try {
//         Log::info('Début de la méthode store', ['request' => $request->all()]);

//         if ($request->get('type') == 1) {
//             Log::info('Type 1 : traitement courrier externe pour la DG');

//             $directionGenerale = Direction::find(1);
//             if (!$directionGenerale) {
//                 Log::error('Direction générale introuvable (id=1)');
//                 throw new \Exception("Direction générale introuvable.");
//             }

//             $dgId = $directionGenerale->responsable_id;
//             if (!$dgId) {
//                 Log::error('Aucun DG défini dans la direction générale', ['direction' => $directionGenerale]);
//                 throw new \Exception("Aucun Directeur Général défini.");
//             }

//             Log::info('DG identifié avec succès', ['dg_id' => $dgId]);

//             $dgAgent = Agent::find($dgId);
//             if (!$dgAgent) {
//                 Log::error('Agent DG introuvable', ['dg_id' => $dgId]);
//                 throw new \Exception("L'agent correspondant au DG est introuvable.");
//             }

//             $document = $this->createDocument($request, $dgId);
//             if (!$document) {
//                 Log::error('Échec de la création du document');
//                 throw new \Exception("Erreur lors de la création du document.");
//             }

//             Log::info('Document créé avec succès', ['document_id' => $document->id]);

//             $courrier = new Courrier;
//             $courrier->type_id = $request->get('type');
//             $courrier->category_id = $request->get('categorie');
//             $courrier->exped_externe = $request->get('exp');
//             $courrier->reference_courrier = $request->get('ref');
//             $courrier->reference_interne = $request->get('ref_interne');
//             $courrier->confidentiel = $request->get('confidentiel') == true ? '1' : '0';
//             $courrier->title = $request->get('title');
//             $courrier->nature_id = $request->get('nature');
//             $courrier->date_du_courrier = $request->get('date-doc');
//             $courrier->date_arrive = $request->get('date-arriv');
//             $courrier->objet = $request->get('objet');
//             $courrier->document_id = $document->id;
//             $courrier->created_by = Auth::user()->agent->id;
//             $courrier->statut_id = 1;
//             $courrier->save();

//             Log::info('Courrier enregistré avec succès', ['courrier_id' => $courrier->id]);

//             $courrier->destinateurs()->attach($dgId);
//             $courrier->etapes()->attach(2);

//             if ($dgId != Auth::user()->agent->id) {
//                 event(new CourrierCreated($courrier, collect([$dgAgent]), 'A créé un nouveau courrier !'));
//                 Log::info('Notification envoyée au DG', ['dg_id' => $dgId]);
//             }

//             Historique::create([
//                 "key" => "Numérisation du courrier",
//                 "historiquecable_id" => $courrier->id,
//                 "historiquecable_type" => Courrier::class,
//                 "description" => "A numérisé un courrier",
//                 "user_id" => Auth::user()->id,
//             ]);

//             Log::info('Historique créé avec succès');

//             $content = json_encode([
//                 'name' => 'Courriers',
//                 'statut' => 'success',
//                 'message' => 'Courrier numérisé avec succès !',
//             ]);
//         }

//         // Type 3 non modifié ici pour rester focus sur ta demande
//         // Tu peux intégrer une logique similaire à ce cas

//         $viewsForThisUser = $courrier->views->where('user_id', Auth::id())->count();
//         views($courrier)->once($viewsForThisUser > 0)->record();

//     } catch (\Throwable $th) {
//         Log::error('Erreur dans la méthode store', [
//             'message' => $th->getMessage(),
//             'line' => $th->getLine(),
//             'file' => $th->getFile(),
//             'trace' => $th->getTraceAsString()
//         ]);

//         $content = json_encode([
//             'name' => 'Courrier',
//             'statut' => 'error',
//             'message' => 'Impossible de numériser le courrier, une erreur s\'est produite',
//         ]);
//     }

//     session()->flash('session', $content);
//     return redirect()->route('regidoc.courriers.index');
// }

public function store(Request $request)
{
    try {
        if ($request->get('type') == 1) {
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
            $courrier->statut_id = 1;
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
        } else {
            $content = json_encode([
                'name' => 'Courrier',
                'statut' => 'error',
                'message' => 'Type de courrier non supporté pour la numérisation.',
            ]);
        }
    } catch (\Throwable $th) {
        \Log::error("Erreur store courrier : " . $th->getMessage());

        $content = json_encode([
            'name' => 'Courrier',
            'statut' => 'error',
            'message' => 'Impossible de numériser le courrier, une erreur s\'est produite.',
        ]);
    }

    session()->flash('session', $content);
    return redirect()->route('regidoc.courriers.index');
}

    public function show($id)
    {

        $courrier = Courrier::with('document', 'views')->where('id', $id)->first();

        $viewsForThisUser = $courrier->views->where('user_id', Auth::id())->count();

        $this->authorize('view', $courrier);

        views($courrier)->once($viewsForThisUser > 0)->record();

        $classeurs = Classeur::all();
        $dossiers = Dossier::all();
        $directions = Direction::all();
        $traitements = Auth::user()->agent->isDG()|| Auth::user()->agent->isDGA()  ? CourrierTypesTraitement::select('id', 'titre')->get() : CourrierTypesTraitement::select('id', 'titre')->where('id','!=',3)->get();
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
     * Valider un courrier
     *
     * @param  \App\Models\Courrier  $courrier
     * @return \Illuminate\Http\Response
     */
    // public function valider(Courrier $courrier)
    // {
    //     try {
    //         // Mettre à jour le statut à 3 (validé)
    //         $courrier->statut_id = 3;
    //         $courrier->save();

    //         // Ajouter une entrée dans l'historique
    //         $historique = new Historique();
    //         $historique->user_id = Auth::id();
    //         $historique->key = 'courrier_valide';
    //         $historique->description = 'Le courrier a été marqué comme validé';
    //         $historique->historiquecable()->associate($courrier);
    //         $historique->save();

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Le courrier a été validé avec succès.'
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Une erreur est survenue lors de la validation du courrier: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }
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
