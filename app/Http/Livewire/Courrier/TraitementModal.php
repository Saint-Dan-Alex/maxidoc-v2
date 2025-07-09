<?php

namespace App\Http\Livewire\Courrier;

use App\Events\CourrierCreated;
use App\Models\Agent;
use App\Models\Courrier;
use App\Models\CourriersAnnotation;
use App\Models\CourrierTraitement;
use App\Models\CourrierTypesTraitement;
use App\Models\Direction;
use App\Models\Historique;
use App\Models\Priorite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
// use \iterable;
use Livewire\Component;
use Livewire\WithFileUploads;

class TraitementModal extends Component
{

    use WithFileUploads;

    public $courrier;
    public $followers = [];
    public $traitements;
    public $priorites;
    public $stat = [
        'date_limite' => '',
        'priorite_id' => '',
        'traitement_id' => '',
        'copie' => '',
    ];
    public $checkEcheance = false;
    public $commentaire;
    // public $copys;
    public $mode = 'vue';
    public $document_files = [];
    public $seenBtnTraite = true;

    public function mount($courrier)
    {
        $this->courrier = $courrier;
        $this->stat['traitement_id'] = $courrier->traitement_id;
        $this->followers = Direction::get()->except([1, 2]);
        $this->traitements = CourrierTypesTraitement::select('id', 'titre')->get();
        $this->priorites = Priorite::select('id', 'titre')->get();
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

    public function validerTraitement()
    {
        // dd(Auth::user()->agent->direction->dgAssistanats);
        $traitement = new CourrierTraitement();
        $courrier = Courrier::find($this->courrier->id);

        if (Auth::user()->agent->isAssistant() || Auth::user()->agent->isSecretaire()) {

            // I complete same remaining courrier data
            $courrier->priorite_id = intval($this->stat['priorite_id']) ?? 0;
            $courrier->date_fin = !empty($this->stat['date_limite']) || $this->stat['date_limite'] != null ? $this->stat['date_limite'] : null;
            $courrier->traitement_id = $this->stat['traitement_id'];
            $courrier->save();

            // I save traitement
            $traitement->agent_id = Auth::user()->agent->id;
            $traitement->note = $this->commentaire;
            $traitement->save();

            $courrier->traitements()->attach($traitement);

            if ($courrier->type_id == 1) {

                // I save annotation
                if ($this->commentaire) {
                    $annotation = new CourriersAnnotation();
                    $annotation->user_id = Auth::user()->id;
                    $annotation->courrier_id = $courrier->id;
                    $annotation->note = $this->commentaire;
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
                    "historiquecable_id" => $this->courrier->id,
                    "historiquecable_type" => Courrier::class,
                    "description" => "A effectué un traitement sur ce courrier",
                    "user_id" => Auth::user()->id,
                ]);

                if (Auth::user()->agent->isSecretaire()) {
                    $agentsToNotify = Agent::find(Auth::user()->agent->direction->dgAssistanats->pluck('responsable_id'));
                    if ((is_iterable($agentsToNotify) && count($agentsToNotify)) || $agentsToNotify) {
                        event(new CourrierCreated($this->courrier, $agentsToNotify, 'Vous a transmis un nouveau courrier !'));
                    }
                } elseif (Auth::user()->agent->isAssistant()) {
                    if (Auth::user()->agent->direction->responsable) {
                        event(new CourrierCreated($this->courrier, Auth::user()->agent->direction->responsable, 'Vous a transmis un nouveau courrier !'));
                    }
                }

            } elseif ($courrier->type_id == 2) {

                if(Auth::user()->agent->isAssistant()){
                    // I change the stap
                    $courrier->etapes()->attach(2);
                    $courrier->destinateurs()->attach(Auth::user()->agent->direction->secretaire);
                }

                Historique::create([
                    "key" => "Accusé de reception",
                    "historiquecable_id" => $this->courrier->id,
                    "historiquecable_type" => Courrier::class,
                    "description" => "A effectué un traitement sur ce courrier",
                    "user_id" => Auth::user()->id,
                ]);

                $destinateurToNotify = $courrier->destinateurs->where('id', '!=', Auth::user()->agent->id);
                if (count($destinateurToNotify)) {
                    event(new CourrierCreated(
                        $this->courrier,
                        $destinateurToNotify,
                        'Vous a transmi un courrier sortant !'));
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

        $this->mode = 'view';
        $this->seenBtnTraite = false;
        $this->emit('traitementDone');
        $this->emitSelf('traitementDone');
        $this->emit('alert', 'success', 'Traitement effectué avec succès');
        $this->reset('stat');
    }

    public function annulerTraitement()
    {
        // dd(true);
        // $this->reset('mode');
        $this->reset('stat');
        $this->emit('annulationDone');
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

    public function render()
    {
        return view('livewire.courrier.traitement-modal');
    }

}
