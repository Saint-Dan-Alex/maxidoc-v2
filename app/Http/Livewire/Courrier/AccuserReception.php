<?php

namespace App\Http\Livewire\Courrier;

use App\Events\CourrierCreated;
use App\Models\AccuseReception;
use App\Models\Agent;
use App\Models\Historique;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Courrier;
use App\Models\CourrierTraitement;
use App\Models\CourrierTypesTraitement;
use App\Models\Direction;
use App\Models\Priorite;
use App\Models\Service;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class AccuserReception extends Component
{
    use WithFileUploads;

    public $courrier;
    public $followers;
    public $traitements;
    public $priorites;
    public $stat = [
        'date_limite' => '',
        'priorite_id' => '',
        'traitement_id' => '',
        'copie' => '',
    ];
    public $checkEcheance;
    public $commentaire;
    public $copys;
    public $mode = 'vue';
    public $document_files = [];
    public $seenBtnTraite = true;

    public function mount($courrier)
    {
        $this->courrier = $courrier;
    }

    public function render()
    {
        return view('livewire.courrier.accuser-reception');
    }

    // public function accuserReception()
    // {
    //     if ($this->courrier->type_id == 1) {

    //         $this->courrier->etapes->last()->pivot->view_by = Auth::user()->id;
    //         $this->courrier->etapes->last()->pivot->save();

    //         $courrier = Courrier::find($this->courrier->id);
    //         $courrier->statut_id = 2;
    //         $courrier->save();

    //         $agent = null;

    //         if ($this->courrier->accuseReceptions->count() == 0) {
    //             $agent = $this->courrier->author;
    //         } else {
    //             $agent = $this->courrier->accuseReceptions->last()->user->agent;
    //         }

    //         AccuseReception::create([
    //             'user_id' => Auth::user()->id,
    //             'courrier_id' => $courrier->id,
    //         ]);

    //         if ($agent) {
    //             event(new CourrierCreated($this->courrier, $agent, 'A accusé reception du courrier transmis'));
    //         }

    //         Historique::create([
    //             "key" => "Accusé de reception",
    //             "historiquecable_id" => $this->courrier->id,
    //             "historiquecable_type" => Courrier::class,
    //             "description" => "A accusé reception du courrier",
    //             "user_id" => Auth::user()->id,
    //         ]);

    //         if (Auth::user()->agent->isSecretaire() || Auth::user()->agent->isAssistant())
    //         {
    //             // is DGA's assistant or Sercretaire
    //             $dgaSecretaires = Direction::find(1)->dgaSecretaires->pluck('responsable_id')->toArray();

    //             $dgaAssistants = Direction::find(1)->dgaAssistanats->pluck('responsable_id')->toArray();
    //             if(in_array(Auth::user()->agent->id, $dgaSecretaires) || in_array(Auth::user()->agent->id, $dgaAssistants))
    //             {
    //                 $this->validerTraitementDGA();
    //             }

    //             $this->emit('assistantSeen');
    //         }

    //     } elseif ($this->courrier->type_id == 2) {

    //         if ($this->courrier->etapes->last()) {
    //             $this->courrier->etapes->last()->pivot->view_by = Auth::user()->id;
    //             $this->courrier->etapes->last()->pivot->save();
    //         }

    //         $agent = null;

    //         if ($this->courrier->accuseReceptions->count() == 0) {
    //             $agent = $this->courrier->author;
    //         } else {
    //             $agent = $this->courrier->accuseReceptions->last()->agent;
    //         }

    //         AccuseReception::create([
    //             'user_id' => Auth::user()->id,
    //             'courrier_id' => $this->courrier->id,
    //         ]);

    //         if ($agent) {
    //             event(new CourrierCreated($this->courrier, $agent, 'A accusé reception du courrier transmis'));
    //         }

    //         Historique::create([
    //             "key" => "Accusé de reception",
    //             "historiquecable_id" => $this->courrier->id,
    //             "historiquecable_type" => Courrier::class,
    //             "description" => "A accusé reception du courrier",
    //             "user_id" => Auth::user()->id,
    //         ]);

    //         if (Auth::user()->agent->isSecretaire()) {
    //             $this->validerTraitementSecretaire();
    //         } elseif (Auth::user()->agent->isAssistant()) {

    //             // I save traitement
    //             $traitement = new CourrierTraitement();
    //             $traitement->agent_id = Auth::user()->agent->id;
    //             $traitement->save();

    //             $this->courrier->traitements()->attach($traitement);

    //             // I change the stap
    //             $this->courrier->etapes()->attach(2);

    //             $this->courrier->destinateurs()->attach(Auth::user()->agent->direction->secretaire);

    //             Historique::create([
    //                 "key" => "Accusé de reception",
    //                 "historiquecable_id" => $this->courrier->id,
    //                 "historiquecable_type" => Courrier::class,
    //                 "description" => "A effectué des traitements sur ce courrier",
    //                 "user_id" => Auth::user()->id,
    //             ]);

    //             $destinateurToNotify = $this->courrier->destinateurs->where('id', '!=', Auth::user()->agent->id)->where('id', '!=', Auth::user()->agent->direction->responsable->id);

    //             if (count($destinateurToNotify)) {
    //                 event(new CourrierCreated(
    //                     $this->courrier,
    //                     $destinateurToNotify,
    //                     'Vous a transmi un courrier sortant !'
    //                 ));
    //             }

    //             $this->emit('assistantSeen');
    //         } else {
    //             $courrier = Courrier::find($this->courrier->id);
    //             $courrier->statut_id = 3;
    //             $courrier->save();
    //         }
    //     } else {
    //         $this->courrier->etapes->last()->pivot->view_by = Auth::user()->id;
    //         $this->courrier->etapes->last()->pivot->save();

    //         $courrier = Courrier::find($this->courrier->id);
    //         $courrier->statut_id = 2;
    //         $courrier->save();

    //         $agent = null;

    //         if ($this->courrier->accuseReceptions->count() == 0) {
    //             $agent = $this->courrier->author;
    //         } else {
    //             $agent = $this->courrier->accuseReceptions->last()->user->agent;
    //         }

    //         AccuseReception::create([
    //             'user_id' => Auth::user()->id,
    //             'courrier_id' => $courrier->id,
    //         ]);

    //         if ($agent) {
    //             event(new CourrierCreated($this->courrier, $agent, 'A accusé reception du courrier transmis'));
    //         }

    //         Historique::create([
    //             "key" => "Accusé de reception",
    //             "historiquecable_id" => $this->courrier->id,
    //             "historiquecable_type" => Courrier::class,
    //             "description" => "A accusé reception du courrier",
    //             "user_id" => Auth::user()->id,
    //         ]);

    //         if (Auth::user()->agent->isSecretaire() || Auth::user()->agent->isAssistant())
    //         {
    //             // is DGA's assistant or Sercretaire
    //             $dgaSecretaires = Direction::find(1)->dgaSecretaires->pluck('responsable_id')->toArray();
    //             $dgaAssistants = Direction::find(1)->dgaAssistanats->pluck('responsable_id')->toArray();

    //             if(in_array(Auth::user()->agent->id, $dgaSecretaires) || in_array(Auth::user()->agent->id, $dgaAssistants))
    //             {
    //                 $this->validerTraitementDGA();
    //             }

    //             $this->emit('assistantSeen');
    //         }
    //     }

    //     $this->emit('alert', 'success', 'Accuser de reception effectué avec succès');
    // }
    public function accuserReception()
{
    if ($this->courrier->type_id == 1) {

        $this->courrier->etapes->last()->pivot->view_by = Auth::user()->id;
        $this->courrier->etapes->last()->pivot->save();

        $courrier = Courrier::find($this->courrier->id);
        $courrier->statut_id = 2;
        $courrier->save();

        $agent = null;

        if ($this->courrier->accuseReceptions->count() == 0) {
            $agent = $this->courrier->author;
        } else {
            $agent = $this->courrier->accuseReceptions->last()->user->agent;
        }

        AccuseReception::create([
            'user_id' => Auth::user()->id,
            'courrier_id' => $courrier->id,
        ]);

        if ($agent) {
            event(new CourrierCreated($this->courrier, $agent, 'A accusé reception du courrier transmis'));
        }

        Historique::create([
            "key" => "Accusé de reception",
            "historiquecable_id" => $this->courrier->id,
            "historiquecable_type" => Courrier::class,
            "description" => "A accusé reception du courrier",
            "user_id" => Auth::user()->id,
        ]);

        if (Auth::user()->agent->isSecretaire() || Auth::user()->agent->isAssistant()) {
            $dgaSecretaires = Direction::find(1)->dgaSecretaires->pluck('responsable_id')->toArray();
            $dgaAssistants = Direction::find(1)->dgaAssistanats->pluck('responsable_id')->toArray();

            if (in_array(Auth::user()->agent->id, $dgaSecretaires) || in_array(Auth::user()->agent->id, $dgaAssistants)) {
                $this->validerTraitementDGA();
            }

            $this->emit('assistantSeen');
        }

    } elseif ($this->courrier->type_id == 2) {

    if ($this->courrier->etapes->last()) {
        $this->courrier->etapes->last()->pivot->view_by = Auth::user()->id;
        $this->courrier->etapes->last()->pivot->save();
    }

    $agent = null;

    if ($this->courrier->accuseReceptions->count() == 0) {
        $agent = $this->courrier->author;
    } else {
        $agent = $this->courrier->accuseReceptions->last()->agent;
    }

    AccuseReception::create([
        'user_id' => Auth::user()->id,
        'courrier_id' => $this->courrier->id,
    ]);

    if ($agent) {
        event(new CourrierCreated($this->courrier, $agent, 'A accusé reception du courrier transmis'));
    }

    Historique::create([
        "key" => "Accusé de reception",
        "historiquecable_id" => $this->courrier->id,
        "historiquecable_type" => Courrier::class,
        "description" => "A accusé reception du courrier",
        "user_id" => Auth::user()->id,
    ]);

    if (Auth::user()->agent->isSecretaire()) {

        // ✅ Met à jour le statut directement
        $this->courrier->statut_id = 3;
        $this->courrier->save();

        $this->validerTraitementSecretaire();

    } elseif (Auth::user()->agent->isAssistant()) {

        $traitement = new CourrierTraitement();
        $traitement->agent_id = Auth::user()->agent->id;
        $traitement->save();

        $this->courrier->traitements()->attach($traitement);
        $this->courrier->etapes()->attach(2);

        $this->courrier->destinateurs()->attach(Auth::user()->agent->direction->secretaire);

        Historique::create([
            "key" => "Accusé de reception",
            "historiquecable_id" => $this->courrier->id,
            "historiquecable_type" => Courrier::class,
            "description" => "A effectué des traitements sur ce courrier",
            "user_id" => Auth::user()->id,
        ]);

        $destinateurToNotify = $this->courrier->destinateurs
            ->where('id', '!=', Auth::user()->agent->id)
            ->where('id', '!=', Auth::user()->agent->direction->responsable->id);

        if (count($destinateurToNotify)) {
            event(new CourrierCreated(
                $this->courrier,
                $destinateurToNotify,
                'Vous a transmi un courrier sortant !'
            ));
        }

        $this->emit('assistantSeen');

    } else {
        $courrier = Courrier::find($this->courrier->id);
        $courrier->statut_id = 3;
        $courrier->save();
    }
}
else {

        $this->courrier->etapes->last()->pivot->view_by = Auth::user()->id;
        $this->courrier->etapes->last()->pivot->save();

        $courrier = Courrier::find($this->courrier->id);
        $courrier->statut_id = 2;
        $courrier->save();

        $agent = null;

        if ($this->courrier->accuseReceptions->count() == 0) {
            $agent = $this->courrier->author;
        } else {
            $agent = $this->courrier->accuseReceptions->last()->user->agent;
        }

        AccuseReception::create([
            'user_id' => Auth::user()->id,
            'courrier_id' => $courrier->id,
        ]);

        if ($agent) {
            event(new CourrierCreated($this->courrier, $agent, 'A accusé reception du courrier transmis'));
        }

        Historique::create([
            "key" => "Accusé de reception",
            "historiquecable_id" => $this->courrier->id,
            "historiquecable_type" => Courrier::class,
            "description" => "A accusé reception du courrier",
            "user_id" => Auth::user()->id,
        ]);

        if (Auth::user()->agent->isSecretaire() || Auth::user()->agent->isAssistant()) {
            $dgaSecretaires = Direction::find(1)->dgaSecretaires->pluck('responsable_id')->toArray();
            $dgaAssistants = Direction::find(1)->dgaAssistanats->pluck('responsable_id')->toArray();

            if (in_array(Auth::user()->agent->id, $dgaSecretaires) || in_array(Auth::user()->agent->id, $dgaAssistants)) {
                $this->validerTraitementDGA();
            }

            $this->emit('assistantSeen');
        }
    }

    $this->emit('alert', 'success', 'Accuser de reception effectué avec succès');
}

    public function validerTraitementDGA()
    {
        // dd(Auth::user()->agent->direction->dgAssistanats);
        $traitement = new CourrierTraitement();
        $courrier = Courrier::find($this->courrier->id);

        if (Auth::user()->agent->isAssistant() || Auth::user()->agent->isSecretaire()) {

            // // I complete same remaining courrier data
            // $courrier->priorite_id = intval($this->stat['priorite_id']) ?? 0;
            // $courrier->date_fin = !empty($this->stat['date_limite']) || $this->stat['date_limite'] != null ? $this->stat['date_limite'] : null;
            // $courrier->traitement_id = $this->stat['traitement_id'];
            // $courrier->save();

            // I save traitement
            $traitement->agent_id = Auth::user()->agent->id;
            $traitement->note = 'Accusé de reception';
            $traitement->save();

            $courrier->traitements()->attach($traitement);

            if ($courrier->type_id == 1) {

                // I save annotation
                // if ($this->commentaire) {
                //     $annotation = new CourriersAnnotation();
                //     $annotation->user_id = Auth::user()->id;
                //     $annotation->courrier_id = $courrier->id;
                //     $annotation->note = $this->commentaire;
                //     $annotation->save();
                // }

                if(Auth::user()->agent->isAssistant()){
                    // I change the stap
                    $courrier->etapes()->attach(7);

                    $direction = Direction::find(1);
                    $courrier->destinateurs()->attach($direction->adjoint);
                }

                if (Auth::user()->agent->isSecretaire()) {
                    // I change the stap
                    $courrier->etapes()->attach(6);
                    $courrier->destinateurs()->attach(Auth::user()->agent->direction->dgaAssistanats->pluck('responsable_id'));
                }

                Historique::create([
                    "key" => "Accusé de reception",
                    "historiquecable_id" => $courrier->id,
                    "historiquecable_type" => Courrier::class,
                    "description" => "A  apporté des modifications sur le traitement à effectué",
                    "user_id" => Auth::user()->id,
                ]);

                if (Auth::user()->agent->isSecretaire()) {
                    $agentsToNotify = Agent::find(Auth::user()->agent->direction->dgaAssistanats->pluck('responsable_id'));
                    if ((is_iterable($agentsToNotify) && count($agentsToNotify)) || $agentsToNotify) {
                        event(new CourrierCreated($courrier, $agentsToNotify, 'Vous a transmis un nouveau courrier !'));
                    }
                } elseif (Auth::user()->agent->isAssistant()) {
                    if (Auth::user()->agent->direction->adjoint) {
                        event(new CourrierCreated($courrier, Auth::user()->agent->direction->adjoint, 'Vous a transmis un nouveau courrier !'));
                    }
                }

            }
        }

        // $this->mode = 'view';
        // $this->seenBtnTraite = false;
        // $this->emit('traitementDone');
        // $this->emitSelf('traitementDone');
        // $this->emit('alert', 'success', 'Traitement effectué avec succès');
        // $this->reset('stat');
    }

    public function traiterCourrier()
    {
        $this->mode = 'edit';
        $this->emit('modeChanged');
    }

    public function validerTraitementSecretaire()
    {
        if ($this->courrier->type_id == 1) {
            // $traitement = new CourrierTraitement();
            // $courrier = Courrier::find($this->courrier->id);

            // // I complete same remaining courrier data
            // // $courrier->priorite_id = intval($this->stat['priorite_id']) ?? 0;
            // // $courrier->date_fin = !empty($this->stat['date_limite']) || $this->stat['date_limite'] != null ? $this->stat['date_limite'] : null;
            // // $courrier->traitement_id = $this->stat['traitement_id'];
            // // $courrier->save();

            // // I put in copy secretors
            // // $directions = Direction::find($this->stat['copie']);
            // // if ($directions) {
            // //     $agentSecretaires = $directions->map(function ($direction) {
            // //         return $direction->secretaire?->agent;
            // //     })->reject(function ($agent) {
            // //         return $agent == null;
            // //     });

            // //     if (count($agentSecretaires ?? [])) {
            // //         $courrier->followers()->attach($directions);
            // //     }
            // // }

            // // I save traitement
            // $traitement->agent_id = Auth::user()->agent->id;
            // $traitement->note = 'Accusé de reception'; //$this->commentaire;
            // $traitement->save();

            // $courrier->traitements()->attach($traitement);

            // // I change the stap
            // $courrier->etapes()->attach(3);
            // $courrier->destinateurs()->attach(Direction::find(1)->assistants());

            // Historique::create([
            //     "key" => "Accusé de reception",
            //     "historiquecable_id" => $this->courrier->id,
            //     "historiquecable_type" => Courrier::class,
            //     "description" => "A effectué des traitements sur ce courrier",
            //     "user_id" => Auth::user()->id,
            // ]);

            // event(new CourrierCreated($this->courrier, $courrier->destinateurs->where('id', '!=', Auth::user()->agent->id), 'Vous a transmi un nouveau courrier !'));
        } elseif ($this->courrier->type_id == 2) {

            // $agent = $this->courrier->traitements->last()->agent;
            // if ($agent) {
            //     event(new CourrierCreated($this->courrier, $agent, 'A accusé reception du courrier transmis'));
            // }

            $traitement = new CourrierTraitement();
            $courrier = Courrier::find($this->courrier->id);

            // I save traitement
            $traitement->agent_id = Auth::user()->agent->id;
            $traitement->note = 'Accusé de reception'; //$this->commentaire;
            $traitement->save();

            $courrier->traitements()->attach($traitement);

            // I change the stap
            $courrier->etapes()->attach(1);
            $agentService = Service::find(3)->responsable;
            $courrier->destinateurs()->attach($agentService);

            Historique::create([
                "key" => "Accusé de reception",
                "historiquecable_id" => $this->courrier->id,
                "historiquecable_type" => Courrier::class,
                "description" => "A effectué des traitements sur ce courrier",
                "user_id" => Auth::user()->id,
            ]);

            if ($agentService) {
                event(new CourrierCreated($this->courrier, $agentService, 'Vous a transmi un nouveau courrier !'));
            }
        }

        $this->mode = 'view';
        $this->seenBtnTraite = false;
        $this->emit('modeChanged');
        // $this->emit('alert', 'success', 'Traitement effectué avec succès');
        $this->reset('stat');
    }

    public function validerTraitement()
    {

        // if ($this->courrier->type_id == 1) {
        $traitement = new CourrierTraitement();
        $courrier = Courrier::find($this->courrier->id);

        if (Auth::user()->agent->isAssistant()) {

            // I complete same remaining courrier data
            $courrier->priorite_id = intval($this->stat['priorite_id']) ?? 0;
            $courrier->date_fin = !empty($this->stat['date_limite']) || $this->stat['date_limite'] != null ? $this->stat['date_limite'] : null;
            $courrier->traitement_id = $this->stat['traitement_id'];
            $courrier->save();

            // I put in copy secretors
            $directions = Direction::find($this->stat['copie']);
            if ($directions) {
                $agentSecretaires = $directions->map(function ($direction) {
                    return $direction->secretaire->agent;
                })->reject(function ($agent) {
                    return $agent == null;
                });

                if (count($agentSecretaires ?? [])) {
                    $courrier->followers()->attach($directions);
                }
            }

            // I save traitement
            $traitement->agent_id = Auth::user()->agent->id;
            $traitement->note = $this->commentaire;
            $traitement->save();

            $courrier->traitements()->attach($traitement);

            if ($courrier->type_id == 1) {

                // I change the stap
                $courrier->etapes()->attach(4);

                $courrier->destinateurs()->attach(Auth::user()->agent->direction->responsable);

                Historique::create([
                    "key" => "Accusé de reception",
                    "historiquecable_id" => $this->courrier->id,
                    "historiquecable_type" => Courrier::class,
                    "description" => "A effectué des traitements sur ce courrier",
                    "user_id" => Auth::user()->id,
                ]);

                $destinateurToNotify = $courrier->destinateurs->where('id', '!=', Auth::user()->agent->id);
                if (count($destinateurToNotify)) {
                    event(new CourrierCreated($this->courrier, $destinateurToNotify, 'Vous a transmi un nouveau courrier !'));
                }

            } elseif ($courrier->type_id == 2) {
                // I change the stap
                $courrier->etapes()->attach(2);

                $courrier->destinateurs()->attach(Auth::user()->agent->direction->secretaire);

                Historique::create([
                    "key" => "Accusé de reception",
                    "historiquecable_id" => $this->courrier->id,
                    "historiquecable_type" => Courrier::class,
                    "description" => "A effectué des traitements sur ce courrier",
                    "user_id" => Auth::user()->id,
                ]);

                $destinateursToNotify = $courrier->destinateurs->where('id', '!=', Auth::user()->agent->id)
                        ->where('id', '!=', Auth::user()->agent->direction->responsable->id);

                if (count($destinateursToNotify)) {
                    event(new CourrierCreated(
                        $this->courrier,
                        $destinateursToNotify,
                        'Vous a transmi un courrier sortant !'
                    ));
                }
            }
        }

        if (count($this->document_files)) {
            $filesPath = [];
            $path = 'courrier-traitements/' . date('FY') . '/';
            foreach ($this->document_files as $document) {
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
                "historiquecable_id" => $this->courrier->id,
                "historiquecable_type" => Courrier::class,
                "description" => "A joint un fichier à ce courrier",
                "user_id" => Auth::user()->id,
            ]);
        }

        // }

        $this->mode = 'view';
        $this->seenBtnTraite = false;
        $this->emit('modeChanged');
        $this->emit('alert', 'success', 'Traitement effectué avec succès');
        $this->reset('stat');
    }

    public function annulerTraitement()
    {
        $this->reset('mode');
        $this->reset('stat');
        $this->emit('modeChanged');
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
