<?php

namespace App\Http\Controllers;

use App\Events\CourrierCreated;
use App\Jobs\SendEmail;
use App\Mail\EnvoiMailSigne;
use App\Mail\SignaturesMail;
use App\Models\Agent;
use App\Models\Classeur;
use App\Models\Courrier;
use App\Models\CourrierCategory;
use App\Models\CourrierDestinateurExterne;
use App\Models\CourrierExpediteur;
use App\Models\CourrierNature;
use App\Models\CourriersAnnotation;
use App\Models\CourrierTraitement;
use App\Models\Direction;
use App\Models\Document;
use App\Models\Dossier;
use App\Models\Historique;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Nette\Utils\Random;
use Intervention\Image\Image as InterventionImage;


// contacct@newtech-rdc.nets
// ccontact@newtech-rdc.net

class AjaxController extends Controller
{
    // public function typescourriers(Request $request)
    // {
    //     return $this->relation($request, 'courrier-type')->orderBy('id', 'asc');
    
    // }
    public function typescourriers(Request $request)
{
    // Appelle la méthode relation qui retourne directement une JsonResponse
    return $this->relation($request, 'courrier-type');
}


    public function categorycourriers(Request $request)
    {
        return $this->relation($request, 'courrier-category');
    }

    public function categoryCourriersSave(Request $request)
    {
        $category = new CourrierCategory();
        $category->title = $request->title;
        $category->save();
        return response()->json([
            'results' => $category,
        ]);
    }

    public function naturecourriers(Request $request)
    {
        return $this->relation($request, 'courrier-nature');
    }

    public function natureCourriersSave(Request $request)
    {
        $nature = new CourrierNature();
        $nature->titre = $request->titre;
        $nature->save();
        return response()->json([
            'results' => $nature,
        ]);
    }

    public function expediteurcourriers(Request $request)
    {
        // Debug: Afficher les données de la requête
        \Log::info('Requête expediteurcourriers:', $request->all());
        
        // Si une catégorie est spécifiée, on l'ajoute aux données de la requête
        if ($request->has('category_id') && $request->category_id) {
            $request->merge(['relative_id' => $request->category_id]);
        }
        
        $result = $this->relation($request, 'courrier-expediteur');
        \Log::info('Résultat de la relation:', (array) $result);
        
        return $result;
    }

    public function expediteurCourriersSave(Request $request)
    {
        $expediteur = new CourrierExpediteur();
        $expediteur->nom = $request->nom;
        $expediteur->category_id = $request->relative_id;
        $expediteur->save();
        return response()->json([
            'results' => $expediteur,
        ]);
    }

    public function destinatairecourriers(Request $request)
    {
        return $this->relation($request, 'courrier-destinateur-externes');
    }

    public function destinatairecourriersSave(Request $request)
    {
        $destinataire = new CourrierDestinateurExterne();
        $destinataire->nom = $request->nom;
        $destinataire->save();
        return response()->json([
            'results' => $destinataire,
        ]);
    }

    public function getUserSignature()
    {
        $password = Random::generate(6,'0-9');
        Mail::to("contact@newtech-rdc.net")->send(new SignaturesMail($password));  
        
        $data = [];
        $image = Image::select('image_url','password')->where('user_id', Auth::id())->where('type_image', 'SIGNATURE')->first();
       
        $data['image'] = '';

        // Mail::to("contact@newtech-rdc.net")->send(new EnvoiMailSigne($password)); 

        if ($image) {
            // $details = ['email' => 'makombo.mwinaminayi@regideso.cd', 'password' => $password];

            //SendEmail::dispatch(Auth::user()->email, new SignaturesMail($password)); 
            $image->password = $password;
            $image->save();

            $data['image'] = image($image->image_url); //$image; 
        }

        $data['password'] = $password;
        $data['action'] = 1;

        return response()->json($data);
    }

    public function checkUserSignaturePassWord()
    {
        $password = Random::generate(6,'0-9');
        Mail::to("contact@newtech-rdc.net")->send(new SignaturesMail($password));

        $data = [];
        $image = Image::select('image_url','password')->where('user_id', Auth::id())->where('type_image', 'SIGNATURE')->first();
        
        $data['image'] = '';
        // Mail::to("contact@newtech-rdc.net")->send(new SignaturesMail($password)); 

        if ($image) {
            // $details = ['email' => 'makombo.mwinaminayi@regideso.cd', 'password' => $password];

            //SendEmail::dispatch(Auth::user()->email, new SignaturesMail($password));
            // SendEmail::dispatch("contact@newtech-rdc.net", new SignaturesMail($password)); 
            //Mail::to("contact@newtech-rdc.net")->send(new EnvoiMailSigne($password));

            $image->password = $password;
            $image->save();

            $data['image'] = image($image->image_url); //$image; 
        }

        $data['password'] = $password;
        $data['action'] = 1;

        return response()->json($data);
    }

