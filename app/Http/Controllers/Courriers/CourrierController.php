<?php

namespace App\Http\Controllers\Courriers;

use App\Events\CourrierCreated;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
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
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class CourrierController extends Controller
{
    use SoftDeletes;
    
    /**
     * Met à jour le traitement d'un courrier
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateTraitement(Request $request)
    {
        try {
            $request->validate([
                'courrier_id' => 'required|exists:courriers,id',
                'traitement_id' => 'required|exists:courrier_types_traitements,id',
                'priorite_id' => 'nullable|exists:priorites,id',
                'date_limite' => 'nullable|date',
                'commentaire' => 'nullable|string|max:1000'
            ]);
            
            $courrier = Courrier::findOrFail($request->courrier_id);
            $user = Auth::user();
            
            // Vérifier si l'utilisateur a déjà un traitement en cours pour ce courrier
            $existingTraitement = CourrierTraitement::where('courrier_id', $courrier->id)
                ->where('agent_id', $user->agent->id)
                ->first();
                
            if ($existingTraitement) {
                // Mettre à jour le traitement existant
                $existingTraitement->update([
                    'traitement_id' => $request->traitement_id,
                    'priorite_id' => $request->priorite_id,
                    'date_limite' => $request->date_limite,
                    'commentaire' => $request->commentaire,
                    'statut' => 'en_cours',
                    'date_debut' => now(),
                    'date_fin' => null
                ]);
                
                $traitement = $existingTraitement;
            } else {
                // Créer un nouveau traitement
                $traitement = CourrierTraitement::create([
                    'courrier_id' => $courrier->id,
                    'agent_id' => $user->agent->id,
                    'traitement_id' => $request->traitement_id,
                    'priorite_id' => $request->priorite_id,
                    'date_limite' => $request->date_limite,
                    'commentaire' => $request->commentaire,
                    'statut' => 'en_cours',
                    'date_debut' => now(),
                    'date_fin' => null
                ]);
            }
            
            // Mettre à jour la priorité du courrier si une priorité est spécifiée
            if ($request->priorite_id) {
                $courrier->priorite_id = $request->priorite_id;
                $courrier->save();
            }
            
            // Enregistrer l'historique
            $traitementLibelle = $traitement->traitement->titre ?? 'Traitement';
            $prioriteLibelle = $traitement->priorite->titre ?? 'Non défini';
            
            Historique::create([
                'action' => 'Traitement du courrier',
                'description' => "Traitement: $traitementLibelle, Priorité: $prioriteLibelle",
                'user_id' => $user->id,
                'courrier_id' => $courrier->id
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Traitement enregistré avec succès',
                'data' => $traitement
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de l\'enregistrement du traitement: ' . $e->getMessage()
            ], 500);
        }
    }
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
                
                // Utiliser le dossier pieces-jointes avec la structure année/mois/courrier-id
                $year = now()->format('Y');
                $month = now()->format('m');
                $folderPath = "pieces-jointes/{$year}/{$month}/courrier-{$courrier->id}";
                
                // Déterminer le chemin de base pour le stockage
                if (config('app.env') === 'production') {
                    // Sur Hostinger, DOCUMENT_ROOT pointe vers public_html
                    // On remplace /public par /public_html si nécessaire
                    $documentRoot = $_SERVER['DOCUMENT_ROOT'];
                    
                    // Si le chemin contient /public, le remplacer par /public_html
                    if (strpos($documentRoot, '/public') !== false && strpos($documentRoot, '/public_html') === false) {
                        $documentRoot = str_replace('/public', '/public_html', $documentRoot);
                    }
                    
                    $basePath = $documentRoot . '/storage';
                    
                    // Créer le dossier storage s'il n'existe pas
                    if (!file_exists($basePath)) {
                        @mkdir($basePath, 0755, true);
                    }
                    
                    $fullPath = $basePath . '/' . $folderPath;
                } else {
                    // En local, on garde le comportement actuel
                    $fullPath = storage_path('app/public/' . $folderPath);
                }
                
                Log::info('Tentative de création du dossier', [
                    'folder_path' => $folderPath,
                    'full_path' => $fullPath,
                    'base_path' => dirname($fullPath, 3),
                    'exists_before' => file_exists($fullPath),
                    'parent_exists' => file_exists(dirname($fullPath)),
                    'parent_writable' => is_writable(dirname($fullPath)),
                    'document_root' => $_SERVER['DOCUMENT_ROOT'] ?? 'N/A',
                    'public_path' => public_path('storage'),
                    'environment' => config('app.env')
                ]);
                
                // Créer le dossier s'il n'existe pas
                if (!file_exists($fullPath)) {
                    // Essayer de créer avec error suppression pour capturer l'erreur
                    set_error_handler(function($errno, $errstr) {
                        throw new \Exception("Erreur mkdir: $errstr");
                    });
                    
                    try {
                        $created = mkdir($fullPath, 0755, true);
                        restore_error_handler();
                        
                        Log::info('Résultat création dossier', [
                            'created' => $created,
                            'exists_after' => file_exists($fullPath),
                            'is_writable' => is_writable($fullPath),
                            'permissions' => file_exists($fullPath) ? substr(sprintf('%o', fileperms($fullPath)), -4) : 'N/A'
                        ]);
                        
                        if (!$created || !file_exists($fullPath)) {
                            throw new \Exception("Impossible de créer le dossier: " . $fullPath);
                        }
                    } catch (\Exception $e) {
                        restore_error_handler();
                        Log::error('Erreur création dossier', [
                            'error' => $e->getMessage(),
                            'path' => $fullPath
                        ]);
                        throw $e;
                    }
                }
                
                // Récupérer les informations du fichier AVANT de le déplacer
                $tempPath = $file->getRealPath();
                $originalName = $file->getClientOriginalName();
                $mimeType = $file->getMimeType();
                $fileSize = @filesize($tempPath); // Utiliser filesize() au lieu de getSize()
                
                // Nettoyer le nom du fichier : remplacer espaces et caractères spéciaux
                $cleanOriginalName = preg_replace('/[^A-Za-z0-9._-]/', '_', $originalName);
                $cleanOriginalName = preg_replace('/_+/', '_', $cleanOriginalName); // Éviter les underscores multiples
                
                // Générer un nom de fichier unique
                $fileName = time() . '_' . Str::random(8) . '_' . $cleanOriginalName;
                $finalPath = $fullPath . '/' . $fileName;
                
                Log::info('Tentative de déplacement du fichier', [
                    'temp_path' => $tempPath,
                    'destination' => $finalPath,
                    'file_size' => $fileSize,
                    'mime_type' => $mimeType,
                    'temp_exists' => file_exists($tempPath)
                ]);
                
                // En production, déplacer directement dans public_html/storage
                if (config('app.env') === 'production') {
                    $moved = $file->move($fullPath, $fileName);
                    $path = $folderPath . '/' . $fileName;
                    
                    Log::info('Résultat du déplacement', [
                        'moved' => $moved !== false,
                        'final_path' => $finalPath,
                        'file_exists' => file_exists($finalPath)
                    ]);
                } else {
                    // En local, utiliser le système de storage Laravel
                    $path = $file->storeAs($folderPath, $fileName, 'public');
                }
                
                // Vérifier que le fichier existe
                $fileExists = file_exists($finalPath);
                
                if (!$fileExists) {
                    Log::error('Le fichier n\'a pas été créé', [
                        'expected_path' => $finalPath,
                        'directory_exists' => file_exists($fullPath),
                        'directory_writable' => is_writable($fullPath),
                        'directory_contents' => scandir($fullPath)
                    ]);
                    
                    throw new \Exception("Le fichier n'a pas pu être enregistré correctement. Chemin: " . $finalPath);
                }
                
                Log::info('Pièce jointe uploadée avec succès', [
                    'courrier_id' => $courrier->id,
                    'path' => $path,
                    'full_path' => $finalPath,
                    'file_exists' => $fileExists,
                    'file_size' => filesize($finalPath),
                    'environment' => config('app.env')
                ]);
                
                // Créer le JSON au format attendu (comme les documents normaux)
                $documentJson = json_encode([
                    [
                        'download_link' => $path,
                        'original_name' => $originalName
                    ]
                ]);
                
                // Vérifier si un document est déjà associé au courrier via document_id
                if ($courrier->document_id) {
                    $document = Document::find($courrier->document_id);
                } else {
                    // Sinon, vérifier s'il existe déjà un document lié via la relation
                    $document = $courrier->documents->first();
                    
                    // Si aucun document n'existe, en créer un nouveau
                    if (!$document) {
                        $document = Document::create([
                            'titre' => 'Pièce jointe - ' . $originalName,
                            'reference' => 'PJ-' . time(),
                            'type_document_id' => 1, // À adapter selon votre configuration
                            'statut' => 'brouillon',
                            'est_prive' => false,
                            'courrier_id' => $courrier->id,
                            'created_by' => auth()->id(),
                        ]);
                        
                        // Mettre à jour le document_id du courrier
                        $courrier->update(['document_id' => $document->id]);
                    } else {
                        // Si un document existe via la relation, mettre à jour le document_id du courrier
                        $courrier->update(['document_id' => $document->id]);
                    }
                }
                
                // Enregistrer la pièce jointe dans la base de données avec le format JSON
                $pieceJointe = new PieceJointe([
                    'nom' => $originalName,
                    'chemin' => $documentJson, // Stocker le JSON au lieu du chemin simple
                    'taille' => $fileSize ?: filesize($finalPath),
                    'mime_type' => $mimeType,
                    'courrier_id' => $courrier->id,
                    'document_id' => $document->id,
                    'uploaded_by' => auth()->id(),
                ]);
                
                $courrier->piecesJointes()->save($pieceJointe);
                
                Historique::create([
                    "key" => "Ajout d'une piece jointe'",
                    "historiquecable_id" => $courrier->id,
                    "historiquecable_type" => Courrier::class,
                    "description" => Auth::user()->agent->nom . " " . Auth::user()->agent->prenom . " a ajouté une pièce jointe à ce document .",
                    "user_id" => Auth::user()->id,
                ]);
                
                // Retourner la réponse au format JSON attendu
                $content = json_encode([
                    'name' => 'Courrier',
                    'statut' => 'success',
                    'message' => 'Pièce jointe ajoutée avec succès'
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
        try {
            $courrier = Courrier::find($request->courrier_id);
            $traitement = null;

            if ($courrier->traitements->count() == 0 || $request->is_original) {
                // Créer un nouveau traitement
                $traitement = new CourrierTraitement();
                $traitement->agent_id = Auth::user()->agent->id;
                $traitement->note = 'Document signé';
                $traitement->save();

                // Mettre à jour le statut du document si il existe
                if ($courrier->document) {
                    $courrier->document->statut_id = 6;
                    $courrier->document->save();
                }

                $courrier->traitements()->attach($traitement);
            } else {
                // Utiliser le dernier traitement existant
                $traitement = $courrier->traitements->last();
                if ($traitement && $traitement->document_url != null) {
                    // Supprimer l'ancien fichier
                    Storage::delete($traitement->document_url);
                }
            } 
            // I change the stap
            $courrier->etapes()->attach(4);
            $courrier->destinateurs()->attach(Auth::user()->agent->direction->responsable);

            // Sauvegarder le PDF signé
            $pdfFile = $request->file('document');
            $path = 'courrier-signatures/' . date('Y/m') . '/';
            
            // Récupérer le nom original du document et ajouter (copie)
            $originalDocName = $courrier->document?->libelle ?? 'Document';
            // Nettoyer le nom pour éviter les caractères spéciaux
            $cleanDocName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalDocName);
            $cleanDocName = preg_replace('/_+/', '_', $cleanDocName);
            
            $filename = $cleanDocName . '_copie_' . time() . '.pdf';
            
            // IMPORTANT: Obtenir la taille AVANT de déplacer le fichier
            $fileSize = $pdfFile->getSize();
            
            // Déterminer le chemin de base pour le stockage
            if (config('app.env') === 'production') {
                $documentRoot = $_SERVER['DOCUMENT_ROOT'];
                if (strpos($documentRoot, '/public') !== false && strpos($documentRoot, '/public_html') === false) {
                    $documentRoot = str_replace('/public', '/public_html', $documentRoot);
                }
                $basePath = $documentRoot . '/storage';
                if (!file_exists($basePath)) {
                    @mkdir($basePath, 0755, true);
                }
                $fullPath = $basePath . '/' . $path;
                if (!file_exists($fullPath)) {
                    @mkdir($fullPath, 0755, true);
                }
                $pdfFile->move($fullPath, $filename);
                $savedPath = $path . $filename;
            } else {
                $savedPath = $pdfFile->storeAs($path, $filename, 'public');
            }

            $traitement->document_url = $savedPath;
            $traitement->save();

            // Créer une pièce jointe avec le document signé
            $originalName = $originalDocName . ' (copie).pdf';
            $documentJson = json_encode([
                [
                    'download_link' => $savedPath,
                    'original_name' => $originalName
                ]
            ]);

            // Vérifier si un document est déjà associé au courrier
            if ($courrier->document_id) {
                $document = Document::find($courrier->document_id);
            } else {
                $document = $courrier->documents->first();
                if (!$document) {
                    $document = Document::create([
                        'titre' => 'Document signé - ' . $courrier->reference_interne,
                        'reference' => 'SIG-' . time(),
                        'type_document_id' => 1,
                        'statut' => 'valide',
                        'est_prive' => false,
                        'courrier_id' => $courrier->id,
                        'created_by' => auth()->id(),
                    ]);
                    $courrier->update(['document_id' => $document->id]);
                } else {
                    $courrier->update(['document_id' => $document->id]);
                }
            }

            // Créer la pièce jointe
            $pieceJointe = new PieceJointe([
                'nom' => $originalName,
                'chemin' => $documentJson,
                'taille' => $fileSize, // Utiliser la taille récupérée AVANT le déplacement
                'mime_type' => 'application/pdf',
                'courrier_id' => $courrier->id,
                'document_id' => $document->id,
                'uploaded_by' => auth()->id(),
            ]);
            
            $courrier->piecesJointes()->save($pieceJointe);

            Historique::create([
                "key" => "Signature",
                "historiquecable_id" => $request->courrier_id,
                "historiquecable_type" => Courrier::class,
                "description" => Auth::user()->name.' a signé ce document et créé une copie signée.',
                "user_id" => Auth::user()->id,
            ]);

            $destinateursToNotify = $courrier->destinateurs->where('id', '!=', Auth::user()->agent->id);

            if (count($destinateursToNotify)) {
                event(new CourrierCreated($courrier, $destinateursToNotify, 'A signé le document du courrier'));
            }

            Log::info('Document signé créé avec succès', [
                'courrier_id' => $courrier->id,
                'traitement_id' => $traitement->id,
                'piece_jointe_id' => $pieceJointe->id,
                'path' => $savedPath
            ]);

            return $traitement;
        } catch (\Exception $e) {
            Log::error('Erreur lors de la sauvegarde de la signature: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    public function saveSignature(Request $request)
    {
        try {
            Log::info('=== DEBUT SAVE SIGNATURE COURRIER ===', [
                'courrier_id' => $request->courrier_id,
                'doc_id' => $request->doc_id,
                'is_original' => $request->is_original
            ]);
            
            $traitement = $this->saveTraitementSignature($request);
            
            // Récupérer le courrier depuis la requête au lieu du traitement
            $courrier = Courrier::find($request->courrier_id);
            
            Log::info('=== FIN SAVE SIGNATURE COURRIER ===', [
                'traitement_id' => $traitement->id,
                'courrier_id' => $courrier->id
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Document signé avec succès !',
                'file' => files($traitement->document_url)->link,
                'redirect' => route('regidoc.courriers.show', $courrier->id)
            ]);
        } catch (\Exception $e) {
            Log::error('=== ERREUR SAVE SIGNATURE COURRIER ===');
            Log::error('Message: ' . $e->getMessage());
            Log::error('File: ' . $e->getFile() . ':' . $e->getLine());
            Log::error('Trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'error' => 'Erreur lors de l\'enregistrement: ' . $e->getMessage()
            ], 500);
        }
    }


    public function saveCourrierSortant($courrier)
    {
        $courrier->save();
        return $courrier;
    }

    /**
     * Transmet un courrier sortant (marqué comme traité)
     * 
     * @param int $id ID du courrier
     * @return \Illuminate\Http\JsonResponse
     */
    public function transmettreCourrier($id)
    {
        try {
            $courrier = Courrier::findOrFail($id);
            
            // Vérifier que l'utilisateur est bien l'assistant du DG
            $user = auth()->user();
            $isDGAssistant = $user->agent && $user->agent->isAssistant();
            
            \Log::info('Vérification des droits d\'accès', [
                'user_id' => $user->id,
                'agent_id' => $user->agent?->id,
                'is_assistant' => $isDGAssistant,
                'courrier_type' => $courrier->type_id,
                'courrier_statut' => $courrier->statut_id
            ]);

            if (!$isDGAssistant) {
                return response()->json([
                    'success' => false,
                    'message' => 'Action non autorisée. Seul l\'assistant du DG peut effectuer cette action.'
                ], 403);
            }

            // Vérifier que c'est bien un courrier sortant
            if ($courrier->type_id != 2) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cette action ne peut être effectuée que sur un courrier sortant.'
                ], 400);
            }

            // Mettre à jour le statut du courrier
            $courrier->statut_id = 3; // Statut "Traité"
            $courrier->mark_as_done = 1; // Marquer comme traité
            $courrier->updated_at = now(); 
            
            // Mettre à jour le statut du document associé s'il existe
            if ($courrier->document) {
                $courrier->document->statut_id = 5; // Statut "Traité"
                $courrier->document->save();
            }
            
            $courrier->save();

            // Ajouter une entrée dans l'historique
            Historique::create([
                'key' => 'courrier_transmis',
                'historiquecable_id' => $courrier->id,
                'historiquecable_type' => Courrier::class,
                'description' => 'Le courrier a été transmis par l\'assistant du DG',
                'user_id' => $user->id,
            ]);

            $content = json_encode([
                'name' => 'Courriers',
                'statut' => 'success',
                'message' => 'Le courrier a été transmis avec succès',
            ]);

            session()->flash('session', $content);
            return redirect()->route('regidoc.courriers.index');

        } catch (\Exception $e) {
            \Log::error('Erreur lors de la transmission du courrier: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la transmission du courrier: ' . $e->getMessage()
            ], 500);
        }
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

            // Copier les pièces jointes du courrier entrant vers le courrier sortant
            if ($courrier->piecesJointes && $courrier->piecesJointes->count() > 0) {
                Log::info('📎 Copie des pièces jointes', ['count' => $courrier->piecesJointes->count()]);
                
                foreach ($courrier->piecesJointes as $pieceJointe) {
                    $nouvellePieceJointe = new PieceJointe([
                        'nom' => $pieceJointe->nom,
                        'chemin' => $pieceJointe->chemin,
                        'taille' => $pieceJointe->taille,
                        'mime_type' => $pieceJointe->mime_type,
                        'courrier_id' => $newCourrier->id,
                        'document_id' => $pieceJointe->document_id,
                        'uploaded_by' => auth()->id(),
                    ]);
                    
                    $newCourrier->piecesJointes()->save($nouvellePieceJointe);
                    Log::info('✅ Pièce jointe copiée', [
                        'original_id' => $pieceJointe->id,
                        'new_id' => $nouvellePieceJointe->id,
                        'nom' => $pieceJointe->nom
                    ]);
                }
            }

            foreach ($courrier->traitements as $t) {
                $newCourrier->traitements()->attach($t);
            }

            // Copier l'historique du courrier entrant vers le courrier sortant
            if ($courrier->history && $courrier->history->count() > 0) {
                Log::info('📜 Copie de l\'historique', ['count' => $courrier->history->count()]);
                
                foreach ($courrier->history as $history) {
                    Historique::create([
                        'key' => $history->key,
                        'historiquecable_id' => $newCourrier->id,
                        'historiquecable_type' => Courrier::class,
                        'description' => $history->description,
                        'user_id' => $history->user_id,
                        'created_at' => $history->created_at,
                        'updated_at' => $history->updated_at,
                    ]);
                }
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

        Historique::create([
            "key" => "Traitement",
            "historiquecable_id" => $courrier->id,
            "historiquecable_type" => Courrier::class,
            "description" => Auth::user()->name.' a marqué ce document comme traité ',
            "user_id" => Auth::user()->id,
        ]);

        $response = [
            'name' => 'Courrier',
            'statut' => 'success',
            'message' => Auth::user()->name.' a marqué ce document comme traité ',
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
        \Log::info('🔵 Début saveTraitement', ['request' => $request->all()]);
        
        // On récupère le courrier ou erreur 404
        $courrier = Courrier::findOrFail($request->courrier_id);
        \Log::info('✅ Courrier trouvé', ['courrier_id' => $courrier->id]);

        $user = Auth::user();
        \Log::info('✅ User récupéré', ['user_id' => $user->id]);
        
        $agent = $user->agent;
        \Log::info('✅ Agent récupéré', ['agent_id' => $agent->id ?? 'NULL']);

        if ($agent->isAssistant() || $agent->isSecretaire()) {
            \Log::info('✅ Permission validée (Assistant ou Secrétaire)');

            // Création du traitement AVANT d'assigner au courrier
            $traitement = new CourrierTraitement();
            $traitement->agent_id = $agent->id;
            $traitement->note = $request->commentaire ?? 'Document traité';
            $traitement->save();
            \Log::info('✅ CourrierTraitement créé', ['traitement_id' => $traitement->id]);

            // Maintenant on peut assigner au courrier
            $courrier->priorite_id = $request->priorite_id;
            $courrier->date_fin = $request->date_limite ?? null;
            $courrier->traitement_id = $request->traitement_id; // Assignation du type de traitement
            
            \Log::info('🔄 Tentative de sauvegarde courrier...', [
                'priorite_id' => $courrier->priorite_id,
                'date_fin' => $courrier->date_fin,
                'traitement_id' => $courrier->traitement_id
            ]);
            
            $courrier->save();
            \Log::info('✅ Courrier sauvegardé');

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
                    "description" => $user->name." a défini  le traitement à effectuer sur ce document.",
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

            \Log::info('✅ Traitement terminé avec succès');
            return response()->json(['success' => 1]);

        } else {
            \Log::error('❌ Permission refusée', [
                'user_id' => $user->id ?? null,
                'agent_id' => $agent->id ?? null,
                'isAssistant' => $agent ? $agent->isAssistant() : null,
                'isSecretaire' => $agent ? $agent->isSecretaire() : null
            ]);
            return response()->json(['error' => 'Permission refusée'], 403);
        }
    } catch (\Throwable $th) {
        \Log::error('❌ ERREUR dans saveTraitement', [
            'message' => $th->getMessage(),
            'file' => $th->getFile(),
            'line' => $th->getLine(),
            'trace' => $th->getTraceAsString()
        ]);
        return response()->json(['error' => $th->getMessage()], 500);
    }
}


   


