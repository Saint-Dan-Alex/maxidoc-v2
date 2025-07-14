<?php

namespace App\Http\Controllers\Documents;

use App\Events\DocumentCreated;
use App\Http\Controllers\Controller;
use App\Http\Controllers\File;
use App\Models\Agent;
use App\Models\ArchivePermission;
use App\Models\Classeur;
use App\Models\Courrier;
use App\Models\CourrierTraitement;
// use App\Models\Departement;
// use App\Models\Direction;
// use App\Models\Division;
use App\Models\Document;
use App\Models\DocumentNature;
use App\Models\DocumentTemplate;
use App\Models\DocumentType;
use App\Models\Dossier;
use App\Models\LieuAffectation;
use App\Models\Service;
use App\Models\Tache;
use App\Models\User;
use App\Models\Brouillon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\Snappy\Facades\SnappyPdf;

class DocumentController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = [];
        $documents = Document::all();
       
            return view('regidoc.pages.documents.index', compact('documents'));
    }

        // dd(Auth::user()->hasRole('Admin'));
        // if (Auth::user()->hasRole('Admin')) {
        //     $classeurs = Classeur::all();
        // } else {
        //     $classeurs = Classeur::where('direction_id', Auth::user()->agent->direction_id)->get();
        // }
        // if (Auth::user()->role_id == '1') {
        //     $dossiers = Dossier::all();
        // } else {
        //     $dossiers = Dossier::all();
        // }
        // $filesCount = Document::count();

        // return view('regidoc.pages.documents.index')->with(
        //     [
        //         'classeurs' => $classeurs,
        //         'dossiers' => $dossiers,
        //         'filesCount' => $filesCount
        //     ]
        // );

        // $data = [];
        // if (Auth::user()->hasRole('Admin')) {
        //     $data = [
        //         'directions' => Direction::select('id','titre')->get()
        //     ];
        //     return view('regidoc.pages.documents.hierachie.direction')->with($data);
        // }else {
        //     // return view('regidoc.pages.documents.index')->with(
        //     //     [
        //     //         'classeurs' => $classeurs,
        //     //         'dossiers' => $dossiers,
        //     //         'filesCount' => $filesCount
        //     //     ]
        //     // );
        // }
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $types = DocumentType::all();
        $natures = DocumentNature::all();
        $services = Service::all();
        $agents = Agent::all();
        return view('regidoc.pages.documents.new-doc')->with([
            'types' => $types,
            'natures' => $natures,
            'services' => $services,
            'agents' => $agents,
            'dossier_id' => $request->dossier,
        ]);
    }

    public function showDoc(Request $request)
    {
        if ($request->fichier_id && $request->tache_id) {
            $doc = Document::findOrFail($request->fichier_id);
            $tache = Tache::findOrFail($request->tache_id);
            // if ($tache->agents->contains('id', Auth::user()->agent->id) || Auth::id() == $tache->user_id) {
            // code...
            return view('regidoc.pages.documents.show-task-doc')->with(
                ['doc' => $doc, 'tache' => $tache]
            );
            // }
        } elseif($request->fichier_id) {
            $doc = Document::findOrFail($request->fichier_id);
            return view('regidoc.pages.documents.show-task-doc')->with(
                ['doc' => $doc,]
            );
        }
        return abort('403');
    }

    public function sign(Request $request)
    {
        try {
            $tache = Tache::find($request->tache_id);
            $courrier = Courrier::find($request->courrier_id);
            $isTraitement = false;
            $doc = null;
            $is_original = $request->is_original == 'false' || $request->is_original == '0' ? false : true;

            if ((! $tache && ($courrier && $is_original)) || (! $courrier && $tache)) {
                $doc = Document::find($request->doc_id);
            } else {
                $isTraitement = true;
                $doc = CourrierTraitement::find($request->doc_id);
            }

            $agents = Agent::select('id', 'prenom', 'nom')->where('id', '!=', Auth::user()->agent->id)->get();
        } catch (\Throwable $th) {
            $content = json_encode([
                'name' => 'Document',
                'statut' => 'error',
                'message' => 'Impossible de signer le document, une erreur s\'est produite',
            ]);
            session()->flash(
                'session',
                $content
            );
            return redirect()->back();
        }

        return view('regidoc.pages.documents.signature')->with([
            'doc' => $doc,
            'tache' => $tache,
            'courrier' => $courrier,
            'is_original' => $is_original,
            'agents' => $agents,
            'isTraitement' => $isTraitement,
        ]);
    }

    public function createDoc()
    {
        return view('regidoc.pages.documents.preview.pdf-documentLetter');
    }
 
    // public function generatePDF(Request $request)
    // {
    //     // Valider les données du formulaire
    //     $data = [
    //         'reference' => $request->ref,
    //         'lieu_copie' => $request->lieu_copie,
    //         'dest' => $request->dest,
    //         'ville' => $request->ville,
    //         'lieu_date' => $request->lieu_date,
    //         'objet' => $request->objet,
    //         'content' => $request->content,
    //         'exp_fonction' => $request->exp_fonction, 
    //         'exp_name' => $request->exp_name, 
    //     ];

    //     // Créer un PDF à partir de la vue Blade en utilisant SnappyPDF
    //     $pdf = SnappyPdf::loadView('regidoc.pages.documents.preview.pdf-vue', $data);
    //     $pdf->setOption('enable-javascript', true);
    //     $pdf->setOption('javascript-delay', 1000); // 1000 ms de délai pour laisser le JS se charger correctement

    //     // Enregistrer le PDF temporairement
    //     $pdfname = Str::limit($request->objet, 10);
    //     $pdfPath = storage_path('app/public/tmp/'.$pdfname.'.pdf');
    //     $pdf->save($pdfPath);

    //      // Stocker le chemin du PDF dans la session
    //     $request->session()->put('pdfPath', $pdfPath);
    //     $request->session()->put('data', $data);
    //     $request->session()->put('pdfname', $pdfname);

    //     // Redirection vers la vue d'aperçu
    //     return redirect()->route('regidoc.document.preview');

        
    // }
    public function generatePDF(Request $request)
    {
        // Valider les données du formulaire
        $data = [
            'reference' => $request->ref,
            'lieu_copie' => $request->lieu_copie,
            'dest' => $request->dest,
            'ville' => $request->ville,
            'lieu_date' => $request->lieu_date,
            'objet' => $request->objet,
            'content' => $request->content,
            'exp_fonction' => $request->exp_fonction, 
            'exp_name' => $request->exp_name, 
        ];

        // Créer un PDF à partir de la vue Blade en utilisant DomPDF
        $pdf = Pdf::loadView('regidoc.pages.documents.preview.pdf-vue', $data);

        // Enregistrer le PDF temporairement
        $pdfname = Str::slug(Str::limit($request->objet, 50), '_');
        $tmpDir = storage_path('app/public/tmp');
        if (!file_exists($tmpDir)) {
            mkdir($tmpDir, 0755, true);
        }
        $pdfPath = $tmpDir . DIRECTORY_SEPARATOR . $pdfname . '.pdf';
        $pdf->save($pdfPath);

        // Stocker le chemin du PDF dans la session
        $request->session()->put('pdfPath', $pdfPath);
        $request->session()->put('data', $data);
        $request->session()->put('pdfname', $pdfname);

        // Redirection vers la vue d'aperçu
        return redirect()->route('regidoc.document.preview');
    }


    public function createNew(Request $request)
    {
        if ($request->doc_type) {
            $template = Str::replace(' ', '_', DocumentTemplate::find($request->doc_type)->titre);
            if (Auth::user()->agent->isDG() || Auth::user()->agent->isResponsable() || Auth::user()->agent->isSecretaire() || Auth::user()->agent->isAssistant()) {
                $agents = Agent::select('id', 'nom', 'post_nom')->where('user_id', '!=', Auth::id())->get();
            } else {
                $agents = Agent::where('direction_id', Auth::user())->where('user_id', '!=', Auth::id())->get();
            }
            return view('regidoc.pages.documents.create-doc')->with([
                'doc_type' => $request->doc_type,
                'template' => $template,
                'agents' => $agents,
                'brouillon' => $request->brouillon ?? null,
            ]);
        }
        return redirect()->route('regidoc.home');
    }

    // public function getData(Request $request)
    // {
    //     $docId = DocumentTemplate::find($request->id)->id;
    //     $data = [];
    //     $view = '';

    //     switch ($docId) {
    //         case 1:
    //             $data = [
    //                 'reference' => $request->reference,
    //                 'copies' => $request->copie, // 'copies' is an array of values
    //                 'lieu_copie' => $request->lieu_copie,
    //                 'dest' => $request->dest,
    //                 'ville' => $request->ville,
    //                 'lieu_date' => $request->lieu_date,
    //                 'exp_fonction' => $request->exp_fonction,
    //                 'exp_name' => $request->exp_name,
    //                 'concerne' => $request->concerne,
    //                 'body' => $request->body,
    //                 'cosignataires' => $request->cosignataires
    //             ];
    //             $view = 'regidoc.pages.templates.templateLetter';
    //             break;
    //         case 2:
    //             $data = [
    //                 'rue' => $request->rue,
    //                 'num' => $request->num,
    //                 'bp' => $request->bp,
    //                 'idnat' => $request->idnat,
    //                 'phone' => $request->phone,
    //                 'email' => $request->email,
    //                 'impot' => $request->impot,
    //                 'bon' => $request->bon,
    //                 'fournisseur' => $request->fournisseur,
    //                 'date' => $request->date,
    //                 'location' => $request->location,
    //                 'exp_fonction' => $request->exp_fonction,
    //                 'exp_name' => $request->exp_name
    //             ];
    //             $view = 'regidoc.pages.templates.demande-achat';
    //             break;
    //         case 4:
    //             $data = [
    //                 'dest' => $request->dest,
    //                 'dest_mat' => $request->dest_mat,
    //                 'deste_poste' => $request->deste_poste,
    //                 'direction' => $request->direction,
    //                 'division' => $request->division,
    //                 'section' => $request->section,
    //                 'reference' => $request->reference,
    //                 'directeur' => $request->directeur,
    //                 'lieu_date' => $request->lieu_date,
    //                 'exp_fonction' => $request->exp_fonction,
    //                 'exp_name' => $request->exp_name,
    //                 'dest_fonction' => $request->dest_fonction,
    //                 'dest_name' => $request->dest_name,
    //                 'concerne' => $request->concerne,
    //                 'body' => $request->body
    //             ];
    //             $view = 'regidocs.pages.template.template-1';
    //             break;
    //         case 5:
    //             $data = [
    //                 'copies' => $request->copie, // 'copies' is an array of values
    //                 'reference' => $request->reference,
    //                 'lieu_date' => $request->lieu_date,
    //                 'concerne' => $request->concerne,
    //                 'body' => $request->body,
    //                 'exp_fonction' => $request->exp_fonction,
    //                 'exp_name' => $request->exp_name,
    //                 'dest_fonction' => $request->dest_fonction,
    //                 'dest_name' => $request->dest_name,
    //                 'cosignataires' => $request->cosignataires
    //             ];
    //             $view = 'regidoc.pages.templates.message-email';
    //             break;
    //         case 6:
    //             $data = [
    //                 'direction' => $request->direction,
    //                 'reference' => $request->reference,
    //                 'lieu_date' => $request->lieu_date,
    //                 'concerne' => $request->concerne,
    //                 'body' => $request->body,
    //                 'exp_fonction' => $request->exp_fonction,
    //                 'exp_name' => $request->exp_name
    //             ];
    //             $view = 'regidoc.pages.templates.note-service';
    //             break;
    //         case 7:
    //             $data = [
    //                 'reference' => $request->reference,
    //                 'dest' => $request->dest,
    //                 'dest_mat' => $request->dest_mat,
    //                 'deste_poste' => $request->deste_poste,
    //                 'direction' => $request->direction,
    //                 'location' => $request->location,
    //                 'date' => $request->date,
    //                 'division' => $request->division,
    //                 'concerne' => $request->concerne,
    //                 'body' => $request->body,
    //                 'lieu_date' => $request->lieu_date,
    //                 'exp_fonction' => $request->exp_fonction,
    //                 'exp_name' => $request->exp_name
    //             ];
    //             $view = 'regidoc.pages.templates.ordreMission';
    //             break;
    //         case 8:
    //             $data = [
    //                 'copies' => $request->copie, // 'copies' is an array of values
    //                 'reference' => $request->reference,
    //                 'lieu_date' => $request->lieu_date,
    //                 'concerne' => $request->concerne,
    //                 'body' => $request->body,
    //                 'exp_fonction' => $request->exp_fonction,
    //                 'exp_name' => $request->exp_name,
    //                 'dest_fonction' => $request->dest_fonction,
    //                 'dest_name' => $request->dest_name,
    //                 'cosignataires' => $request->cosignataires
    //             ];
    //             $view = 'regidoc.pages.templates.note-circulaire';
    //             break;
    //         default:
    //             throw new \Exception('Invalid document template ID');
    //     }

    //     return [$data, $view];
    // }

   

    // public function showPDFPreview(Request $request)
    // {
    //     $doc_type = $request->doc_type;
    //     $brouillon = $request->brouillon ? Brouillon::find($request->brouillon) : null; 

    //     // Utiliser un switch pour afficher des templates différents
    //     switch ($doc_type) {
    //         case 1: // Lettre officielle
    //             $data = [
    //                 'doc_type' => $doc_type,
    //                 'reference' => $brouillon->reference ?? '',
    //                 'copies' => $brouillon ? json_decode($brouillon->copies) : [],
    //                 'lieu_copie' => $brouillon->lieu_copie ?? '',
    //                 'dest' => $brouillon->dest ?? '',
    //                 'ville' => $brouillon->ville ?? '',
    //                 'lieu_date' => $brouillon->lieu_date ?? '',
    //                 'exp_fonction' => $brouillon->exp_fonction ?? '',
    //                 'exp_name' => $brouillon->exp_name ?? '',
    //                 'concerne' => $brouillon->concerne ?? '',
    //                 'body' => $brouillon->body ?? '',
    //                 'cosignataires' => $brouillon ? json_decode($brouillon->cosignataires) : [],
    //             ];
    //             $view = 'regidoc.pages.documents.preview.pdf-documentLetter';
    //             break;
    //         case 2: // Bon de commande
    //             $data = [
    //                 'doc_type' => $doc_type,
    //                 'rue' => $brouillon->rue ?? '',
    //                 'num' => $brouillon->num ?? '',
    //                 'bp' => $brouillon->bp ?? '',
    //                 'idnat' => $brouillon->idnat ?? '',
    //                 'phone' => $brouillon->phone ?? '',
    //                 'email' => $brouillon->email ?? '',
    //                 'impot' => $brouillon->impot ?? '',
    //                 'bon' => $brouillon->bon ?? '',
    //                 'fournisseur' => $brouillon->fournisseur ?? '',
    //                 'date' => $brouillon->date ?? '',
    //                 'location' => $brouillon->location ?? '',
    //                 'exp_fonction' => $brouillon->exp_fonction ?? '',
    //                 'exp_name' => $brouillon->exp_name ?? '',
    //             ];
    //             $view = 'regidoc.pages.documents.templates.preview-template-bon-commande';
    //             break;
    //         case 5: // Note circulaire
    //             $data = [
    //                 'doc_type' => $doc_type,
    //                 'copies' => $brouillon ? json_decode($brouillon->copies) : [],
    //                 'reference' => $brouillon->reference ?? '',
    //                 'lieu_date' => $brouillon->lieu_date ?? '',
    //                 'concerne' => $brouillon->concerne ?? '',
    //                 'body' => $brouillon->body ?? '',
    //                 'exp_fonction' => $brouillon->exp_fonction ?? '',
    //                 'exp_name' => $brouillon->exp_name ?? '',
    //                 'dest_fonction' => $brouillon->dest_fonction ?? '',
    //                 'dest_name' => $brouillon->dest_name ?? '',
    //                 'cosignataires' => $brouillon ? json_decode($brouillon->cosignataires) : [],
    //             ];
    //             $view = 'regidoc.pages.documents.templates.preview-template-note-circulaire';
    //             break;
    //         // Ajouter d'autres cas pour d'autres types de documents
    //         default:
    //             $data = [];
    //             $view = 'regidoc.pages.documents.templates.default-preview'; // Template par défaut
    //     }

    //     // Rendre la vue correcte en fonction du type de document
    //     return view($view, compact('data'));
    // }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $document = new Document();
            $document->dossier_id = $request->dossier_id;
            $document->category_id = $request->categorie;
            $document->reference = $request->ref;
            $document->libelle = $request->title;
            $document->type = $request->type;
            $document->description = $request->objet;
            $document->document = (new File())->handle($request, 'document', 'documents');
            $document->user_id = Auth::user()->id;
            $document->statut_id = 1;
            $document->created_by = Auth::user()->agent->id;
            $document->save();

            ArchivePermission::create([
                'agent_id' => Auth::user()->agent->id,
                'permissionable_id' => $document->id,
                'permissionable_type' => 'App\Models\Document',
                'key' => 'view_document',
            ]);

            event(new DocumentCreated($document, 'Un nouveau document a été créé !'));

            $content = json_encode([
                'name' => 'Document',
                'statut' => 'success',
                'message' => 'Document enregistré avec succès !',
            ]);
        } catch (\Throwable $th) {
            $content = json_encode([
                'name' => 'Document',
                'statut' => 'error',
                'message' => 'Impossible de créer le document, une erreur s\'est produite',
            ]);
        }

        session()->flash(
            'session',
            $content
        );

        return redirect()->route('regidoc.dossiers.show', $request->dossier_id);
    }

    public function storeNew(Request $request)
    {
        $pdfFile = $request->file('pdfFile');
        $fileName = $pdfFile->getClientOriginalName();
        Storage::putFileAs('public/tmp', $pdfFile, $fileName);
        return response()->json(['message' => 'PDF uploaded successfully']);
    }

    public function saveDoc(Request $request)
    {
        try {
            $dossierName = $request->textSelected;
            $fileName = $request->fileName . '.pdf';
            $dossierName = $request->dossiername;
            $docName = $dossierName . date('_dmYi') . '.pdf';
            $path = 'public' . DIRECTORY_SEPARATOR . 'documents' . DIRECTORY_SEPARATOR . date('FY') . DIRECTORY_SEPARATOR;

            if (Storage::disk('public')->exists('tmp/' . $fileName)) {
                $doc = Storage::disk('public')->get('tmp/' . $fileName);
                Storage::disk('local')->put($path . $docName, $doc);
                Storage::disk('public')->delete('tmp/' . $fileName);
            }
            $classer = Classeur::firstOrCreate(
                [
                    'direction_id' => Auth::user()->agent->direction_id,
                    'titre' => 'Classeur Interne ' . Auth::user()->agent->direction->titre,
                ],
                [
                    'description' => 'Classeur pour les documents internes ' . Auth::user()->agent->direction->titre,
                    'created_by' => Auth::user()->agent->id,
                    'updated_by' => Auth::user()->agent->id,
                ]
            );

            $dossier = Dossier::where('reference', 'DC/' . Auth::user()->agent?->matricule, )->first();
            if ($dossier == null) {
                $dossier = Dossier::firstOrCreate(
                    [
                        'classeur_id' => $classer->id,
                        'titre' => $dossierName,
                    ],
                    [
                        'reference' => 'DC/' . Auth::user()->agent?->matricule,
                        'confidentiel' => 0,
                        'description' => 'Dossier pour les documents créés de l\'agent ' . Auth::user()->agent?->nom,
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
                'reference' => 'DC/' . Auth::user()->agent?->matricule,
                'type' => 3,
                'document' => json_encode($filesPath),
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

            event(new DocumentCreated($document, 'Un nouveau document a été créé !'));
            Storage::disk('local')->delete('tmp/' . $fileName);

            $content = json_encode([
                'name' => 'Document',
                'statut' => 'success',
                'message' => 'Document enregistré avec succès !',
            ]);
        } catch (\Throwable $th) {
            // dd($th);
            $content = json_encode([
                'name' => 'Document',
                'statut' => 'error',
                'message' => 'Impossible de créer le document, une erreur s\'est produite',
            ]);
            session()->flash(
                'session',
                $content
            );
            return redirect()->route('regidoc.documents.createNew');
        }

        session()->flash(
            'session',
            $content
        );

        return redirect()->route('regidoc.documents.index');
    }
    /**
     * Display the specified resource.
     *
     * @param  Document  $document
     * @return \Illuminate\Http\Response
     */
    public function show(Document $document)
    {
        $classeurs = Classeur::all();
        $dossiers = Dossier::all();
        return view('regidoc.pages.documents.show-doc')->with([
            'find_document' => $document,
            'classeurs' => $classeurs,
            'dossiers' => $dossiers,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Document  $document
     * @return \Illuminate\Http\Response
     */
    public function edit(Document $document)
    {
        $types = DocumentType::all();
        $natures = DocumentNature::all();
        // $departements = Departement::all();
        $agents = Agent::all();
        return view('regidoc.pages.documents.edit-doc')->with([
            'types' => $types,
            'natures' => $natures,
            // 'departements' => $departements,
            'agents' => $agents,
            'document' => $document,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Document  $document
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Document $document)
    {
        try {
            // $document = new Document();
            // $document->dossier_id = $request->dossier_id;
            $document->category_id = $request->categorie;
            $document->reference = $request->ref;
            $document->libelle = $request->title;
            $document->type = $request->type;
            $document->description = $request->objet;
            $document->document = $request->hasFile('document') ? (new File())->handle($request, 'document', 'documents') : $document->document;
            // $document->user_id = Auth::user()->id;
            // $document->statut_id = 1;
            // $document->created_by = Auth::user()->agent->id;
            $document->save();

            $content = json_encode([
                'name' => 'Document',
                'statut' => 'success',
                'message' => 'Document modifié avec succès !',
            ]);
        } catch (\Throwable $th) {
            $content = json_encode([
                'name' => 'Document',
                'statut' => 'error',
                'message' => 'Impossible de modifier le document, une erreur s\'est produite',
            ]);
        }

        session()->flash(
            'session',
            $content
        );

        return redirect()->route('regidoc.dossiers.show', $document->dossier->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy(Document $document)
    {
        // dd($document);
        $document->delete();

        $content = json_encode([
            'name' => 'Document',
            'statut' => 'success',
            'message' => 'Document supprimé avec succès !',
        ]);

        session()->flash(
            'session',
            $content
        );
        return redirect()->route('regidoc.dossiers.show', $document->dossier);
    }

    public function archive(Request $request)
    {
        $document = Document::find($request->document_id);
        $document->statut_id = 6;
        $document->save();

        $content = json_encode([
            'name' => 'Document',
            'statut' => 'success',
            'message' => 'Document archivé avec succès !',
        ]);

        session()->flash(
            'session',
            $content
        );

        return redirect()->route('regidoc.documents.index', $document->dossier);
    }

    public function desarchiver(Request $request)
    {
        $document = Document::find($request->document_id);
        $document->statut_id = 2;
        $document->save();

        $content = json_encode([
            'name' => 'Document',
            'statut' => 'success',
            'message' => 'Document desarchivé avec succès !',
        ]);

        session()->flash(
            'session',
            $content
        );

        return redirect()->route('regidoc.dossiers.show', $document->dossier);
    }

    public function saveNew(Request $request)
    {
        try {
            $document = new Document();
            $document->reference = $request->reference;
            $document->libelle = $request->objet;
            $document->type = 3;

            // Déplacer le document créé dans le dossier 'generated'
            $pdfname = $request->pdfname;
            $document->document = $this->moveCreatedDoc($pdfname, $pdfname); // Le chemin du fichier PDF sauvegardé
            $document->user_id = auth()->user()->id;
            $document->statut_id = 1;
            $document->created_by = auth()->user()->id;

            $document->save();

            ArchivePermission::create([
                'agent_id' => auth()->user()->agent->id,
                'permissionable_id' => $document->id,
                'permissionable_type' => 'App\Models\Document',
                'key' => 'view_document',
            ]);

            event(new DocumentCreated($document, 'Un nouveau document a été créé !'));

            session()->flash('session', json_encode([
                'name' => 'Document',
                'statut' => 'success',
                'message' => 'Document enregistré avec succès !',
            ]));
        } catch (\Throwable $th) {
            dd($th);
            session()->flash('session', json_encode([
                'name' => 'Document',
                'statut' => 'error',
                'message' => 'Impossible de créer le document, une erreur s\'est produite',
            ]));
        }

        return redirect()->route('regidoc.documents.index');
    }



    public function previewDocument(Request $request)
    {
        $pdfPath = $request->session()->get('pdfPath');
        $data = $request->session()->get('data');
        $pdfname = $request->session()->get('pdfname');
    
        if (!$pdfPath) {
            return redirect()->route('regidoc.home')->with('error', 'Aucun document à prévisualiser.');
        }
    
        return view('regidoc.pages.documents.show-new-doc', [
            'pdfPath' => $pdfPath,
            'data' => $data,
            'pdfname' => $pdfname
        ]);
    }

    public function deleteTempDocument(Request $request)
    {
        $filename = $request->filename;
        $tmpFilePath = 'tmp/' . $filename . '.pdf';
        if (Storage::disk('public')->exists($tmpFilePath)) {
            try {
                Storage::disk('public')->delete($tmpFilePath);
                return redirect()->route('regidoc.home')->with('success', 'Document temporaire supprimé avec succès.');
            } catch (\Exception $e) {
                return redirect()->route('regidoc.home')->with('error', 'Erreur lors de la suppression du document : ' . $e->getMessage());
            }
        } else {
            return redirect()->route('regidoc.home')->with('error', 'Le fichier n\'existe pas ou a déjà été supprimé.');
        }
    }

    public function moveCreatedDoc($filename, $pdfname)
    {
        $filesPath = [];
        $path = 'documents' . DIRECTORY_SEPARATOR . date('FY') . DIRECTORY_SEPARATOR;
        $tmpFilePath = 'tmp/' . $pdfname . '.pdf';
        $file = Storage::disk('public')->get($tmpFilePath);

        $filename = $pdfname.Str::random(4, '0123456789') . '.pdf';
        // $filename = $this->generateFileName($file, 'pdf');

        Storage::disk('public')->put($path . $filename, $file);

        // Delete the temporary file after saving it to the new path
        Storage::disk('public')->delete($tmpFilePath);

        array_push($filesPath, [
            'download_link' => $path . $filename,
            'original_name' => 'regidoc ' . now()->format('dmYhms'),
        ]);

        return json_encode($filesPath);
    }

    public function generateFileName($file, $path)
    {
         $filename = Str::random(20);
      //  $filename = $name;
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

}