    public function getUserParaphe()
    {
        $password = Random::generate(6,'0-9');
        Mail::to("contact@newtech-rdc.net")->send(new SignaturesMail($password));

        $data = [];
        $image = Image::select('image_url','password')->where('user_id', Auth::id())->where('type_image', 'INITIALES')->first();
       
        $data['image'] = '';
        // Mail::to("contact@newtech-rdc.net")->send(new SignaturesMail($password));

        
        if ($image) {
            // $details = ['email' => 'makombo.mwinaminayi@regideso.cd', 'password' => $password];

            //SendEmail::dispatch(Auth::user()->email, new SignaturesMail($password));

            $image->password = $password;
            $image->save();

            $data['image'] = image($image->image_url); //$image;
        }

        $data['password'] = $password;
        $data['action'] = 2;

        return response()->json($data);
    }

    public function getUserTampon()
    {
        $data = [];
        $image = Image::where('user_id', Auth::id())->where('type_image', 'TAMPON')->first();
        if ($image) {
            // $imagePath = storage_path('app/public/'.$image->image_url);
            // $image = "data:image/png;base64,". base64_encode(file_get_contents($imagePath));
            $data['image'] = image($image->image_url); //$image;;
        }
        $data['action'] = 3;
        return response()->json($data);
    }

