<?php

namespace App\Http\Livewire\Admin\Agents;

use App\Http\Controllers\Image;
use App\Models\Agent;
use App\Models\Classeur;
use App\Models\Direction;
use App\Models\Document;
use App\Models\Dossier;
use App\Models\Fonction;
use App\Models\Grade;
use App\Models\LieuAffectation;
use App\Models\Module;
use App\Models\Service;
use App\Models\Secretariat;
use App\Models\Assistanat;
use App\Models\Adresse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use App\Jobs\SendEmail;
use App\Mail\AgentsPasswordMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use \App\Helpers\Helpers;
use App\Models\Historique;

class Fiche extends Component
{
    use WithPagination;
    use WithFileUploads;


    public $historiquesPage = 1; // Propriété pour gérer la pagination des activités

    public $archivedAgents;
    public $agent;
    public $email;
    public $search;
    public $statut;
    public $statuts;
    public $isSearching = false;
    public $tab = 1;
    public $directions = [];
    public $lieus = [];
    public $services = [];
    public $fonctions = [];
    public $grades = [];
    public $permissions = [];
    public $lieu_id;
    public $direction_id;
    public $service_id;
    public $fonction_id;
    public $role;
    public $photo;
    public $selected_modules = [];
    public $isReadyOnly = [
        'service' => false,
        'fonction' => false,
        'direction' => false,
    ];

    public $form_stat = [
        'nom' => '',
        'post_nom' => '',
        'prenom' => '',
        'sexe' => '',
        'matricule' => '',
        'lieu_id' => '',
        'direction_id' => '',
        'service_id' => '',
        'fonction_id' => '',
        'grade_id' => '',
        'image' => '',
    ];

    protected $listeners = [
        'changeLieu',
        'changeDirection',
        'changeService',
        'changeGrade',
        'toggelPermission',
        'updateHistoriquesPage',
    ];

    public function updateHistoriquesPage($page)
    {
        $this->historiquesPage = $page;
    }

    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        // 'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];


    public function mount()
    {
        // $this->actifAgents = Agent::actif()->orderBy('nom');
        // $this->inactifAgents = Agent::inactif()->orderBy('nom')->limit(5)->get();
        // $this->archivedAgents = Agent::archived()->orderBy('nom')->limit(5)->get();
        // $this->statuts = Statut::all();

        $this->statuts = DB::table('statuts')->select('id', 'libelle')->get();
    }

    public function hydrate()
    {
        $this->emit('select2');
    }

    public function showUser($id)
    {
        $this->agent = Agent::where('id', $id)->first();
        $this->email = $this->agent->user->email;
        $this->statut = $this->agent->statut_id;
        $this->role = isset($this->agent->user->getRoleNames()[0]) ? $this->agent->user->getRoleNames()[0] : null;
        $this->permissions = $this->agent->user->getPermissionNames()->toArray() ?? [];

        $this->form_stat = [
            'nom' => $this->agent->nom,
            'post_nom' => $this->agent->post_nom,
            'prenom' => $this->agent->prenom,
            'sexe' => $this->agent->sexe,
            'matricule' => $this->agent->matricule,
            'lieu_id' => $this->agent->lieu_id,
            'direction_id' => $this->agent->direction_id,
            'service_id' => $this->agent->service_id,
            'fonction_id' => $this->agent->fonction_id,
            'grade_id' => $this->agent->grade_id,
            'image' => '',
        ];

        $this->lieus = LieuAffectation::select('id', 'titre')->get();
        if ($this->form_stat['direction_id']) {
            $this->fonctions = Fonction::where('direction_id', $this->form_stat['direction_id'])->orderBy('titre')->get();
        } elseif ($this->form_stat['service_id']) {
            $this->fonctions = Fonction::where('service_id', $this->form_stat['service_id'])->orderBy('titre')->get();
        }
        $this->directions = Direction::select('id', 'titre')->where('lieu_id', $this->form_stat['lieu_id'])->orderBy('titre')->get();
        $this->services = Service::select('id', 'titre')->where('direction_id', $this->form_stat['direction_id'])->get();
        $this->grades = Grade::select('id', 'titre')->get();

        // Réinitialiser la pagination
        $this->resetPage('historiquesPage');
    }
    public function changeLieu($id)
    {
        $this->form_stat['direction_id'] = "";
        $this->form_stat['lieu_id'] = $id;
        $this->directions = Direction::select('id', 'titre')->where('lieu_id', $this->form_stat['lieu_id'])->orderBy('titre')->get();
    }

    public function changeDirection($id)
    {
        $this->form_stat['direction_id'] = $id;
        if ($id != 0) {
            $this->services = Service::select('id', 'titre')->where('direction_id', $this->form_stat['direction_id'])->get();
            $this->fonctions = Fonction::where('direction_id', $this->form_stat['direction_id'])->orderBy('titre')->get();
        }
    }


