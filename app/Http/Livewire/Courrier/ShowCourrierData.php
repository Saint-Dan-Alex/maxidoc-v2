<?php

namespace App\Http\Livewire\Courrier;

use App\Events\CourrierCreated;
use App\Models\Courrier;
use App\Models\CourrierTraitement;
use App\Models\CourrierTypesTraitement;
use App\Models\Direction;
use App\Models\Historique;
use App\Models\Priorite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class ShowCourrierData extends Component
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

    // public function mount($courrier)
    // {
    //     $this->courrier = $courrier;
    // }

    public function render()
    {
        $this->followers = Direction::get()->except([1, 2]);
        $this->traitements = CourrierTypesTraitement::select('id', 'titre')->get();
        $this->priorites = Priorite::select('id', 'titre')->get();
        return view('livewire.courrier.show-courrier-data');
    }

    public function setCopie($value)
    {
        $this->stat['copie'] = $value;
    }

    public function setPriorite($value)
    {
        $this->stat['priorite_id'] = $value;
    }

    public function setTraitement($value)
    {
        $this->stat['traitement_id'] = $value;
    }

    public function accuserReception()
    {
        $this->courrier->etapes->last()->pivot->view_by = Auth::user()->id;
        $this->courrier->etapes->last()->pivot->save();

        $agent = null;

        // if (CourrierTraitement::count() == 0) {
        //     $agent = $this->courrier->author;
        // } else {
        //     $agent = CourrierTraitement::latest()->first()->agent;
        // }

        if ($this->courrier->traitements->count() == 0) {
            $agent = $this->courrier->author;
        } else {
            $agent = $this->courrier->traitements->last()->agent;
        }

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
            $this->validerTraitementSecretaire();
        }

        $this->emit('alert', 'success', 'Accuser de reception effectué avec succès');
    }

    public function traiterCourrier()
    {
        $this->mode = 'edit';
        $this->emit('modeChanged');
    }

    public function validerTraitementSecretaire() {
        if ($this->courrier->type_id == 1) {
            $traitement = new CourrierTraitement();
            $courrier = Courrier::find($this->courrier->id);

            // I complete same remaining courrier data
            // $courrier->priorite_id = intval($this->stat['priorite_id']) ?? 0;
            // $courrier->date_fin = !empty($this->stat['date_limite']) || $this->stat['date_limite'] != null ? $this->stat['date_limite'] : null;
            // $courrier->traitement_id = $this->stat['traitement_id'];
            // $courrier->save();

            // I put in copy secretors
            // $directions = Direction::find($this->stat['copie']);
            // if ($directions) {
            //     $agentSecretaires = $directions->map(function ($direction) {
            //         return $direction->secretaire?->agent;
            //     })->reject(function ($agent) {
            //         return $agent == null;
            //     });

            //     if (count($agentSecretaires ?? [])) {
            //         $courrier->followers()->attach($directions);
            //     }
            // }

            // I save traitement
            $traitement->agent_id = Auth::user()->agent->id;
            $traitement->note = 'Accusé de reception'; //$this->commentaire;
            $traitement->save();

            $courrier->traitements()->attach($traitement);

            // I change the stap
            $courrier->etapes()->attach(3);
            $courrier->destinateurs()->attach(Direction::find(1)->assistants());

            // Historique::create([
            //     "key" => "Accusé de reception",
            //     "historiquecable_id" => $this->courrier->id,
            //     "historiquecable_type" => Courrier::class,
            //     "description" => "A effectué des traitements sur ce courrier",
            //     "user_id" => Auth::user()->id,
            // ]);

            event(new CourrierCreated($this->courrier, $courrier->destinateurs->where('id', '!=', Auth::user()->agent->id), 'Vous a transmi un nouveau courrier !'));

        }

        $this->mode = 'view';
        $this->seenBtnTraite = false;
        $this->emit('modeChanged');
        // $this->emit('alert', 'success', 'Traitement effectué avec succès');
        $this->reset('stat');
    }

    public function validerTraitement()
    {

        if ($this->courrier->type_id == 1) {
            $traitement = new CourrierTraitement();
            $courrier = Courrier::find($this->courrier->id);

            // dd(Auth::user()->agent->isAssistant());

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
                        return $direction->secretaires->pluck('responsable_id')->first();
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

                event(new CourrierCreated($this->courrier, $courrier->destinateurs->where('id', '!=', Auth::user()->agent->id), 'Vous a transmi un nouveau courrier !'));
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

        }

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