/**
 * Crée un document pour un courrier
 * 
 * @param mixed $request La requête ou un tableau de données
 * @param mixed $destinateur L'ID ou l'objet Agent destinataire
 * @param mixed $doc Document existant ou null
 * @return \App\Models\Document|null
 * @throws \Exception
 */
public function createDocument($request, $destinateur, $doc = null) 
{
    try {
        // Gestion du paramètre $destinateur qui peut être un ID ou un objet Agent
        $agentDestinataire = is_numeric($destinateur) ? Agent::findOrFail($destinateur) : $destinateur;
        
        if (!$agentDestinataire) {
            throw new \Exception('Agent destinataire introuvable');
        }

        // 1. Création ou récupération du classeur
        $classeur = Classeur::firstOrCreate(
            ['titre' => $agentDestinataire->direction?->lieu?->titre ?? 'Region inconnu'], 
            [
                'reference' => 'DIR/' . Str::padLeft(Classeur::count() + 1, 4, '0'),
                'direction_id' => $agentDestinataire->direction_id,
                'created_by' => Auth::user()->agent->id,
                'updated_by' => Auth::user()->agent->id,
            ]
        );
        
        if (!$classeur) {
            throw new \Exception('Impossible de créer ou récupérer le classeur');
        }
        
        // 2. Création ou récupération du dossier 'Courriers'
        $dossier = Dossier::firstOrCreate(
            ['titre' => 'Courriers', 'classeur_id' => $classeur->id],
            [
                'reference' => 'COUR/' . Str::padLeft(Dossier::where('classeur_id', $classeur->id)->count() + 1, 4, '0'),
                'created_by' => Auth::user()->agent->id,
                'updated_by' => Auth::user()->agent->id,
            ]
        );
        
        if (!$dossier) {
            throw new \Exception('Impossible de créer ou récupérer le dossier');
        }

        // 3. Si pas de document existant passé en paramètre
        if ($doc === null) {
            // Cas où c'est un scan ou un document déjà sélectionné
            $isScan = ($request?->is_scan ?? 'false') === 'true';
            $hasSelectedDoc = $request?->has('selected_doc') && !empty($request->selected_doc);
            
            if ($isScan || $hasSelectedDoc) {
                $document = new Document();
                $document->dossier_id = $dossier->id;
                $document->reference = is_array($request->get('ref')) ? implode(', ', $request->get('ref')) : ($request->get('ref') ?? '');
                $document->reference_interne = $request->get('ref_interne');
                $document->category_id = $request->get('categorie');
                $document->libelle = $request->get('title');
                $document->type = $request->get('type');
                $document->nature_id = $request->get('nature');
                $document->date_du_courrier = $request->get('date-doc');
                $document->date_arrive = $request->get('date-arriv');
                $document->objet = $request->get('objet');
                $document->confidentiel = $request->get('confidentiel') ? '1' : '0';
                $document->expediteur_interne_id = $request->get('expediteur_id') ?? Auth::user()->agent_id;
                $document->destinataire_interne_id = $agentDestinataire->id;

                if ($isScan) {
                    try {
                        // Récupérer le nom du fichier scanné s'il existe
                        $scannedFileName = $request->get('scanned_file_name');
                        
                        $scanResult = (new ScanFile())->handle('documents', null, $scannedFileName);
                        if (empty($scanResult)) {
                            throw new \Exception('Le scan n\'a pas retourné de fichier valide');
                        }
                        $document->document = $scanResult;
                    } catch (\Exception $e) {
                        \Log::error('Erreur lors du scan du document', [
                            'error' => $e->getMessage(),
                            'trace' => $e->getTraceAsString()
                        ]);
                        throw new \Exception('Erreur lors du scan du document : ' . $e->getMessage());
                    }
                } else {
                    try {
                        $movedDoc = $this->moveCreatedDoc($request->selected_doc);
                        if (empty($movedDoc)) {
                            throw new \Exception('Impossible de déplacer le document sélectionné');
                        }
                        $document->document = $movedDoc;
                    } catch (\Exception $e) {
                        \Log::error('Erreur lors du déplacement du document', [
                            'error' => $e->getMessage(),
                            'selected_doc' => $request->selected_doc,
                            'trace' => $e->getTraceAsString()
                        ]);
                        throw new \Exception('Erreur lors du traitement du document : ' . $e->getMessage());
                    }
                }

                $document->user_id = Auth::id();
                $document->statut_id = 1;
                $document->created_by = Auth::user()->agent->id;
                $document->save();

                return $document;
            }

            // Cas d'un upload via formulaire (input file)
            if ($request->hasFile('document') && $request->file('document')->isValid() && empty($request->document_id)) {
                try {
                    $document = new Document();
                    $document->dossier_id = $dossier->id;
                    $document->reference = $request->get('ref') ?? '';
                    $document->reference_interne = $request->get('ref_interne');
                    $document->category_id = $request->get('categorie');
                    $document->libelle = $request->get('title');
                    $document->type = $request->get('type');
                    $document->nature_id = $request->get('nature');
                    $document->date_du_courrier = $request->get('date-doc');
                    $document->date_arrive = $request->get('date-arriv');
                    $document->objet = $request->get('objet');
                    $document->confidentiel = $request->get('confidentiel') ? '1' : '0';
$document->expediteur_interne_id = $request->get('expediteur_id') ?? Auth::user()->agent_id;
                    $document->destinataire_interne_id = $agentDestinataire->id;
                    
                    $uploadedFile = (new File())->handle($request, 'document', 'documents');
                    if (empty($uploadedFile)) {
                        throw new \Exception('Le fichier n\'a pas pu être téléversé correctement');
                    }
                    
                    $document->document = $uploadedFile;
                    $document->user_id = Auth::id();
                    $document->statut_id = 1;
                    $document->created_by = Auth::user()->agent->id;
                    $document->save();

                    return $document;
                } catch (\Exception $e) {
                    \Log::error('Erreur lors de l\'upload du document', [
                        'error' => $e->getMessage(),
                        'file' => $request->file('document') ? $request->file('document')->getClientOriginalName() : null,
                        'trace' => $e->getTraceAsString()
                    ]);
                    throw new \Exception('Erreur lors de l\'upload du document : ' . $e->getMessage());
                }
            } 
            
            // Cas où on utilise un document existant via son ID
            if ($request->has('document_id') && !empty($request->document_id)) {
                $document = Document::find($request->document_id);
                if (!$document) {
                    throw new \Exception('Document introuvable avec l\'ID fourni');
                }
                return $document;
            }

            throw new \Exception('Aucun document valide fourni');
        } 
        
        // Cas où on crée un nouveau document à partir d'un autre objet $doc existant
        $document = Document::create([
            'dossier_id' => $dossier->id,
            'reference' => (is_array($doc->reference) ? implode(', ', $doc->reference) : ($doc->reference ?? '')) . '/R',
            'reference_interne' => $doc->reference_interne ?? null,
            'category_id' => $doc->category_id ?? null,
            'libelle' => $doc->libelle ?? 'Nouveau document',
            'type' => $doc->type ?? 'document',
            'nature_id' => $doc->nature_id ?? null,
            'date_du_courrier' => $doc->date_du_courrier ?? null,
            'date_arrive' => $doc->date_arrive ?? null,
            'objet' => $doc->objet ?? null,
            'confidentiel' => $doc->confidentiel ?? '0',
            'expediteur_interne_id' => $doc->expediteur_interne_id ?? Auth::user()->agent_id,
            'destinataire_interne_id' => $agentDestinataire->id,
            'expediteur_externe' => $doc->expediteur_externe ?? null,
            'document' => $doc->document ?? ((new File())->handle($request, 'document', 'documents')),
            'user_id' => Auth::id(),
            'statut_id' => 1,
            'created_by' => Auth::user()->agent->id,
        ]);

        return $document;
        
    } catch (\Exception $e) {
        Log::error('Erreur dans createDocument: ' . $e->getMessage(), [
            'exception' => $e,
            'request' => $request ? $request->all() : null,
            'destinateur' => $destinateur,
            'user_id' => Auth::id()
        ]);
        throw $e; // Relancer l'exception pour qu'elle soit gérée plus haut
    }
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
        // Activer le débogage si l'en-tête X-Debug est présent
        if ($request->header('X-Debug')) {
            \DB::enableQueryLog();
            \Log::info('Début du traitement de la requête store', [
                'input' => $request->all(),
                'files' => $request->allFiles(),
                'user' => auth()->user() ? auth()->user()->id : 'guest'
            ]);
        }

        try {
            // Valider les champs requis
            $validated = $request->validate([
                'type' => 'required|in:1,2,3',
                // 'categorie' => 'required|exists:courrier_categories,id',
                // 'title' => 'required|string|max:255',
                // // 'objet' => 'required|string',
                // 'date-doc' => 'required|date',
                // 'date-arriv' => 'required|date',
            ]);

            // Initialiser la réponse
            $response = [
                'success' => false,
                'message' => 'Type de courrier non supporté pour la numérisation.',
                'data' => []
            ];

            // Récupérer la valeur de 'copie' si elle est présente dans la requête.
            $copie = $request->get('copie', []);

            if ($request->get('type') == 1) { // Logique pour Courrier Entrant
                // Récupérer la Direction Générale (DG)
                $directionGenerale = Direction::find(1);
                
                if (!$directionGenerale) {
                    $content = json_encode([
                        'name' => 'Courrier',
                        'statut' => 'error',
                        'message' => 'Impossible d\'envoyer le courrier, Direction Générale introuvable.',
                    ]);
                    session()->flash('session', $content);
                    return redirect()->route('regidoc.courriers.index');
                }
                
                // Récupérer les assistants du DG via la relation assistanats()
                $assistantsDG = $directionGenerale->assistanats->pluck('responsable_id');

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

                // Créer une collection pour tous les destinataires (assistants + DG)
                $destinataires = $assistantsDG->toBase();
                
                // Ajouter le DG (responsable de la Direction Générale) s'il existe
                if ($directionGenerale->responsable_id) {
                    $destinataires->push($directionGenerale->responsable_id);
                }
                
                // Supprimer les doublons au cas où le DG serait aussi dans les assistants
                $destinataires = $destinataires->unique();
                
                // Attacher tous les destinataires (assistants DG + DG)
                $courrier->destinateurs()->attach($destinataires);

                // Attacher l'étape (exemple : étape 2)
                $courrier->etapes()->attach(2);

                // Notification aux assistants DG et au DG sauf le créateur
                $notifyAgents = $courrier->destinateurs->where('id', '!=', Auth::user()->agent->id);
                if ($notifyAgents->count()) {
                    event(new CourrierCreated($courrier, $notifyAgents, 'A créé un nouveau courrier !'));
                }

                // Historique
                Historique::create([
                    "key" => "Numérisation du courrier",
                    "historiquecable_id" => $courrier->id,
                    "historiquecable_type" => Courrier::class,
                    "description" => Auth::user()->name." a numérisé ce document",
                    "user_id" => Auth::user()->id,
                ]);

                $content = json_encode([
                    'name' => 'Courriers',
                    'statut' => 'success',
                    'message' => Auth::user()->name.' a numérisé ce document ',
                ]);

            } elseif ($request->get('type') == 3) { // Logique pour Courrier Interne (Destinataire est un agent)
                $type = $request->get('type');
        
                if (!in_array($type, [1, 2, 3])) {
                    throw new \InvalidArgumentException('Type de courrier invalide.');
                }
        
                $copie = $request->get('copie', []);
                
                \Log::info('🔄 Création d\'un courrier interne', ['request' => $request->all()]);
                
                // Validation du destinataire
                $destinataireAgentId = $request->get('destination2');
                if (!$destinataireAgentId) {
                    throw new \Exception('Le destinataire interne est requis pour un courrier interne.');
                }
    
                $destinataireAgent = Agent::find($destinataireAgentId);
                if (!$destinataireAgent) {
                    throw new \Exception('Agent destinataire introuvable.');
                }
                
                // Vérification de l'existence d'un fichier ou d'un scan
                $hasFile = $request->hasFile('document') && $request->file('document')->isValid();
                $isScan = ($request->is_scan ?? 'false') === 'true';
                $hasSelectedDoc = !empty($request->selected_doc);
                
                if (!$hasFile && !$isScan && !$hasSelectedDoc) {
                    throw new \Exception('Veuillez sélectionner un fichier à téléverser ou effectuer une numérisation.');
                }
                
                // Créer le document avec gestion d'erreur détaillée
                try {
                    $document = $this->createDocument($request, $destinataireAgent, null);
                    if (!$document) {
                        throw new \Exception('Échec de création du document.');
                    }
                    
                    // Vérifier que le document a bien un fichier associé
                    if (empty($document->document)) {
                        // Supprimer le document partiellement créé
                        if ($document->id) {
                            $document->delete();
                        }
                        throw new \Exception('Aucun fichier n\'a pu être associé au document.');
                    }
                } catch (\Exception $e) {
                    \Log::error('Erreur lors de la création du document pour un courrier interne', [
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString(),
                        'request_data' => $request->except(['_token', 'document'])
                    ]);
                    throw new \Exception('Erreur lors de la création du document : ' . $e->getMessage());
                }
    
                // Créer le courrier
                $courrier = new Courrier();
                $courrier->type_id = 3;
                $courrier->category_id = $request->get('categorie');
                $courrier->reference_interne = $this->changeNumRef(3); // génère une référence
                $courrier->confidentiel = $request->has('confidentiel') ? 1 : 0;
                $courrier->title = $request->get('title') ?? 'Sans objet';
                $courrier->objet = $request->get('objet') ?? null;
                $courrier->document_id = $document->id;
                $courrier->created_by = Auth::user()->agent->id;
                $courrier->statut_id = 1;
                $courrier->traitement_id = $request->get('traitement_id');
                $courrier->date_du_courrier = now();  
                $courrier->priorite_id = $request->get('priorite');
                $courrier->date_fin = $request->get('date-limite');
                $courrier->exped_interne_id = $request->get('exp_int');
                $courrier->dest_interne_id = $request->get('destination2');





                $courrier->save();
    
                // Associer le destinataire
                $courrier->destinateurs()->attach($destinataireAgentId);
    
                // Historique
                Historique::create([
                    "key" => "Numérisation du courrier",
                    "historiquecable_id" => $courrier->id,
                    "historiquecable_type" => Courrier::class,
                    "description" => "A numérisé un courrier interne",
                    "user_id" => Auth::user()->id,
                ]);
    
                $content = json_encode([
                    'name' => 'Courriers',
                    'statut' => 'success',
                    'message' => 'Courrier interne numérisé avec succès !',
                ]);
    
                \Log::info('✅ Courrier interne créé', ['courrier_id' => $courrier->id]);
            } else {
                // Pour tous les types non 1 ou 3
                $content = json_encode([
                    'name' => 'Courrier',
                    'statut' => 'error',
                    'message' => 'Ce type de courrier n\'est pas encore géré.'
                ]);
                
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Ce type de courrier n\'est pas encore géré.'
                    ], 400);
                }
                
                return redirect()
                    ->route('regidoc.courriers.index')
                    ->with('error', 'Ce type de courrier n\'est pas encore géré.');
            }
            
            // Si on arrive ici, c'est que tout s'est bien passé
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $response['message'] ?? 'Opération réussie',
                    'redirect' => route('regidoc.courriers.index')
                ]);
            }

            // Redirection pour les requêtes normales
            return redirect()
                ->route('regidoc.courriers.index')
                ->with('success', $response['message'] ?? 'Opération réussie');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Erreur de validation
            $errors = $e->validator->errors()->all();
            $errorMessage = implode(' ', $errors);
            
            \Log::warning('Erreur de validation dans store()', [
                'errors' => $errors,
                'input' => $request->except(['_token', 'password'])
            ]);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur de validation: ' . $errorMessage,
                    'errors' => $errors
                ], 422);
            }

            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
                
        } catch (\Exception $e) {
            // Erreur inattendue
            $errorMessage = 'Une erreur est survenue lors du traitement de votre demande.';
            
            \Log::error('❌ Erreur dans store()', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'input' => $request->except(['_token', 'password'])
            ]);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $errorMessage,
                    'debug' => config('app.debug') ? $e->getMessage() : null
                ], 500);
            }

            return redirect()->back()
                ->with('error', $errorMessage)
                ->withInput();
        }

        // Si on arrive ici, c'est que tout s'est bien passé
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $response['message'] ?? 'Opération réussie',
                'redirect' => route('regidoc.courriers.index')
            ]);
        }

        // Redirection pour les requêtes normales
        return redirect()
            ->route('regidoc.courriers.index')
            ->with('success', $response['message'] ?? 'Opération réussie');
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
        $traitements = $user->agent->isDG() || $user->agent->isDGA()
            ? CourrierTypesTraitement::withTrashed()->select('id', 'titre')->get()
            : CourrierTypesTraitement::withTrashed()->select('id', 'titre')->get();
        $priorites = Priorite::select('id', 'titre')->get();

        // Vérifier si l'utilisateur est l'assistant du DG
        $isDGAssistant = $user->agent && $user->agent->isAssistant();

        return view('regidoc.pages.courriers.show-courrier', compact(
            'courrier',
            'classeurs',
            'dossiers',
            'directions',
            'traitements',
            'priorites',
            'isDGAssistant'
        ));
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
        // Mise à jour des champs de base
        $document->dossier_id = $dossierId;
        $document->reference = is_array($request->get('ref')) 
            ? implode(', ', $request->get('ref')) 
            : $request->get('ref');
        $document->reference_interne = $request->get('ref_interne') ?? $document->reference_interne;
        $document->reference_courrier = $request->get('ref_courrier') ?? $document->reference_courrier;
        $document->category_id = $request->get('categorie');
        $document->libelle = $request->get('title');
        $document->type = $request->get('type') ?? 1;
        $document->description = $request->get('description') ?? $document->description;
        $document->objet = $request->get('objet') ?? $document->objet;
        $document->nature_id = $request->get('nature') ?? $document->nature_id;
        $document->date_du_courrier = $request->get('date-doc') ?? $document->date_du_courrier;
        $document->date_arrive = $request->get('date-arriv') ?? $document->date_arrive;
        
        // Gestion de la priorité et du traitement
        $document->priorite_id = $request->get('priorite') ?? $document->priorite_id;
        $document->traitement_id = $request->get('traitement_id') ?? $document->traitement_id;
        
        $document->expediteur_externe = $request->get('exp') ?? $document->expediteur_externe;
        
        
        // Gestion de la confidentialité
        $document->confidentiel = $request->has('confidentiel') && 
                                ($request->confidentiel == 'on' || $request->confidentiel == 1) 
                                ? 1 : 0;

        // Gestion du fichier
        if ($request->hasFile('document')) {
            if (!empty($document->document) && Storage::disk('documents')->exists($document->document)) {
                Storage::disk('documents')->delete($document->document);
            }
            $document->document = (new File())->handle($request, 'document', 'documents');
        }
        
        // Si un nouveau destinataire est fourni, on le met à jour
        if ($request->has('destinataire_id')) {
            $document->destinataire_interne_id = $request->get('destinataire_id');
        }

        // Mise à jour des métadonnées
        $document->user_id = Auth::id();
        $document->statut_id = $request->get('statut_id') ?? $document->statut_id ?? 1;
        $document->updated_by = Auth::user()->agent->id;
        
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
            "description" => Auth::user()->name." a mis à jour les informations du document.",
            "user_id" => Auth::user()->id,
        ]);

        $content = json_encode([
            'name' => 'Courriers',
            'statut' => 'success',
            'message' => Auth::user()->name.' a mis à jour les informations du document.',
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
        $courrier = Courrier::with(['document.history', 'type', 'priorite', 'history.user.agent', 'taches.history.user.agent', 'taches.children.history.user.agent'])->findOrFail($id);

        $mergedHistoriques = collect();
        if ($courrier->document) {
            $mergedHistoriques = $mergedHistoriques->merge($courrier->document->history);
        }
        $mergedHistoriques = $mergedHistoriques->merge($courrier->history);
        
        foreach ($courrier->taches as $tache) {
            $tacheHisto = $tache->history->map(function($h) use ($tache) {
                $prefix = "[Tâche: " . $tache->titre . "] ";
                if (strpos($h->description, $prefix) === false) {
                    $h->description = $prefix . $h->description;
                }
                return $h;
            });
            $mergedHistoriques = $mergedHistoriques->merge($tacheHisto);
            
            foreach ($tache->children as $subtache) {
                $subHisto = $subtache->history->map(function($h) use ($subtache) {
                    $prefix = "[Tâche: " . $subtache->titre . "] ";
                    if (strpos($h->description, $prefix) === false) {
                        $h->description = $prefix . $h->description;
                    }
                    return $h;
                });
                $mergedHistoriques = $mergedHistoriques->merge($subHisto);
            }
        }

        $mergedHistoriques = $mergedHistoriques->sortByDesc('created_at')->unique(function ($item) {
            return $item->user_id . $item->description . ($item->created_at ? $item->created_at->timestamp : '');
        });

        // On override la relation pour que la vue PDF utilise les données fusionnées
        $courrier->setRelation('historiques', $mergedHistoriques);

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

            // Copier les pièces jointes du courrier entrant vers le courrier sortant
            if ($courrier->piecesJointes && $courrier->piecesJointes->count() > 0) {
                foreach ($courrier->piecesJointes as $pieceJointe) {
                    $nouvellePieceJointe = new PieceJointe([
                        'nom' => $pieceJointe->nom,
                        'chemin' => $pieceJointe->chemin,
                        'taille' => $pieceJointe->taille,
                        'mime_type' => $pieceJointe->mime_type,
                        'courrier_id' => $newCourrier->id,
                        'document_id' => $pieceJointe->document_id,
                        'uploaded_by' => auth()->id(),
                    ]);
                    
                    $newCourrier->piecesJointes()->save($nouvellePieceJointe);
                }
            }

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
        $historique->description = Auth::user()->name.' a validé ce document.';
        $historique->historiquecable()->associate($courrier);
        $historique->save();

        return response()->json([
            'success' => true,
            'message' => Auth::user()->name.' a validé ce document.'
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
        $historique->key = 'courrier_rejeté';
        $historique->description = Auth::user()->name.' a rejeté ce document.';
        $historique->historiquecable()->associate($courrier);
        $historique->save();

        return response()->json([
            'success' => true,
            'message' => Auth::user()->name.' a rejeté ce document.'
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
     * Déplace un fichier temporaire vers son emplacement final
     * 
     * @param string $fileName Nom du fichier sans extension
     * @return string Chemin du fichier au format JSON
     * @throws \Exception Si le fichier ne peut pas être traité
     */
    public function moveCreatedDoc($fileName)
    {
        try {
            $filesPath = [];
            $sourcePath = 'tmp/' . $fileName . '.pdf';
            $destinationPath = 'documents/' . date('FY') . '/';
            
            // Vérifier si le fichier source existe
            if (!Storage::disk('public')->exists($sourcePath)) {
                throw new \Exception("Le fichier source n'existe pas: " . $sourcePath);
            }
            
            // Générer un nom de fichier unique
            $filename = $this->generateFileName('', 'pdf');
            $fullDestinationPath = $destinationPath . $filename . '.pdf';
            
            // Déplacer le fichier
            if (!Storage::disk('public')->exists($destinationPath)) {
                Storage::disk('public')->makeDirectory($destinationPath);
            }
            
            Storage::disk('public')->move($sourcePath, $fullDestinationPath);
            
            // Vérifier que le fichier a bien été déplacé
            if (!Storage::disk('public')->exists($fullDestinationPath)) {
                throw new \Exception("Échec du déplacement du fichier vers: " . $fullDestinationPath);
            }
            
            $filesPath[] = [
                'download_link' => $fullDestinationPath,
                'original_name' => $fileName . '.pdf',
                'file_name' => $filename . '.pdf',
                'file_path' => $fullDestinationPath,
                'file_type' => 'application/pdf',
                'file_size' => Storage::disk('public')->size($fullDestinationPath),
                'uploaded_at' => now()->toDateTimeString()
            ];
            
            return json_encode($filesPath);
            
        } catch (\Exception $e) {
            \Log::error('Erreur dans moveCreatedDoc', [
                'error' => $e->getMessage(),
                'file' => $fileName,
                'trace' => $e->getTraceAsString()
            ]);
            throw new \Exception('Impossible de traiter le fichier : ' . $e->getMessage());
        }
    }

    /**
     * Traite un fichier PDF scanné et le stocke dans le dossier temporaire
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     * Traite un fichier PDF scanné et le stocke dans le dossier temporaire
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function scan(Request $request)
    {
        // Log ultra-détaillé pour déboguer Asprise Scanner
        \Log::info('🔍 scan() appelée', [
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
                 \Log::warning('❌ Scan: Aucun fichier reçu ou fichier invalide');
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
                    \Log::error('Erreur création dossier scan', ['path' => $fullPath, 'error' => $e->getMessage()]);
                    // On continue, peut-être qu'il existe déjà ou qu'on a un problème de droits
                }
            }
            
            \Log::info('💾 Tentative de stockage (méthode manuelle)', [
                'full_path' => $fullPath,
                'filename' => $fileName,
                'env' => config('app.env')
            ]);

            // Déplacer le fichier manuellement
            $targetFile = $fullPath . '/' . $fileName;
            
            // On utilise move() de l'objet UploadedFile qui gère proprement le déplacement
            try {
                $file->move($fullPath, $fileName);
                \Log::info('✅ Fichier déplacé avec succès', ['target' => $targetFile]);
            } catch (\Exception $e) {
                \Log::error('❌ Erreur move()', ['error' => $e->getMessage()]);
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
            \Log::error('❌ Exception dans scan()', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue: ' . $e->getMessage()
            ], 500);
        }
    }
}