    public function changeService($id)
    {
        $this->form_stat['service_id'] = $id;
        if ($id != 0) {
            // Pas de sections si on utilise seulement services
            $this->fonctions = Fonction::where('service_id', $this->form_stat['service_id'])->orderBy('titre')->get();
        }
    }


    public function changeGrade($id)
    {
        $this->form_stat['grade_id'] = $id;
    }

    public function saveFonction($titre)
    {
        // dd($titre);
        $fonction = Fonction::firstOrCreate([
            'titre' => $titre,
        ], [
            'service_id' => $this->form_stat['service_id'],
            'direction_id' => $this->form_stat['direction_id'],
        ]);

        $this->form_stat['fonction_id'] = $fonction->id;

        if ($this->form_stat['direction_id']) {
            $this->fonctions = Fonction::where('direction_id', $this->form_stat['direction_id'])->orderBy('titre')->get();
        } elseif ($this->form_stat['service_id']) {
            $this->fonctions = Fonction::where('service_id', $this->form_stat['service_id'])->orderBy('titre')->get();
        }
    }

    public function changeTab($tab)
    {

        if ($this->tab !== $tab) {
            $this->resetPage();
            $this->tab = $tab;
            // $this->emit('tabChange');
        }
    }

    public function updatedSearch()
    {
        $this->isSearching = true;
        
        // Réinitialiser la pagination lors d'une nouvelle recherche
        $this->resetPage();
        
        // Simuler un délai pour montrer l'indicateur de chargement
        usleep(300000); // 300ms de délai
        
        $this->isSearching = false;
    }

    public function searchFilter($query)
    {
        if ($this->search) {
            return $query->where('nom', 'LIKE', '%' . $this->search . '%')
                ->orWhere('prenom', 'LIKE', '%' . $this->search . '%')
                ->orWhere('post_nom', 'LIKE', '%' . $this->search . '%');
        }

        return $query;
    }


    public function render()
    {
        $queryAgents = Agent::query();

        // Initialisation des variables avec des requêtes Eloquent vides
        $actifAgents = $queryAgents;
        $inactifAgents = $queryAgents;

        switch ($this->tab) {
            case 1:
                $actifAgents = $this->searchFilter($queryAgents)->actif();
                break;
            case 2:
                $inactifAgents = $this->searchFilter($queryAgents)->inactif();
                break;
        }

        // Récupération des activités avec pagination
        $historiques = $this->agent
            ? Historique::where('user_id', $this->agent->user->id)
                ->orderByDesc('id')
                ->paginate(20, ['*'], 'historiquesPage', $this->historiquesPage)
            : collect();

        return view('livewire.admin.agents.fiche')->with([
            'actifAgents' => $actifAgents->orderBy('nom')->simplePaginate(25),
            'inactifAgents' => $inactifAgents->orderBy('nom')->simplePaginate(25),
            'historiques' => $historiques,
        ]);
    }

    public function updatedDirectionId()
    {
        if ($this->direction_id != null && $this->direction_id != '') {
            # code...
            $this->isReadyOnly['service'] = false;
            // Pas de divisions
            $this->fonctions = Direction::findOrFail($this->direction_id)->fonctions ?? collect();
        }
    }



    public function updatedServiceId()
    {
        // Pas de sections
        // if ($this->service_id != null && $this->service_id != '') {
        //     $this->sections = Service::findOrFail($this->service_id)->sections ?? collect();
        // }
    }

