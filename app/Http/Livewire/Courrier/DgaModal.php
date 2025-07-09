<?php

namespace App\Http\Livewire\Courrier;

use App\Events\CourrierCreated;
use App\Models\Agent;
use App\Models\Courrier;
use App\Models\CourriersAnnotation;
use App\Models\CourrierTraitement;
use App\Models\Historique;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DgaModal extends Component
{

    public $courrier;
    // public $annotation;
    // public $stat = [
    //     'note' => ''
    // ];

    protected $listeners = [
        'send' => 'send'
    ];

    public function mount($courrier) {
        $this->courrier = $courrier;
    }

    public function render()
    {
        return view('livewire.courrier.dga-modal');
    }

    public function send() {
        // dd(Auth::user()->agent->direction->dgAssistanats);
        $traitement = new CourrierTraitement();
        $courrier = Courrier::find($this->courrier->id);

        if (Auth::user()->agent->isDG()) {

            // // I complete same remaining courrier data
            // $courrier->priorite_id = intval($this->stat['priorite_id']) ?? 0;
            // $courrier->date_fin = !empty($this->stat['date_limite']) || $this->stat['date_limite'] != null ? $this->stat['date_limite'] : null;
            // $courrier->traitement_id = $this->stat['traitement_id'];
            // $courrier->save();

            // I save traitement
            $traitement->agent_id = Auth::user()->agent->id;
            $traitement->note = 'Votre traiment est requis pour ce(s) document(s)';
            $traitement->save();

            $courrier->traitements()->attach($traitement);

            if ($courrier->type_id == 1) {

                // // I save annotation
                // $annotation = new CourriersAnnotation();
                // $annotation->user_id = Auth::user()->id;
                // $annotation->courrier_id = $courrier->id;
                // $annotation->note = 'Votre traiment est requis pour ce(s) document(s)';
                // $annotation->save();

                $courrier->destinateurs()->attach(Auth::user()->agent->direction->dgaSecretaires->pluck('responsable_id'));
                // I change the stap
                $courrier->etapes()->attach(5);

                $agentsToNotify = Agent::find(Auth::user()->agent->direction->dgaSecretaires->pluck('responsable_id'));

                if ((is_iterable($agentsToNotify) && count($agentsToNotify)) || $agentsToNotify) {
                    $courrier->destinateurs()->attach($agentsToNotify);
                    event(new CourrierCreated($courrier, $agentsToNotify, 'A transmis un courrier au DGA pour traitement'));
                }else {
                    $this->emit('alert', 'error', 'Impossible d\'envoyer le courrier, car aucun(e) Secretaire n\'est affecté(e) pour le DGA');
                }

                Historique::create([
                    "key" => "Accusé de reception",
                    "historiquecable_id" => $courrier->id,
                    "historiquecable_type" => Courrier::class,
                    "description" => "Le DG a transmis ce courrier au DGA pour traitement",
                    "user_id" => Auth::user()->id,
                ]);

            }

        }

        // $this->emit('send');
        // $this->emitSelf('send');
        $this->emit('alert', 'success', 'Courrier envoyé avec succès');
        $this->emit('courrierSent');
    }

}
