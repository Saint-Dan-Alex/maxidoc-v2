<?php

namespace App\Http\Controllers\RH;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Image;
use App\Models\Adresse;
use App\Models\Agent;
use App\Models\Assistanat;
use App\Models\Contrat;
use App\Models\Direction;
use App\Models\Division;
use App\Models\Document;
use App\Models\Dossier;
use App\Models\Etat;
use App\Models\Fonction;
use App\Models\Poste;
use App\Models\Role;
use App\Models\Secretariat;
use App\Models\Section;
use App\Models\Service;
use App\Models\Statut;
use App\Models\User;
use App\Models\Ville;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PersonnelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private function removeAccents($string)
    {
        $string = str_replace(
            [
                'À',
                'Á',
                'Â',
                'Ã',
                'Ä',
                'Å',
                'à',
                'á',
                'â',
                'ã',
                'ä',
                'å',
                'Ç',
                'ç',
                'Ć',
                'ć',
                'Ĉ',
                'ĉ',
                'Č',
                'č',
                'Ð',
                'ð',
                'È',
                'É',
                'Ê',
                'Ë',
                'è',
                'é',
                'ê',
                'ë',
                'Ĝ',
                'ĝ',
                'Ĥ',
                'ĥ',
                'Ì',
                'Í',
                'Î',
                'Ï',
                'ì',
                'í',
                'î',
                'ï',
                'Ĵ',
                'ĵ',
                'Ķ',
                'ķ',
                'Ĺ',
                'ĺ',
                'Ľ',
                'ľ',
                'Ñ',
                'ñ',
                'Ń',
                'ń',
                'Ň',
                'ň',
                'Ò',
                'Ó',
                'Ô',
                'Õ',
                'Ö',
                'Ø',
                'ò',
                'ó',
                'ô',
                'õ',
                'ö',
                'ø',
                'Ŕ',
                'ŕ',
                'Ř',
                'ř',
                'Ś',
                'ś',
                'Ŝ',
                'ŝ',
                'Š',
                'š',
                'Ţ',
                'ţ',
                'Ť',
                'ť',
                'Ù',
                'Ú',
                'Û',
                'Ü',
                'ù',
                'ú',
                'û',
                'ü',
                'Ŵ',
                'ŵ',
                'Ý',
                'ý',
                'ÿ',
                'Ŷ',
                'ŷ',
                'Ž',
                'ž',
            ],
            [
                'A',
                'A',
                'A',
                'A',
                'A',
                'A',
                'a',
                'a',
                'a',
                'a',
                'a',
                'a',
                'C',
                'c',
                'C',
                'c',
                'C',
                'c',
                'C',
                'c',
                'D',
                'd',
                'E',
                'E',
                'E',
                'E',
                'e',
                'e',
                'e',
                'e',
                'G',
                'g',
                'H',
                'h',
                'I',
                'I',
                'I',
                'I',
                'i',
                'i',
                'i',
                'i',
                'J',
                'j',
                'K',
                'k',
                'L',
                'l',
                'L',
                'l',
                'N',
                'n',
                'N',
                'n',
                'N',
                'n',
                'O',
                'O',
                'O',
                'O',
                'O',
                'O',
                'o',
                'o',
                'o',
                'o',
                'o',
                'o',
                'R',
                'r',
                'R',
                'r',
                'S',
                's',
                'S',
                's',
                'S',
                's',
                'T',
                't',
                'T',
                't',
                'U',
                'U',
                'U',
                'U',
                'u',
                'u',
                'u',
                'u',
                'W',
                'w',
                'Y',
                'y',
                'y',
                'Y',
                'y',
                'Z',
                'z',
            ],
            $string
        );
        $string = str_replace(' ', '', $string);
        return Str::lower($string);
    }
    public function index()
    {
        // $personnels = Agent::all();
        // $directions = Direction::select('id', 'titre')->orderby('titre', 'asc')->get();
        // $divisions = Division::select('id', 'libelle')->orderby('libelle', 'asc')->get();
        // $fonctions = Fonction::select('id', 'titre')->orderby('titre', 'asc')->get();
        // $services = Service::select('id', 'titre')->orderby('titre', 'asc')->get();
        // $dossiers = Dossier::all();

        $this->authorize('Gerer les personnels');

        return view("regidoc.pages.rh.personnels.index")->with([
            // 'directions' => $directions,
            // 'personnels' => $personnels,
            // 'divisions' => $divisions,
            // 'fonctions' => $fonctions,
            // 'dossiers' => $dossiers,
            // 'services' => $services,
            // 'plannings' => $plannings,
        ]);
    }

    public function create()
    {
        return view('regidoc.pages.rh.personnels.create');
    }

    public function generateRandomPassword($length = 8)
    {
        // $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()-_=+';
        // $randomString = '';

        // for ($i = 0; $i < $length; $i++) {
        //     $randomString .= $characters[random_int(0, strlen($characters) - 1)];
        // }

        return Str::random($length); //$randomString;
    }

    public function store(Request $request)
    {
        try {
            $nom = $request->nom;
            $postnom = $request->post_nom;
            $prenom = $request->prenom;
            $nomSansAccents = $this->removeAccents($nom);
            $prenomSansAccents = $this->removeAccents($postnom);
            $newMail = $request->newMail;
            $existingAgent = Agent::where('matricule', $request->matricule)->first();
            if ($existingAgent) {
                $content = json_encode([
                    'name' => 'Ressources humaines',
                    'statut' => 'error',
                    'message' => 'L\'ajout de l\'agent a échoué. Le matricule existe déjà.',
                ]);
                session()->flash('session', $content);
                return back();
            }

            $existingUser = User::where('email', $newMail)->first();
            if ($existingUser) {
                $content = json_encode([
                    'name' => 'Ressources humaines',
                    'statut' => 'error',
                    'message' => 'L\'ajout de l\'agent a échoué. L\'email existe déjà.',
                ]);
                session()->flash('session', $content);
                return back();
            }
            $user = null;
            $user = User::create(
                [
                    'email' => $newMail,
                    'name' => $request->prenom . ' ' . $request->nom,
                    'password' => Hash::make('12345678'),
                    // 'password' => Hash::make($password),
                    'statut_id' => 1,
                ]
            );

            $agent = new Agent();
            $agent->user_id = $user->id;
            $agent->statut_id = 1;
            $agent->nom = Str::ucfirst(Str::lower($nom));
            $agent->post_nom = Str::ucfirst(Str::lower($postnom));
            $agent->prenom = Str::ucfirst(Str::lower($prenom));
            $agent->sexe = $request->sexe;
            $agent->lieu_naiss = $request->lieu_naiss ?? null;
            $agent->date_naiss = Carbon::parse($request->date_naiss) ?? null;
            $agent->etat_civil = $request->etat_civil ?? null;
            $agent->nbr_enfant = $request->nbr_enfants ?? null;
            $agent->nationalite = $request->nationalite ?? null;
            $agent->province = $request->province ?? null;
            $agent->ville = $request->ville ?? null;
            $agent->matricule = $request->matricule;
            $agent->image = (new Image())->handle($request, 'image', 'agents');
            $agent->slug = Str::slug($nom . ' ' . $postnom . ' ' . $prenom);
            $agent->direction_id = $request->direction_id ?? null;
            $agent->division_id = $request->division_id ?? null;
            $agent->service_id = $request->sevice_id ?? null;
            $agent->section_id = $request->section_id ?? null;
            $agent->grade_id = $request->grade_id ?? null;
            $agent->lieu_id = $request->lieu_id ?? null;
            $agent->created_by = Auth::user()->id;
            $agent->updated_by = Auth::user()->id;
            $agent->save();
            $titre = '';

            if ($request->fonction_type == '1') {
                $titre = 'Directeur ' . $request->fonction;
                $dir = Direction::find($request->direction_id);
                $dir->responsable_id = $agent->id;
                $dir->save();
            }

            if ($request->fonction_type == '2') {
                $titre = 'Chef ' . $request->fonction;
                if (Str::startsWith($titre, 'Chef Division')) {
                    $div = Division::find($request->division_id);
                    if ($div) {
                        $div->responsable_id = $agent->id;
                        $div->save();
                    }
                }
                if (Str::startsWith($titre, 'Chef Service')) {
                    $ser = Service::find($request->service_id);
                    if ($ser) {
                        $ser->responsable_id = $agent->id;
                        $ser->save();
                    }
                }
                if (Str::startsWith($titre, 'Chef Section')) {
                    $sec = Section::find($request->section_id);
                    if ($sec) {
                        $sec->responsable_id = $agent->id;
                        $sec->save();
                    }
                }
            }

            if ($request->fonction_type == '3') {
                $titre = 'Secrétaire ' . $request->fonction;
                if (Str::startsWith($titre, 'Secrétaire Direction')) {
                    $direction = Direction::find($request->direction_id);
                    if ($direction) {
                        Secretariat::firstOrCreate([
                            'titre' => 'Secrétaire ' . $direction->titre,
                            'direction_id' => $direction->id,
                        ], [
                            'responsable_id' => $agent->id,
                        ]);
                    }
                }
                if (Str::startsWith($titre, 'Secrétaire Division')) {
                    $division = Division::find($request->division_id);
                    if ($division) {
                        Secretariat::firstOrCreate([
                            'titre' => 'Secrétaire ' . $division->titre,
                            'division_id' => $division->id,
                        ], [
                            'responsable_id' => $agent->id,
                        ]);
                    }
                }
            }

            if ($request->fonction_type == '4') {
                $titre = 'Assistant ' . $request->fonction;
                $fct = Fonction::firstOrCreate(
                    [
                        "titre" => $titre,
                        "direction_id" => $request->direction_id,
                    ],
                    [
                        "section_id" => $request->section_id,
                        "service_id" => $request->service_id,
                        "division_id" => $request->division_id,
                        "description" => '',
                    ]
                );
            }

            if ($request->fonction_type == '5') {
                $titre = $request->fonction;
                $fct = Fonction::firstOrCreate(
                    [
                        "titre" => $titre,
                        "direction_id" => $request->direction_id,
                    ],
                    [
                        "section_id" => $request->section_id ?? null,
                        "service_id" => $request->service_id ?? null,
                        "division_id" => $request->division_id ?? null,
                        "description" => '',
                    ]
                );
            }

            if ($request->fonction_type == '6') {
                $fct = Fonction::find($request->fonction_id);
            } else {
                # code...
                $fct = Fonction::firstOrCreate(
                    [
                        "titre" => $titre,
                    ],
                    [
                        "direction_id" => $request->direction_id,
                        "division_id" => $request->division_id,
                        "section_id" => $request->section_id,
                        "service_id" => $request->service_id,
                        "description" => '',
                    ]
                );
            }

            if ($fct) {
                $exAgent = Agent::where('lieu_id', $request->lieu_id)->where('direction_id', $request->direction_id)->where('fonction_id', $fct->id)->first();
                if ($exAgent) {
                    # code...
                    $exAgent->fonction_id = null;
                    $exAgent->save();
                }
                $agent->fonction_id = $fct->id;
                $agent->save();
            }

            $adresse = new Adresse();
            $adresse->phone = $request->telephone;
            // $adresse->phone_2 = $request->autre_telephone;
            $adresse->email = $newMail;
            $adresse->residence = $request->adresse;
            $adresse->agent_id = $agent->id;
            $adresse->save();

            $content = json_encode([
                'name' => 'Ressources humaines',
                'statut' => 'success',
                'message' => 'L\'ajout de l\'agent a réussi avec succès !',
            ]);
            session()->flash(
                'session',
                $content
            );

            return redirect()->route('regidoc.personnels.index');

        } catch (\Throwable $th) {
            // dd($th);
            $content = json_encode([
                'name' => 'Ressources humaines',
                'statut' => 'error',
                'message' => 'L\'ajout de l\'agent a échoué !',
            ]);
            session()->flash(
                'session',
                $content
            );
            return back();
        }

    }

    public function show($id)
    {
        $users = User::orderBy('id', 'asc')->get();
        $user = User::where('id', $id)->first();
        $divisions = Division::all();
        // $departements = Departement::all();
        $postes = Poste::all();
        $roles = Role::where('statut_id', '1')->get();
        $etats = Etat::all();
        $statuts = Statut::all();
        // $plannings = Planning::all();
        $villes = Ville::all();
        // $historiques = Conge::all();
        $contrats = Contrat::all();

        return view('rh.personnels', compact('users', 'divisions', 'departements', 'postes', 'user', 'etats', 'roles', 'plannings', 'villes', 'statuts', 'contrats', 'conges'));
    }

    public function update(Request $request, $id)
    {
        // dd($request);
        try {
            $nom = $request->nom;
            $prenom = $request->post_nom;
            // dd([
            //     'request' => $request,
            // ]);
            $agent = Agent::findOrFail($id);
            $user = $agent->user;

            $nomSansAccents = $this->removeAccents($nom);
            $prenomSansAccents = $this->removeAccents($prenom);

            $newMail = Str::lower($nomSansAccents) . '.' . Str::lower($prenomSansAccents) . '@regideso.cd';

            $existingUser = User::where('email', $newMail)->where('id', '!=', $user->id)->first();
            if ($existingUser) {
                $content = json_encode([
                    'name' => 'Ressources humaines',
                    'statut' => 'error',
                    'message' => 'La modification de l\'agent ' . $agent->prenom . ' ' . $agent->nom . ' a échoué. L\'email existe déjà.',
                ]);
                session()->flash('session', $content);
                return redirect()->route('regidoc.personnels.index');
            }

            // Vérifier si le matricule existe déjà dans la table agents
            $existingAgent = Agent::where('matricule', $request->matricule)->where('id', '!=', $agent->id)->first();
            if ($existingAgent) {
                $content = json_encode([
                    'name' => 'Ressources humaines',
                    'statut' => 'error',
                    'message' => 'La modification de l\'agent ' . $agent->prenom . ' ' . $agent->nom . ' a échoué. Vous avez déjà un agent avec ce matricule.',
                ]);
                session()->flash('session', $content);
                return redirect()->route('regidoc.personnels.index');
            }

            $user->update([
                'email' => $newMail,
                'name' => $request->prenom . ' ' . $request->nom,
            ]);

            $agent->nom = Str::ucfirst(Str::lower($request->nom));
            $agent->post_nom = Str::ucfirst(Str::lower($request->post_nom));
            $agent->prenom = Str::ucfirst(Str::lower($request->prenom));
            $agent->sexe = $request->sexe;
            $agent->province = $request->province ?? null;
            $agent->ville = $request->ville ?? null;
            $agent->lieu_naiss = $request->lieu_naiss ?? null;
            $agent->date_naiss = Carbon::parse($request->date_naiss) ?? null;
            $agent->etat_civil = $request->etat_civil ?? null;
            $agent->nbr_enfant = $request->nbr_enfant ?? null;
            $agent->nationalite = $request->nationalite ?? null;
            $agent->image = $request->hasFile('image') ? (new Image())->handle($request, 'image', 'agents') : $agent->image;
            $agent->slug = Str::slug($request->nom . ' ' . $request->post_nom . ' ' . $request->prenom);
            $agent->matricule = $request->matricule;
            $agent->direction_id = $request->direction_id ?? null;
            $agent->division_id = $request->division_id ?? null;
            $agent->service_id = $request->sevice_id ?? null;
            $agent->section_id = $request->section_id ?? null;
            $agent->grade_id = $request->grade_id ?? null;
            $agent->lieu_id = $request->lieu_id ?? null;
            $agent->updated_by = Auth::user()->id;
            if ($request->fonction_id != null) {
                $fct = Fonction::find($request->fonction_id);
                $titre = $fct->titre;
                if (Str::startsWith($titre, 'Directeur')) {
                    $dir = Direction::find($request->direction_id);
                    $dir->responsable_id = $agent->id;
                    $dir->save();
                } elseif (Str::startsWith($titre, 'Chef Division')) {
                    $div = Division::find($request->division_id);
                    if ($div) {
                        $div->responsable_id = $agent->id;
                        $div->save();
                    }
                } elseif (Str::startsWith($titre, 'Chef Service')) {
                    $ser = Service::find($request->service_id);
                    if ($ser) {
                        $ser->responsable_id = $agent->id;
                        $ser->save();
                    }
                } elseif (Str::startsWith($titre, 'Chef Section')) {
                    $sec = Section::find($request->section_id);
                    if ($sec) {
                        $sec->responsable_id = $agent->id;
                        $sec->save();
                    }
                } elseif (Str::startsWith($titre, 'Secrétaire Direction') || Str::startsWith($titre, 'Secretaire Direction')) {
                    $direction = Direction::find($request->direction_id);
                    if ($direction) {
                        Secretariat::firstOrCreate([
                            'titre' => 'Secrétaire ' . $direction->titre,
                        ], [
                            'direction_id' => $direction->id,
                            'responsable_id' => $agent->id,
                        ]);
                    }
                } elseif (Str::startsWith($titre, 'Secrétaire Division') || Str::startsWith($titre, 'Secretaire Division')) {
                    $division = Division::find($request->division_id);
                    if ($division) {
                        Secretariat::firstOrCreate([
                            'titre' => 'Secrétaire ' . $division->libelle,
                        ], [
                            'division_id' => $division->id,
                            'responsable_id' => $agent->id,
                        ]);
                    }
                } elseif (Str::startsWith($titre, 'Secrétaire Service') || Str::startsWith($titre, 'Secretaire Service')) {
                    $service = Service::find($request->service_id);
                    if ($service) {
                        Secretariat::firstOrCreate([
                            'titre' => 'Secrétaire ' . $service->titre,
                        ], [
                            'service_id' => $service->id,
                            'responsable_id' => $agent->id,
                        ]);
                    }
                } elseif (Str::startsWith($titre, 'Secrétaire') || Str::startsWith($titre, 'Secretaire')) {
                    Secretariat::firstOrCreate([
                        'titre' => $titre,
                    ], [
                        'direction_id' => $request->direction_id,
                        'responsable_id' => $agent->id,
                    ]);
                } elseif (Str::startsWith($titre, 'Assistant')) {
                    Assistanat::FirstOrCreate([
                        "titre" => $titre,
                    ], [
                        "direction_id" => $request->direction_id,
                        "responsable_id" => $agent->id,
                    ]);
                }
                $agent->fonction_id = $request->fonction_id;
            }
            $agent->save();

            $adresse = $agent->adresse ?? new Adresse();
            $adresse->agent_id = $agent->id;
            $adresse->phone = $request->telephone;
            $adresse->residence = $request->adresse;
            $adresse->save();

            $content = json_encode([
                'name' => 'Ressources humaines',
                'statut' => 'success',
                'message' => 'La modification des informations de l\'agent a réussie avec succès !',
            ]);
        } catch (\Throwable $th) {
            // dd($th);
            $content = json_encode([
                'name' => 'Ressources humaines',
                'statut' => 'error',
                'message' => 'La modification de l\'agent a échoué !',
            ]);
        }

        session()->flash(
            'session',
            $content
        );

        return back();
    }

    public function archived(Request $request, $agent, $doc)
    {
        $agent = Agent::findOrFail($agent);
        $doc = Document::findOrFail($doc);
        if ($agent->statut_id != 3) {
            $content = json_encode([
                'name' => 'Ressources humaines',
                'statut' => 'error',
                'message' => "Cet agentn n'est pas archivé",
            ]);
            session()->flash(
                'session',
                $content
            );
            return back();
        }
        return view('regidoc.pages.archives.agent-archived', compact('agent', 'doc'));
    }

    public function desarchived($agent, $doc)
    {
        $agent = Agent::findOrfail($agent);
        $doc = Document::findOrFail($doc);
        $dossier = $doc->dossier;
        $dossier->delete();
        $doc->delete();
        $agent->update([
            'statut_id' => 1,
        ]);

        $content = json_encode([
            'name' => 'Ressources humaines',
            'statut' => 'success',
            'message' => "Cet agent n'est plus archivé",
        ]);
        session()->flash(
            'session',
            $content
        );
        return redirect()->route('regidoc.personnels.index');
    }

    public function updateperso(Request $request)
    {
        try {
            $agent = Agent::where('id', Auth::user()->agent->id)->update([
                'nom' => $request->nom,
                'post_nom' => $request->postnom,
                'prenom' => $request->prenom,
                'sexe' => $request->sexe,
                'etat_civil' => $request->etatcivil,
                'nbr_enfant' => $request->enfants,
                'lieu_naiss' => $request->lieunaissance,
                'date_naiss' => $request->datenaissance,
                'nationalite' => $request->nationalite,
                'updated_by' => Auth::user()->id,
            ]);

            $adresse = Adresse::firstOrCreate([
                'agent_id' => Auth::user()->agent->id,
            ], [
                'phone' => $request->telephone,
                'email' => Str::lower($request->email),
                'residence' => $request->adresse,
            ]);

            // $adresse = Adresse::where('agent_id', Auth::user()->agent->id)->first();
            // $adresse->phone = $request->telephone;
            // // $adresse->phone_2 = $request->autre_telephone;
            // $adresse->email = Str::lower($request->email);
            // $adresse->residence = $request->adresse;
            // // $adresse->agent_id = Auth::user()->agent->id;
            // $adresse->save();
            $content = json_encode([
                'name' => 'Ressources humaines',
                'statut' => 'success',
                'message' => 'La modification de vos informations a réussie avec succès !',
            ]);
        } catch (\Throwable $th) {
            $content = json_encode([
                'name' => 'Ressources humaines',
                'statut' => 'error',
                'message' => 'La modification de vos informations a échouée !',
            ]);
        }

        session()->flash(
            'session',
            $content
        );

        return back();
    }

    public function updateAuth(Request $request)
    {
        try {
            if ($request->has('password') && $request->password) {
                if ($request->has('user_id') && $request->user_id != null) {

                    if ($request->password == $request->password_confirm) {
                        $user = User::find($request->user_id)->update([
                            'email' => $request->email,
                            'password' => Hash::make($request->password),
                            'statut_id' => $request->statut_id,
                        ]);

                        if ($user == 1) {
                            $content = json_encode([
                                'name' => 'Ressources humaines',
                                'statut' => 'success',
                                'message' => 'La modification de votre mot de passe a réussie avec succès !',
                            ]);
                        } else {
                            $content = json_encode([
                                'name' => 'Ressources humaines',
                                'statut' => 'error',
                                'message' => 'La modification de votre mot de passe a échouée !',
                            ]);
                        }
                    } else {
                        $content = json_encode([
                            'name' => 'Nouveau Mot de passe incorrect',
                            'statut' => 'error',
                            'message' => 'Votre nouveau mot de passe n\'est pas identique à sa confirmation !',
                        ]);
                    }
                } else {
                    if ($request->password == $request->password_confirm) {
                        $agent = Agent::find($request->agent_id);
                        $user = User::create([
                            'nom' => $agent->prenom . ' ' . $agent->nom,
                            'email' => $request->email,
                            'password' => Hash::make($request->password),
                            'statut_id' => $request->statut_id,
                            'role_id' => 2,
                        ]);

                        $agent->user_id = $user->id;
                        $agent->save();

                        $content = json_encode([
                            'name' => 'Ressources humaines',
                            'statut' => 'success',
                            'message' => 'L\'enregistrement de votre mot de passe a réussie avec succès !',
                        ]);

                    } else {
                        $content = json_encode([
                            'name' => 'Nouveau Mot de passe incorrect',
                            'statut' => 'error',
                            'message' => 'Votre nouveau mot de passe n\'est pas identique à sa confirmation !',
                        ]);
                    }
                }
            } else {

                $user = User::find($request->user_id);
                $user->email = $request->email;
                $user->statut_id = $request->statut_id;

                // dd($user->save());

                if ($user->save()) {
                    $content = json_encode([
                        'name' => 'Ressources humaines',
                        'statut' => 'success',
                        'message' => 'La modification de votre mot de passe a réussie avec succès !',
                    ]);
                } else {
                    $content = json_encode([
                        'name' => 'Ressources humaines',
                        'statut' => 'error',
                        'message' => 'La modification de votre mot de passe a échouée !',
                    ]);
                }
            }
        } catch (\Throwable $th) {
            $content = json_encode([
                'name' => 'Ressources humaines',
                'statut' => 'error',
                'message' => 'La modification de votre mot de passe a échouée !',
            ]);
        }

        session()->flash(
            'session',
            $content
        );

        return back();
    }

    public function updatepassword(Request $request)
    {
        if ($request->password == $request->password_confirm) {
            if (Hash::check($request->password_old, Auth::user()->password) == true) {
                $user = User::where('id', Auth::user()->id)->update([
                    'password' => Hash::make($request->password),
                ]);

                if ($user == 1) {
                    $content = json_encode([
                        'name' => 'Ressources humaines',
                        'statut' => 'success',
                        'message' => 'La modification de votre mot de passe a réussie avec succès !',
                    ]);
                } else {
                    $content = json_encode([
                        'name' => 'Ressources humaines',
                        'statut' => 'error',
                        'message' => 'La modification de votre mot de passe a échouée !',
                    ]);
                }
            } else {
                $content = json_encode([
                    'name' => 'Ressources humaines',
                    'statut' => 'error',
                    'message' => 'Votre ancien mot de passe est incorrect !',
                ]);
            }
        } else {
            $content = json_encode([
                'name' => 'Nouveau Mot de passe incorrect',
                'statut' => 'error',
                'message' => 'Votre nouveau mot de passe n\'est pas identique à sa confirmation !',
            ]);
        }

        session()->flash(
            'session',
            $content
        );

        return back();
    }

    public function destroy($id)
    {
        $user = User::where('id', $id)->update([
            'id_deleted_at' => Auth::user()->id,
            'statut_id' => '4',
        ]);

        if ($user == 1) {
            $content = json_encode([
                'name' => 'Ressources humaines',
                'statut' => 'success',
                'message' => 'La suppression de l\'agent a réussie avec succès !',
            ]);
        } else {
            $content = json_encode([
                'name' => 'Ressources humaines',
                'statut' => 'error',
                'message' => 'La suppression de l\'agent a échouée !',
            ]);
        }

        session()->flash(
            'session',
            $content
        );

        return back();
    }

    public function activate(Agent $agent)
    {
        try {
            $agent->contrat->statut_id = 1;
            $agent->contrat->save();

            $agent->user->statut_id = 1;
            $agent->user->save();

            $content = json_encode([
                'name' => 'Ressources humaines',
                'statut' => 'success',
                'message' => 'Agent reactivé avec succès !',
            ]);

        } catch (\Throwable $th) {
            $content = json_encode([
                'name' => 'Ressources humaines',
                'statut' => 'error',
                'message' => 'La réactivation de l\'agent a échouée !',
            ]);
        }

        session()->flash(
            'session',
            $content
        );

        return back();
    }

    public function suspension(Agent $agent)
    {
        try {
            $agent->contrat->statut_id = 3;
            $agent->contrat->save();

            $agent->user->statut_id = 3;
            $agent->user->save();

            $content = json_encode([
                'name' => 'Ressources humaines',
                'statut' => 'success',
                'message' => 'La suspension de l\'agent a réussie avec succès !',
            ]);

        } catch (\Throwable $th) {
            $content = json_encode([
                'name' => 'Ressources humaines',
                'statut' => 'error',
                'message' => 'La suspension de l\'agent a échouée !',
            ]);
        }

        session()->flash(
            'session',
            $content
        );

        return back();
    }

    public function permissions(Request $request)
    {
        if (!$request->has('user_id') || $request->user_id == null) {
            $content = json_encode([
                'name' => 'Ressources humaines',
                'statut' => 'error',
                'message' => 'L\'enregistrement de permissions a échouée. Veillez d\'abord enregistre les information d\'authentification ci-dessus !',
            ]);
            session()->flash(
                'session',
                $content
            );
            return redirect()->back();
        }

        $user = User::find($request->user_id);
        $user->permissions()->sync($request->input('permissions', []));

        $content = json_encode([
            'name' => 'Ressources humaines',
            'statut' => 'success',
            'message' => 'L\'enregistrement de permissions a réussie avec succès !',
        ]);

        session()->flash(
            'session',
            $content
        );

        return redirect()->back();
    }
}