    public function saveUserSignature(Request $request)
    {
        $data = [];
        $path = 'images' . DIRECTORY_SEPARATOR . date('FY') . DIRECTORY_SEPARATOR;
        $name = $path . Str::random(20) . '.png'; // decode the base64 file
        $file = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->image));
        Storage::disk('public')->put($name, $file, 'public');

        // $image = (new InterventionImage)->make(Storage::disk('public')->get($name))->trim();

        Image::updateOrCreate(
            [
                "type_image" => "SIGNATURE",
                "user_id" => Auth::user()->id
            ],
            [
                "image_url" => $name,
                "password" => $request->password ? Hash::make($request->password) : ''
            ]
        );

        $data['image_url'] = image($name);
        return response()->json($data);
    }

    public function saveUserTampon(Request $request)
    {
        $data = [];
        $path = 'images' . DIRECTORY_SEPARATOR . date('FY') . DIRECTORY_SEPARATOR;
        $name = $path . Str::random(20) . '.png'; // decode the base64 file
        $file = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->image));
        Storage::disk('public')->put($name, $file, 'public');

        Image::updateOrCreate(
            [
                "type_image" => "TAMPON",
                "user_id" => Auth::user()->id
            ],
            [
                "image_url" => $name,
                "password" => $request->password ? Hash::make($request->password) : ''
            ]
        );

        $data['image_url'] = image($name);
        return response()->json($data);
    }

    public function saveUserParaphe(Request $request)
    {
        $data = [];
        $path = 'images' . DIRECTORY_SEPARATOR . date('FY') . DIRECTORY_SEPARATOR;
        $name = $path . Str::random(20) . '.png'; // decode the base64 file
        $file = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->image));
        Storage::disk('public')->put($name, $file, 'public');

        Image::updateOrCreate(
            [
                "type_image" => "INITIALES",
                "user_id" => Auth::user()->id
            ],
            [
                "image_url" => $name,
                "password" => $request->password ? Hash::make($request->password) : ''
            ]
        );

        $data['image_url'] = image($name);
        return response()->json($data);
    }

    public function validations(Request $request)
    {

        $traitement = new CourrierTraitement();
        $courrier = Courrier::find($request->courrier_id);
        // I save traitement
        $traitement->agent_id = Auth::user()->agent->id;
        $traitement->note = 'Document validé';
        $traitement->save();

        $courrier->traitements()->attach($traitement);

        $courrier->statut_id = 1;
        $courrier->save();

        // I change the stap
        $courrier->etapes()->attach(4);
        $courrier->destinateurs()->attach(Auth::user()->agent->direction->responsable);

        $filesPath = [];
        $pdfFile = $request->file('document');
        $path = 'courrier-traitements/' . date('FY') . '/';
        $filename = $this->generateFileName($pdfFile, $path);
        $filename = $filename . '.' . $pdfFile->getClientOriginalExtension();
        Storage::putFileAs('public/' . $path, $pdfFile, $filename);

        array_push($filesPath, [
            'download_link' => $path . $filename,
            'original_name' => $pdfFile->getClientOriginalName(),
        ]);

        $traitement->document_url = $filesPath;
        $traitement->save();

        Historique::create([
            "key" => "Traitement",
            "historiquecable_id" => $request->courrier_id,
            "historiquecable_type" => Courrier::class,
            "description" => "A validé le courrier",
            "user_id" => Auth::user()->id,
        ]);

        $agentsDestinateurs = $courrier->destinateurs->where('id', '!=', Auth::user()->agent->id);
        if (count($agentsDestinateurs)) {
            event(new CourrierCreated($courrier, $agentsDestinateurs, 'A validé courrier !'));
        }

        if ($courrier->type_id == 1) {
            // mouvement retour
            $myCourrier = $courrier;
            $oldata = $myCourrier->getAttributes();

            unset($oldata['id']);
            unset($oldata['updated_at']);
            unset($oldata['created_at']);

            $destinateurs = Direction::find(1)->dgSecretaires->pluck('responsable_id');
            $document = $this->createDocument($request, $destinateurs->first(), $myCourrier->document);

            $oldata['type_id'] = 2;
            $oldata['created_by'] = Auth::user()->id;
            $oldata['document_id'] = $document->id;
            $oldata['exped_externe'] = null;
            // $oldata['reference_interne'] = Str::padLeft(Courrier::count() + 2, 4, '0');
            $oldata['exped_interne_id'] = Auth::user()->agent->id;
            $oldata['parent_id'] = $myCourrier->id;
            $oldata['traitement_id'] = null;

            $newcourrier = $this->saveCourrierSortant(new Courrier($oldata));

            if ($destinateurs) {
                $newcourrier->destinateurs()->sync($destinateurs);
            }

            if ($request->agent_id !== null && $request->agent_id !== '') {
                $newcourrier->followers()->attach($request->agent_id);
            }

            $newcourrier->etapes()->attach(3);

            if (Auth::user()->agent->direction->dgAssistanats->pluck('responsable_id')->count()) {
                // $newcourrier->destinateurs()->sync(Auth::user()->agent->direction?->assistants()->first()?->agent);
                $newcourrier->destinateurs()->attach(Auth::user()->agent->direction->dgAssistanats->pluck('responsable_id'));
            }

            $notifyAgents = $newcourrier->destinateurs->where('id', '!=', Auth::user()->agent->id)->push($newcourrier->followers);
            $notifyAgents = $notifyAgents->flatten();

            if (count($notifyAgents)) {
                event(new CourrierCreated($newcourrier, $notifyAgents, 'Un nouveau courrier a été créé !'));
            }
        }

        return response()->json(['file' => files($traitement->document_url)->link]);
    }

    public function rejets(Request $request)
    {

        $traitement = new CourrierTraitement();
        $courrier = Courrier::find($request->courrier_id);
        // I save traitement
        $traitement->agent_id = Auth::user()->agent->id;
        $traitement->note = 'Document rejeté';
        $traitement->save();

        $courrier->traitements()->attach($traitement);

        // I change the stap
        $courrier->etapes()->attach(4);
        $courrier->destinateurs()->attach(Auth::user()->agent->direction->responsable);

        $filesPath = [];
        $pdfFile = $request->file('document');
        $path = 'courrier-traitements/' . date('FY') . '/';
        $filename = $this->generateFileName($pdfFile, $path);
        $filename = $filename . '.' . $pdfFile->getClientOriginalExtension();
        Storage::putFileAs('public/' . $path, $pdfFile, $filename);

        array_push($filesPath, [
            'download_link' => $path . $filename,
            'original_name' => $pdfFile->getClientOriginalName(),
        ]);

        $traitement->document_url = $filesPath;
        $traitement->save();

        Historique::create([
            "key" => "Traitement",
            "historiquecable_id" => $request->courrier_id,
            "historiquecable_type" => Courrier::class,
            "description" => "A rejeté le courrier",
            "user_id" => Auth::user()->id,
        ]);

        $annotation = new CourriersAnnotation();
        $annotation->user_id = Auth::user()->id;
        $annotation->courrier_id = $courrier->id;
        $annotation->note = $request->note;
        $annotation->save();

        // I put in copy secretors
        $directions = Direction::find($request->direction_id);
        if ($directions) {
            $agentSecretaires = $directions->map(function ($direction) {
                return $direction->secretaires->pluck('responsable_id')->first();
            })->reject(function ($agent) {
                return $agent == null;
            });

            if (count($agentSecretaires ?? [])) {
                $courrier->followers()->attach($directions);
            }
        }

        $followersToNotify = $courrier->followers->where('id', '!=', Auth::user()->agent->id);

        if (count($followersToNotify)) {
            event(new CourrierCreated($courrier, $followersToNotify, 'A rejeté courrier !'));
        }

        return response()->json(['file' => files(json_encode($traitement->document_url))->link]);
    }

    public function saveCourrierSortant($courrier)
    {

        $courrier->save();

        return $courrier;
    }

    public function createDocument($request, $destinateur, $document = null)
    {
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

        if ($document == null) {

            if ($request->is_scan == "true") {

                // $dossier = Dossier::where('titre', 'Courriers')->first();
                // $classeur = null;

                // if ($dossier != null) {
                //     if ($dossier->classeur) {
                //         $classeur = $dossier->classeur;
                //     } else {
                //         $classeur = Classeur::create([
                //             'titre' => Auth::user()->agent->direction?->lieu?->titre ?? 'Region inconnu'
                //         ]);
                //     }
                // } else {
                //     $classeur = Classeur::create([
                //         'titre' => 'Courriers',
                //         'reference' => $request->get('ref'),
                //         'direction_id' => Agent::find($destinateur)?->direction_id,
                //         'created_by' => Auth::user()->agent->id,
                //         'updated_by' => Auth::user()->agent->id,
                //     ]);
                //     $dossier = Dossier::create([
                //         'titre' => 'Courriers',
                //         'reference' => $request->get('ref'),
                //         'classeur_id' => $classeur->id,
                //         'created_by' => Auth::user()->agent->id,
                //         'updated_by' => Auth::user()->agent->id,
                //     ]);
                // }

                $document = new Document();
                $document->dossier_id = $dossier->id;
                $document->reference = $request->get('ref');
                $document->category_id = $request->get('categorie');
                $document->libelle = $request->get('title');
                $document->type = $request->get('type');
                $document->document = (new ScanFile())->handle('documents');
                $document->user_id = Auth::user()->id;
                $document->statut_id = 1;
                $document->created_by = Auth::user()->agent->id;
                $document->save();

                return $document;
            }

            if ($request->hasFile('document') && ($request->document_id == null || $request->document_id == '')) {
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
                //         'direction_id' => Agent::find($destinateur)?->direction_id,
                //         'created_by' => Auth::user()->agent->id,
                //         'updated_by' => Auth::user()->agent->id,
                //     ]);
                //     $dossier = Dossier::create([
                //         'titre' => 'Courriers',
                //         'reference' => $request->get('ref'),
                //         'classeur_id' => $classeur->id,
                //         'created_by' => Auth::user()->agent->id,
                //         'updated_by' => Auth::user()->agent->id,
                //     ]);
                // }
                $document = new Document();
                $document->dossier_id = $dossier->id;
                $document->reference = $request->get('ref');
                $document->category_id = $request->get('categorie');
                $document->libelle = $request->get('title');
                $document->type = $request->get('type');
                $document->document = (new File())->handle($request, 'document', 'documents');
                $document->user_id = Auth::user()->id;
                $document->statut_id = 1;
                $document->created_by = Auth::user()->agent->id;
                $document->save();
            } elseif ($request->has('document_id') && ($request->document_id != null || $request->document_id != '')) {
                $document = Document::find($request->document_id);
            }

        } else {
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
            //         'reference' => $document->reference . '/R',
            //         'direction_id' => Agent::find($destinateur)?->fonction()?->service?->id,
            //         'created_by' => Auth::user()->agent->id,
            //         'updated_by' => Auth::user()->agent->id,
            //     ]);
            //     $dossier = Dossier::create([
            //         'titre' => 'Courriers',
            //         'reference' => $document->reference . '/R',
            //         'classeur_id' => $classeur->id,
            //         'created_by' => Auth::user()->agent->id,
            //         'updated_by' => Auth::user()->agent->id,
            //     ]);
            // }
            $document = new Document();
            $document->dossier_id = $dossier->id;
            $document->reference = $document->reference . '/R';
            $document->category_id = $document->category_id;
            $document->libelle = $document->libelle;
            $document->type = $document->type;
            $document->document = (new File())->handle($request, 'document', 'documents');
            $document->user_id = Auth::user()->id;
            $document->statut_id = 1;
            $document->created_by = Auth::user()->agent->id;
            $document->save();
        }

        return $document;
    }

    public function relation(Request $request, $slug)
    {
        // Debug: Log des paramètres de la requête
        \Log::info('Méthode relation appelée avec les paramètres:', [
            'slug' => $slug,
            'request_all' => $request->all(),
            'route' => $request->route() ? $request->route()->getName() : null
        ]);

        $page = $request->input('page', 1);
        $on_page = 50;
        $search = $request->input('search', false);
        $method = $request->input('method', 'add');

        // Debug: Log du modèle cible
        $modelClass = '\App\Models\\' . Str::ucfirst(Str::camel(Str::singular($slug)));
        \Log::info('Modèle ciblé:', ['class' => $modelClass]);

        try {
            $model = app($modelClass);
            \Log::info('Modèle instancié avec succès');
        } catch (\Exception $e) {
            \Log::error('Erreur lors de l\'instanciation du modèle', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['results' => [], 'pagination' => ['more' => false]]);
        }

        if ($method != 'add') {
            $model = $model->find($request->input('id'));
        }

        // Si un modèle spécifique est fourni dans la requête
        if ($request->has('model')) {
            try {
                $model = app('\App\Models\\' . Str::ucfirst(Str::camel(Str::singular($request->input('model')))));
                \Log::info('Modèle remplacé par celui de la requête');
            } catch (\Exception $e) {
                \Log::error('Erreur lors du chargement du modèle spécifié', [
                    'model' => $request->input('model'),
                    'error' => $e->getMessage()
                ]);
            }
        }

        $skip = $on_page * ($page - 1);
        $additional_attributes = $model->additional_attributes ?? [];

        // Debug: Log des paramètres de requête
        \Log::info('Paramètres de la requête SQL:', [
            'search' => $search,
            'page' => $page,
            'skip' => $skip,
            'relative_id' => $request->input('relative_id'),
            'category_id' => $request->input('category_id')
        ]);

        // Si recherche par texte
        if ($search) {
            $query = $model->where($request->input('label', 'nom'), 'LIKE', '%' . $search . '%');
            
            if ($slug == 'courrier-expediteur' && $request->has('relative_id')) {
                $query->where('category_id', $request->input('relative_id'));
                \Log::info('Filtrage par relative_id:', ['relative_id' => $request->input('relative_id')]);
            } elseif ($slug == 'courrier-expediteur' && $request->has('category_id')) {
                $query->where('category_id', $request->input('category_id'));
                \Log::info('Filtrage par category_id:', ['category_id' => $request->input('category_id')]);
            }
            
            $total_count = $query->count();
            $relationshipOptions = $query->take($on_page)->skip($skip)->get();
        } else {
            // Sans recherche
            $query = $model->newQuery();
            
            if ($slug == 'courrier-expediteur') {
                if ($request->has('relative_id')) {
                    $query->where('category_id', $request->input('relative_id'));
                    \Log::info('Filtrage sans recherche par relative_id:', ['relative_id' => $request->input('relative_id')]);
                } elseif ($request->has('category_id')) {
                    $query->where('category_id', $request->input('category_id'));
                    \Log::info('Filtrage sans recherche par category_id:', ['category_id' => $request->input('category_id')]);
                } else {
                    \Log::warning('Aucun filtre de catégorie fourni pour les expéditeurs');
                }
            }
            
            $total_count = $query->count();
            $relationshipOptions = $query->take($on_page)->skip($skip)->get();
        }

        $results = [];

        if (!$search && $page == 1) {
            $results[] = [
                'id' => '',
                'text' => 'aucune donnée trouvée',
            ];
        }

        $relationshipOptions = $relationshipOptions->sortBy($request->input('label'));

        foreach ($relationshipOptions as $relationshipOption) {
            $results[] = [
                'id' => $relationshipOption->id,
                'text' => $relationshipOption->{$request->input('label')},
            ];
        }

        // dd($results);

        return response()->json([
            'results' => $results,
            'pagination' => [
                'more' => ($total_count > ($skip + $on_page)),
            ],
        ]);

        // No result found, return empty array
        // return response()->json([], 404);
    }

    public function priorites(Request $request)
{
    return $this->relation($request, 'priorite');
}

    public function generateFileName($file, $path)
    {
        $filename = Str::random(20);

        // Make sure the filename does not exist, if it does, just regenerate
        while (Storage::disk('public')->exists($path . $filename . '.' . $file->getClientOriginalExtension())) {
            $filename = Str::random(20);
        }

        return $filename;
    }
}
