<?php

namespace App\Http\Livewire\Taches;

// use App\Events\DocumentPartage;
use App\Events\CourrierPartage;
use App\Models\Agent;
use App\Models\Cible;
use App\Models\Courrier;
use App\Models\CourriersPartage;
use App\Models\CourrierTypesTraitement;
use App\Models\Direction;
use App\Models\DocumentFollower;
use App\Models\Historique;
use App\Models\PivotUserTache;
use App\Models\Priorite;
use App\Models\Tache;
use App\Models\TacheObjectif;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AddCourrierTacheModal extends Component
{
    public $stat = [
        'agent_id' => '',
        'traitement_id' => '',
        'debut' => '',
        'fin' => '',
        'priorite_id' => '',
        'note' => '',
        'to' => '',
        'direction_id' => '',
    ];

    public $priorites;
    public $agents;
    public $directions;
    public $traitements;
    public $courrier;
    public $to;

    public function mount($courrier = null)
    {
        if ($courrier) {
            $this->courrier = $courrier;
        }
    }

    public function render()
    {
        $this->priorites = Priorite::all();
        $this->agents = Auth::user()->agent->direction->agents;
        $this->directions = Direction::where('id', '!=', Auth::user()->agent->direction->id)->get();
        $this->traitements = CourrierTypesTraitement::all();
        return view('livewire.taches.add-courrier-tache-modal');
    }

    public function savePartager()
    {
            $direction = null;
            $agent = null;

            if ($this->stat['to'] == 1) {
                if (empty($this->stat['direction_id'])) {
                    $this->emit('alert', 'error', 'Veuillez sélectionner une direction');
                    $this->emit('finishPartage');
                    return;
                }
                $direction = Direction::find($this->stat['direction_id']);

                // 1. Vérifier le responsable (OBLIGATOIRE)
                if (!$direction->responsable) {
                    $this->emit('alert', 'error', 'Le partage a échoué car la ' . $direction->titre . ' n\'a pas de responsable (directeur) défini.');
                    $this->emit('finishPartage');
                    return;
                }

                // 2. Partage au responsable
                $partageResponsable = CourriersPartage::create([
                    'courrier_id' => $this->courrier->id,
                    'agent_id' => $direction->responsable->id,
                    'note' => $this->stat['note'],
                    'send_by' => Auth::user()->id
                ]);
                event(new CourrierPartage($partageResponsable, 'Un courrier vous a été partagé par ' . Auth::user()->agent->prenom . ' ' . Auth::user()->agent->nom));

                // 3. Partage aux secrétaires (OPTIONNEL)
                $secretaires = $direction->secretaires->map(function ($secretaire) {
                    return $secretaire->responsable ? $secretaire->responsable->id : null;
                })->filter();

                if ($secretaires->count()) {
                    foreach ($secretaires as $secretaireId) {
                        $partageSecretaire = CourriersPartage::create([
                            'courrier_id' => $this->courrier->id,
                            'agent_id' => $secretaireId,
                            'note' => $this->stat['note'],
                            'send_by' => Auth::user()->id
                        ]);
                        event(new CourrierPartage($partageSecretaire, 'Un courrier vous a été partagé par ' . Auth::user()->agent->prenom . ' ' . Auth::user()->agent->nom));
                    }
                }

                Historique::create([
                    "key" => "Accusé de reception",
                    "historiquecable_id" => $this->courrier->id,
                    "historiquecable_type" => Courrier::class,
                    "description"  => "".Auth::user()->agent->prenom." ". Auth::user()->agent->nom ." a partagé ce courrier avec la direction ". $direction->titre,
                    "user_id" => Auth::user()->id,
                ]);

            } else {
                // Partage à un agent de ma direction: l'utilisateur choisit l'agent
                if (empty($this->stat['agent_id'])) {
                    $this->emit('alert', 'error', 'Veuillez sélectionner un agent');
                    $this->emit('finishPartage');
                    return;
                }

                $agentId = (int) $this->stat['agent_id'];
                if ($agentId <= 0) {
                    $this->emit('alert', 'error', "ID de l'agent invalide");
                    $this->emit('finishPartage');
                    return;
                }

                $partage = CourriersPartage::create([
                    'courrier_id' => $this->courrier->id,
                    'agent_id' => $agentId,
                    'traitement_id' => $this->stat['traitement_id'] ?? null,
                    'note' => $this->stat['note'],
                    'send_by' => Auth::user()->id
                ]);

                event(new CourrierPartage($partage, 'Un courrier vous a été partagé par ' . Auth::user()->agent->prenom . ' ' . Auth::user()->agent->nom));

                Historique::create([
                    "key" => "Accusé de reception",
                    "historiquecable_id" => $this->courrier->id,
                    "historiquecable_type" => Courrier::class,
                    "description"  => Auth::user()->agent->prenom." ". Auth::user()->agent->nom ." a partagé ce courrier avec un agent de sa direction",
                    "user_id" => Auth::user()->id,
                ]);
            }

       

        $this->emit('alert', 'success', 'Partagé avec succès');
        $this->emit('finishPartage');
        $this->reset('to','stat');
    } 
}
