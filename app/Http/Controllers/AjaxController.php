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
use App\Models\Redacteur;
use App\Models\Historique;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Nette\Utils\Random;
use Illuminate\Support\Facades\Log;
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
        return $this->relation($request, 'courrier-expediteur');
    }

    public function redacteurs(Request $request)
    {
        // Utilise la méthode générique pour retourner les rédacteurs (App\Models\Redacteur)
        return $this->relation($request, 'redacteur');
    }

    public function redacteursSave(Request $request)
    {
        $redacteur = new Redacteur();
        $redacteur->nom = $request->nom;
        $redacteur->save();
        return response()->json([
            'results' => $redacteur,
        ]);
    }

    public function contactsExpediteur(Request $request)
    {
        $expediteurId = $request->input('expediteur_id');
        
        $contacts = CourrierExpediteur::where('id', $expediteurId)
            ->whereNotNull('contact')
            ->pluck('contact')
            ->unique()
            ->map(function($contact) {
                return ['id' => $contact, 'text' => $contact];
            })
            ->values();
            
        return response()->json([
            'results' => $contacts
        ]);
    }

    public function expediteurCourriersSave(Request $request)
    {
        $expediteur = new CourrierExpediteur();
        $expediteur->nom = $request->nom;
        $expediteur->contact = $request->contact;
        $expediteur->category_id = $request->relative_id;
        $expediteur->save();
        return response()->json([
            'results' => $expediteur,
        ]);
    }
    
    public function contactExpediteurSave(Request $request)
    {
        $expediteur = CourrierExpediteur::find($request->expediteur_id);
        if ($expediteur) {
            $expediteur->contact = $request->contact;
            $expediteur->save();
            
            return response()->json([
                'success' => true,
                'contact' => $request->contact
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Expéditeur non trouvé'
        ], 404);
    }

    public function destinatairecourriers(Request $request)
    {
        return $this->relation($request, 'courrier-destinateur-externes');
    }
    public function destinatairearchives(Request $request)
    {
        return $this->relation($request, 'destination');
    }

    public function destinatairearchivesSave(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
        ]);

        $dest = new \App\Models\Destination();
        $dest->nom = $request->nom;
        $dest->save();

        return response()->json([
            'results' => $dest,
        ]);
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

    public function getUserSignature(Request $request)
    {
        $password = $request->input('password');
        $requestCode = $request->has('request_code') || $request->has('signer');
        
        $targetUserId = Auth::id();
        if ($request->filled('agent_id')) {
            $agent = Agent::find($request->input('agent_id'));
            if ($agent && $agent->user_id) {
                $targetUserId = $agent->user_id;
            }
        }

        $image = Image::where('user_id', $targetUserId)
            ->where('type_image', 'SIGNATURE')
            ->first();

        $data = [
            'image' => '',
            'password' => null,
            'action' => 1,
            'success' => true
        ];

        // 1. Validation du mot de passe si fourni
        if ($password && $image) {
            if ($image->password !== $password) {
                return response()->json(['success' => false, 'message' => 'Mot de passe incorrect'], 403);
            }
            // Si valide, on peut continuer
        } 
        // 2. Génération d'un nouveau code si demandé (et pas de validation en cours)
        elseif ($requestCode) {
            $newPassword = Random::generate(6, '0-9');
            if ($image && $targetUserId === Auth::id()) {
                $image->password = $newPassword;
                $image->save();
            }
            $data['password'] = $newPassword;
            
            try {
                $recipient = Auth::user()->email;
                if ($recipient) {
                    Mail::to($recipient)->send(new SignaturesMail($newPassword));
                }
            } catch (\Throwable $e) {
                Log::error("Erreur lors de l'envoi de l'email de signature: " . $e->getMessage());
            }
        }

        if ($image) {
            $data['image'] = image($image->image_url);
            // Pour la compatibilité avec le JS actuel qui attend 'password' dans la réponse pour comparer localement
            if (!$data['password']) {
                $data['password'] = $image->password;
            }
        }

        // Toujours retourner les métadonnées de l'agent (pour l'encadrement)
        $user = ($targetUserId === Auth::id()) ? Auth::user() : \App\Models\User::find($targetUserId);
        $agent = $user?->agent;
        $data['agent_nom'] = $agent?->nom ?? '';
        $data['agent_prenom'] = $agent?->prenom ?? '';
        $data['direction_titre'] = $agent?->direction?->titre ?? '';

        return response()->json($data);
    }

    public function checkUserSignaturePassWord(Request $request)
    {
        $password = null;
        if ($request->has('request_code') || $request->has('signer')) {
            $password = Random::generate(6,'0-9');
            try {
                $recipient = Auth::user()->email;
                if ($recipient) {
                    Mail::to($recipient)->send(new SignaturesMail($password));
                }
            } catch (\Throwable $e) {
                Log::error("Erreur lors de l'envoi de l'email de signature (checkUserSignaturePassWord): " . $e->getMessage());
            }
        }

        $data = [];
        $image = Image::select('image_url','password')->where('user_id', Auth::id())->where('type_image', 'SIGNATURE')->first();
        
        $data['image'] = '';
        // Mail::to("contact@newtech-rdc.net")->send(new SignaturesMail($password)); 

        if ($image && $password) {
            // $details = ['email' => 'makombo.mwinaminayi@regideso.cd', 'password' => $password];

            //SendEmail::dispatch(Auth::user()->email, new SignaturesMail($password));
            // SendEmail::dispatch("contact@newtech-rdc.net", new SignaturesMail($password)); 
            //Mail::to("contact@newtech-rdc.net")->send(new EnvoiMailSigne($password));

            $image->password = $password;
            $image->save();

            $data['image'] = image($image->image_url); //$image; 
        } elseif ($image) {
            $data['image'] = image($image->image_url);
        }

        $data['password'] = $password;
        $data['action'] = 1;

        return response()->json($data);
    }

    public function getUserParaphe(Request $request)
    {
        $password = null;

        // Envoi de l'email seulement si demandé
        if ($request->has('request_code') || $request->has('signer')) {
            $password = Random::generate(6,'0-9');
            try {
                $recipient = Auth::user()->email;
                if ($recipient) {
                    Mail::to($recipient)->send(new SignaturesMail($password));
                }
            } catch (\Throwable $e) {
                // On ne bloque pas le flux en cas d'erreur d'envoi d'email
                Log::error("Erreur lors de l'envoi de l'email de signature: " . $e->getMessage());
            }
        }

        $data = [];
        $image = Image::select('image_url','password')
            ->where('user_id', Auth::id())
            ->where('type_image', 'INITIALES')
            ->first();
       
        $data['image'] = '';
        
        if ($image) {
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

        // Déterminer l'utilisateur cible: par défaut l'utilisateur courant, sinon l'agent indiqué (si valide)
        $targetUserId = Auth::id();
        if ($request->filled('agent_id')) {
            $agent = Agent::find($request->input('agent_id'));
            if ($agent && $agent->user_id) {
                $targetUserId = $agent->user_id;
            }
        }

        Image::updateOrCreate(
            [
                "type_image" => "SIGNATURE",
                "user_id" => $targetUserId,
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
            "description" => Auth::user()->name.' a validé ce document.',
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
            "description" => Auth::user()->name.' a rejeté ce document.',
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
        // dd($request);
        // $routeName = explode('.', $request->route()->getName())[1];
        // $slug = $routeName == 'clients' ? 'customers' : $routeName;

        //$slug = $this->getSlug($request);
        $page = $request->input('page');
        $on_page = 50;
        $search = $request->input('search', false);

        $method = $request->input('method', 'add');

        $model = app('\App\Models\\' . Str::ucfirst(Str::camel(Str::singular($slug))));

        if ($method != 'add') {
            $model = $model->find($request->input('id'));
        }

        $model = app('\App\Models\\' . Str::ucfirst(Str::camel(Str::singular($request->input('model')))));
        $skip = $on_page * ($page - 1);

        $additional_attributes = $model->additional_attributes ?? [];

        // If search query, use LIKE to filter results depending on field label
        if ($search) {
            if ($slug == 'courrier-expediteur') {
                $query = $model->where($request->input('label'), 'LIKE', '%' . $search . '%');
        
                // On filtre par catégorie seulement si 'relative_id' est fourni
                if ($request->filled('relative_id')) {
                    $query = $query->where('category_id', $request->input('relative_id'));
                }
        
                $total_count = $query->count();
        
                $relationshipOptions = $query->take($on_page)->skip($skip)->get();
        
            } else {
                $total_count = $model->where($request->input('label'), 'LIKE', '%' . $search . '%')->count();
        
                $relationshipOptions = $model->take($on_page)->skip($skip)
                    ->where($request->input('label'), 'LIKE', '%' . $search . '%')
                    ->get();
            }
        } else {
            if ($slug == 'courrier-expediteur') {
                $query = $model;
        
                // Même logique : filtre sur category_id uniquement si 'relative_id' est fourni
                if ($request->filled('relative_id')) {
                    $query = $query->where('category_id', $request->input('relative_id'));
                }
        
                $total_count = $query->count();
                $relationshipOptions = $query->take($on_page)->skip($skip)->get();
        
            } else {
                $total_count = $model->count();
                $relationshipOptions = $model->take($on_page)->skip($skip)->get();
            }
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
