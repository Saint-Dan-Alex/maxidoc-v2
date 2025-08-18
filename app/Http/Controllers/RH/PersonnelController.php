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

        $this->authorize('Gérer le personnel');

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
            // Validation des données requises
            $request->validate([
                'nom' => 'required',
                'post_nom' => 'required',
                'prenom' => 'required',
                'matricule' => 'required|unique:agents',
                'newMail' => 'required|email|unique:users,email',
                'direction_id' => 'required|exists:directions,id',
                'fonction_id' => 'required|exists:fonctions,id',
                'sexe' => 'required',
            ]);

            // Vérification des doublons
            if (Agent::where('matricule', $request->matricule)->exists()) {
                return back()->with('error', 'Ce matricule existe déjà.');
            }

            if (User::where('email', $request->newMail)->exists()) {
                return back()->with('error', 'Cet email existe déjà.');
            }

            // Création de l'utilisateur
            // Création de l'utilisateur avec le rôle par défaut 'utilisateur'
            $user = User::create([
                'email' => $request->newMail,
                'name' => $request->prenom . ' ' . $request->nom,
                'password' => Hash::make('12345678'), // Mot de passe par défaut
                'statut_id' => 1, // Statut actif
            ]);

            // Attribution du rôle sélectionné et des permissions associées
            if ($request->has('role_id') && $role = \Spatie\Permission\Models\Role::find($request->role_id)) {
                // Attribuer le rôle à l'utilisateur
                $user->assignRole($role);
                
                // Récupérer les permissions actuelles de l'utilisateur
                $currentPermissions = $user->permissions->pluck('name')->toArray();
                
                // Récupérer les permissions associées au rôle
                $rolePermissions = $role->permissions->pluck('name')->toArray();
                
                // Combiner les permissions existantes avec celles du rôle (sans doublons)
                $allPermissions = array_unique(array_merge($currentPermissions, $rolePermissions));
                
                // Mettre à jour les permissions de l'utilisateur
                if (!empty($allPermissions)) {
                    $user->syncPermissions($allPermissions);
                }
            } else {
                // Rôle par défaut si aucun rôle n'est sélectionné
                $defaultRole = \Spatie\Permission\Models\Role::where('name', 'utilisateur')->first();
                if ($defaultRole) {
                    $user->assignRole($defaultRole);
                    
                    // Récupérer les permissions actuelles de l'utilisateur
                    $currentPermissions = $user->permissions->pluck('name')->toArray();
                    
                    // Récupérer les permissions du rôle par défaut
                    $rolePermissions = $defaultRole->permissions->pluck('name')->toArray();
                    
                    // Combiner les permissions existantes avec celles du rôle (sans doublons)
                    $allPermissions = array_unique(array_merge($currentPermissions, $rolePermissions));
                    
                    // Mettre à jour les permissions de l'utilisateur
                    if (!empty($allPermissions)) {
                        $user->syncPermissions($allPermissions);
                    }
                }
            }

            // Création de l'agent
            $agent = new Agent();
            $agent->user_id = $user->id;
            $agent->statut_id = 1;
            $agent->nom = Str::ucfirst(Str::lower($request->nom));
            $agent->post_nom = Str::ucfirst(Str::lower($request->post_nom));
            $agent->prenom = Str::ucfirst(Str::lower($request->prenom));
            $agent->sexe = $request->sexe;
            $agent->lieu_naiss = $request->lieu_naiss ?? null;
            $agent->date_naiss = $request->date_naiss ? Carbon::parse($request->date_naiss) : null;
            $agent->etat_civil = $request->etat_civil ?? null;
            $agent->nbr_enfant = $request->nbr_enfants ?? null;
            $agent->nationalite = $request->nationalite ?? null;
            $agent->province = $request->province ?? null;
            $agent->ville = $request->ville ?? null;
            $agent->matricule = $request->matricule;
            $agent->image = (new Image())->handle($request, 'image', 'agents');
            $agent->slug = Str::slug($request->nom . ' ' . $request->post_nom . ' ' . $request->prenom);
            
            // Assignation simplifiée des relations
            $agent->direction_id = $request->direction_id;
            $agent->fonction_id = $request->fonction_id;
            
            // Gestion des autres relations optionnelles
            $agent->division_id = $request->division_id ?? null;
            $agent->service_id = $request->service_id ?? null;
            $agent->section_id = $request->section_id ?? null;
            
            $agent->created_by = Auth::user()->id;
            $agent->updated_by = Auth::user()->id;
            $agent->save();

            // Création de l'adresse
            $adresse = new Adresse();
            $adresse->phone = $request->telephone;
            $adresse->email = $request->newMail;
            $adresse->residence = $request->adresse;
            $adresse->agent_id = $agent->id;
            $adresse->save();

            return redirect()->route('regidoc.personnels.index')
                           ->with('success', 'Agent créé avec succès.');

        } catch (\Throwable $th) {
            return back()->with('error', 'Erreur lors de la création: ' . $th->getMessage());
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

    /**
     * Met à jour le rôle d'un utilisateur et ses permissions associées
     *
     * @param User $user L'utilisateur à mettre à jour
     * @param int $roleId L'ID du rôle à attribuer
     * @return void
     */
    private function updateUserRole($user, $roleId)
    {
        if (!$roleId) {
            return;
        }

        $role = \Spatie\Permission\Models\Role::findOrFail($roleId);
        $currentRoles = $user->roles->pluck('id')->toArray();
        
        // Si l'utilisateur n'a pas déjà ce rôle
        if (!in_array($roleId, $currentRoles)) {
            // On retire tous les rôles existants
            $user->syncRoles([$role->name]);
            
            // On récupère les permissions du rôle
            $rolePermissions = $role->permissions->pluck('name')->toArray();
            
            // On récupère les permissions personnalisées actuelles de l'utilisateur
            $userDirectPermissions = $user->getDirectPermissions()->pluck('name')->toArray();
            
            // On combine les permissions du rôle avec les permissions personnalisées
            $allPermissions = array_unique(array_merge($rolePermissions, $userDirectPermissions));
            
            // On met à jour les permissions de l'utilisateur
            if (!empty($allPermissions)) {
                $user->syncPermissions($allPermissions);
            }
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // Validation des données
            $request->validate([
                'nom' => 'required',
                'post_nom' => 'required',
                'prenom' => 'required',
                'matricule' => 'required|unique:agents,matricule,' . $id,
                'direction_id' => 'required|exists:directions,id',
                'fonction_id' => 'required|exists:fonctions,id',
                'sexe' => 'required',
                'role_id' => 'nullable|exists:roles,id',
            ]);

            $agent = Agent::findOrFail($id);
            $user = $agent->user;

            // Génération de l'email
            $nomSansAccents = $this->removeAccents($request->prenom);
            $prenomSansAccents = $this->removeAccents($request->nom);
            $newMail = Str::lower($nomSansAccents) . '.' . Str::lower($prenomSansAccents) . '@lerexcompetroleum.com';

            // Vérification de l’unicité de l’email
            if (User::where('email', $newMail)->where('id', '!=', $user->id)->exists()) {
                return back()->with('error', 'Cet email est déjà utilisé par un autre utilisateur.');
            }

            // Mise à jour de l'utilisateur
            $user->update([
                'email' => $newMail,
                'name' => $request->prenom . ' ' . $request->nom,
            ]);

            // Mise à jour de l'agent
            $agent->update([
                'nom' => Str::ucfirst(Str::lower($request->nom)),
                'post_nom' => Str::ucfirst(Str::lower($request->post_nom)),
                'prenom' => Str::ucfirst(Str::lower($request->prenom)),
                'sexe' => $request->sexe,
                'lieu_naiss' => $request->lieu_naiss ?? null,
                'date_naiss' => $request->date_naiss ? Carbon::parse($request->date_naiss) : null,
                'etat_civil' => $request->etat_civil ?? null,
                'nbr_enfant' => $request->nbr_enfant ?? null,
                'nationalite' => $request->nationalite ?? null,
                'province' => $request->province ?? null,
                'ville' => $request->ville ?? null,
                'matricule' => $request->matricule,
                'image' => $request->hasFile('image') ? (new Image())->handle($request, 'image', 'agents') : $agent->image,
                'slug' => Str::slug($request->nom . ' ' . $request->post_nom . ' ' . $request->prenom),
                'direction_id' => $request->direction_id,
                'division_id' => $request->division_id ?? null,
                'service_id' => $request->service_id ?? null,
                'section_id' => $request->section_id ?? null,
                'grade_id' => $request->grade_id ?? null,
                'lieu_id' => $request->lieu_id ?? null,
                'fonction_id' => $request->fonction_id,
                'updated_by' => Auth::id(),
            ]);

            // Mise à jour de l'adresse
            $adresse = $agent->adresse ?? new Adresse();
            $adresse->fill([
                'agent_id' => $agent->id,
                'phone' => $request->telephone,
                'email' => $newMail,
                'residence' => $request->adresse,
            ])->save();

            // Mise à jour du rôle et des permissions si un rôle est spécifié
            if ($request->has('role_id')) {
                $this->updateUserRole($user, $request->role_id);
            }

            return redirect()->route('regidoc.personnels.index')->with('success', 'Agent modifié avec succès.');
        } catch (\Throwable $th) {
            return back()->with('error', 'Erreur lors de la modification : ' . $th->getMessage());
        }
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