    public function generateRandomPassword($length = 8)
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()-_=+';
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString = $characters[random_int(0, strlen($characters) - 1)];
        }

        return $randomString;
    }

    public function regeneratePassword()
    {
        $this->validate([
            'email' => 'required|email',
        ]);

        $password = Str::random(9); //$this->generateRandomPassword();

        $user = $this->agent->user;
        $user->password = Hash::make($password);
        $user->first_use = 1;
        $user->save();

        SendEmail::dispatch($user->email, new AgentsPasswordMail($password));

        $this->emit('alert', 'success', "Mot de passe de l'agent " . $this->agent->prenom . " " . $this->agent->nom . "a été regénéré avec succès");
    }

    public function archiveAgent($id)
    {
        $agent = Agent::findOrFail($id);
        $classer = Classeur::where('direction_id', Auth::user()->agent?->direction_id)->where('reference', Auth::user()->agent?->direction?->code)->first();
        if ($classer == null) {
            # code...
            $classer = Classeur::firstOrCreate(
                [
                    'direction_id' => $agent?->direction_id,
                    'titre' => 'Classeur Agents Archivés',
                ],
                [
                    'reference' => Auth::user()->agent?->direction?->code,
                    'description' => 'Classeur pour les documents des agents archivés',
                    'created_by' => $agent->id,
                    'updated_by' => $agent->id,
                ]
            );
        }
        $dossier = Dossier::where('reference', 'DAA/' . $agent?->matricule,)->first();
        if ($dossier == null) {
            # code...
            $dossier = Dossier::firstOrCreate(
                [
                    'classeur_id' => $classer->id,
                    'titre' => $agent?->prenom . ' ' . $agent?->nom,
                ],
                [
                    'reference' => 'DAA/' . $agent?->matricule,
                    'description' => 'Dossier pour les documents tache des des agents archivés',
                    'confidentiel' => 0,
                    'created_by' => $agent->id,
                    'updated_by' => $agent->id,
                ]
            );
        }
        $document = Document::create([
            'dossier_id' => $dossier->id,
            'libelle' => $agent->nom . '.' . $agent->prenom . '.' . $agent->matricule,
            'category_id' => 6,
            'reference' => 'DAA/' . $agent?->matricule,
            'type' => 3,
            'document' => 'test',
            'user_id' => Auth::id(),
            'statut_id' => 6,
            'created_by' => $agent->id,
        ]);

        $url = json_encode([
            'url' => 'regidoc.rh.agent.archived',
            'agent' => $agent->id,
            'doc' => $document->id,
        ]);
        $document->update([
            'document' => $url,
        ]);
        $agent->update([
            'statut_id' => '3',
        ]);

        $this->emit('alert', 'success', "Agent " . $this->agent->prenom . " " . $this->agent->nom . " archivé");
        $this->reset();
    }

    public function switchStatut()
    {
        $this->statut = $this->statut == 1 ? 2 : 1;
        $agent = Agent::findOrFail($this->agent->id);
        $agent->update(['statut_id' => $this->statut]);
        $this->mount();
        $this->showUser($agent->id);
        $this->emit('alert', 'success', "Le statut de l'agent " . $this->agent->prenom . " " . $this->agent->nom . " a été changé avec succès");
    }

    public function changeRole()
    {
        $this->agent->user->assignRole($this->role);
        if ((is_countable($this->role) && (count($this->role) && $this->role[0] === 'Admin')) || (!is_countable($this->role) && $this->role === 'Admin')) {
            $permissions = Permission::get();
            $this->agent->user->syncPermissions($permissions);

            foreach ($permissions as $permission) {
                array_push($this->permissions, $permission->name);
            }
        }
        $this->emit('alert', 'success', 'Paramètres mis à jour avec succès');
    }

    public function changePermission()
    {
        // dd($this->selected_modules);
        if (count($this->selected_modules)) {
            foreach ($this->selected_modules as $module_id) {
                $module = Module::find($module_id);
                foreach ($module->permissions as $permission) {
                    if (!in_array($permission->name, $this->permissions)) {
                        array_push($this->permissions, $permission->name);
                    }
                }
            }
        }
        $permissions = Permission::whereIn('name', $this->permissions)->get();
        $this->agent->user->syncPermissions($permissions);
        $this->emit('alert', 'success', 'Paramètres mis à jour avec succès');
    }

    public function toggelPermission()
    {
        $permissions = $this->permissions;
        foreach ($this->selected_modules as $modKey => $module_id) {
            $module = Module::find($module_id);
            foreach ($module->permissions as $key => $permission) {

                if (!in_array($permission->name, $permissions)) {
                    array_push($permissions, $permission->name);
                } elseif (in_array($permission->name, $permissions)) {
                    unset($permissions[$key]);
                }
            }
        }
        $this->permissions = $permissions;
        sleep(1);
    }

    public function selectPermission($value)
    {
        array_push($this->permissions, $value);
    }

    public function updateAgent()
    {
        try {
            // $data = collect($this->form_stat);

            $request = Validator::make(
                [
                    "nom" => $this->form_stat['nom'],
                    "post_nom" => $this->form_stat['post_nom'],
                    "prenom" => $this->form_stat['prenom'],
                    "sexe" => $this->form_stat['sexe'],
                    "matricule" => $this->form_stat['matricule'],
                    "lieu_id" => $this->form_stat['lieu_id'],
                    "direction_id" => $this->form_stat['direction_id'],
                    "service_id" => $this->form_stat['service_id'],
                    "fonction_id" => $this->form_stat['fonction_id'],
                    "grade_id" => $this->form_stat['grade_id'],
                    "photo" => $this->photo
                ],
                [
                    'nom' => 'required|string|max:255',
                    'post_nom' => 'string|max:255',
                    'prenom' => 'string|max:255',
                    'sexe' => 'required|string|max:1',
                    'matricule' => 'required|string|unique:agents,matricule,' . $this->agent->id . '|max:25',
                    'lieu_id' => 'required|exists:lieu_affectations,id',
                    'direction_id' => 'required|exists:directions,id',
                    'service_id' => 'required',
                    'fonction_id' => 'nullable|exists:fonctions,id',
                    'grade_id' => 'required',
                    'photo' => 'image|max:1024|mimes:jpeg,jpg,png|nullable',
                ],
                [
                    'required' => 'Le champ :attribute est obligatoire',
                    'matricule.unique' => 'Le matricule et déjà utilisé pour un autre agent',
                    'matricule.max' => 'Le matricule doit avoir 25 caractères',
                    'photo.max' => 'La taille maximale de l\'image est 1MB',
                    'photo.image' => 'Le fichier doit etre une image',
                ],
            )->validate();

            $request = json_decode(json_encode($request));
            //dd($request->photo !== null ?  $this->photo->storeAs($path, $filename,'public') : $this->agent->image);

            $this->agent->user->update([
                'name' => $request->prenom . ' ' . $request->nom,
            ]);

            $image = null;
            if ($this->photo) {
                $path = 'agents' . DIRECTORY_SEPARATOR . date('FY') . DIRECTORY_SEPARATOR;
                $filename = $this->generateFileName($this->photo, $path);
                $image = $this->photo->storeAs($path, $filename, 'public');
            } else {
                $image = $this->agent->image;
            }

            $this->agent->nom = Str::ucfirst(Str::lower($request->nom));
            $this->agent->post_nom = Str::ucfirst(Str::lower($request->post_nom));
            $this->agent->prenom = Str::ucfirst(Str::lower($request->prenom));
            $this->agent->sexe = $request->sexe;
            $this->agent->image = $image;
            $this->agent->slug = Str::slug($request->nom . ' ' . $request->post_nom . ' ' . $request->prenom);
            $this->agent->matricule = $request->matricule;
            $this->agent->direction_id = $request->direction_id ?? null;
            $this->agent->service_id = $request->service_id ?? null; // Correction de 'sevice_id' à 'service_id'
            // $this->agent->section_id = $request->section_id ?? null; // Supprimé
            $this->agent->grade_id = $request->grade_id ?? null;
            $this->agent->lieu_id = $request->lieu_id ?? null;
            $this->agent->updated_by = Auth::user()->id;

            if ($request->fonction_id != null) {
                $fct = Fonction::find($request->fonction_id);
                $titre = $fct->titre;
                if (Str::startsWith($titre, 'Directeur')) {
                    $dir = Direction::find($request->direction_id);
                    $dir->responsable_id = $this->agent->id;
                    $dir->save();
                } // Suppression des conditions pour 'Chef Division' et 'Chef Section'
                elseif (Str::startsWith($titre, 'Chef Service')) {
                    $ser = Service::find($request->service_id);
                    if ($ser) {
                        $ser->responsable_id = $this->agent->id;
                        $ser->save();
                    }
                } // Suppression des conditions pour 'Secrétaire Division' et 'Secrétaire Section'
                elseif (Str::startsWith($titre, 'Secrétaire Direction') || Str::startsWith($titre, 'Secretaire Direction')) {
                    $direction = Direction::find($request->direction_id);
                    if ($direction) {
                        Secretariat::firstOrCreate([
                            'titre' => 'Secrétaire ' . $direction->titre,
                        ], [
                            'direction_id' => $direction->id,
                            'responsable_id' => $this->agent->id,
                        ]);
                    }
                } elseif (Str::startsWith($titre, 'Secrétaire Service') || Str::startsWith($titre, 'Secretaire Service')) {
                    $service = Service::find($request->service_id);
                    if ($service) {
                        Secretariat::firstOrCreate([
                            'titre' => 'Secrétaire ' . $service->titre,
                        ], [
                            'service_id' => $service->id,
                            'responsable_id' => $this->agent->id,
                        ]);
                    }
                } elseif (Str::startsWith($titre, 'Secrétaire') || Str::startsWith($titre, 'Secretaire')) {
                    Secretariat::firstOrCreate([
                        'titre' => $titre,
                    ], [
                        'direction_id' => $request->direction_id,
                        'responsable_id' => $this->agent->id,
                    ]);
                } elseif (Str::startsWith($titre, 'Assistant')) {
                    Assistanat::FirstOrCreate([
                        "titre" => $titre,
                    ], [
                        "direction_id" => $request->direction_id,
                        "responsable_id" => $this->agent->id,
                    ]);
                }
                $this->agent->fonction_id = $request->fonction_id;
            }
            $this->agent->save();

            $this->emit('alert', 'success', 'La modification des informations de l\'agent a réussie avec succès !');
        } catch (\Throwable $th) {
            $this->emit('alert', 'error', 'La modification de l\'agent a échoué ! <br> ' . $th->getMessage());
        }
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