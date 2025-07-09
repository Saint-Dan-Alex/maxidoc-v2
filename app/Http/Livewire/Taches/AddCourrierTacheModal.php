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
                $direction = Direction::find($this->stat['direction_id']);
                $secretaires = $direction->secretaires->map(function ($secretaire)
                {
                    return $secretaire->responsable->id;
                });

                if ($secretaires->count()) {
                    $partage1 = CourriersPartage::create([
                        'courrier_id' => $this->courrier->id,
                        'agent_id' => $secretaires->first(),
                        // 'traitement_id' => $this->stat['traitement_id'] ?? null,
                        'note' => $this->stat['note'],
                        'send_by' => Auth::user()->id
                    ]);
                    event(new CourrierPartage($partage1, 'Un courrier vous a été partagé par ' . Auth::user()->agent->prenom . ' ' . Auth::user()->agent->nom));
                } else {
                    $this->emit('alert', 'error', 'Le partage n\'a pas reussi car la '.$direction->titre.' n\'a pas de secretaire');
                    $this->emit('finishPartage');
                    return;
                }

                if ($direction->responsable) {
                    $partage2 = CourriersPartage::create([
                        'courrier_id' => $this->courrier->id,
                        'agent_id' => $direction->responsable->id,
                        'note' => $this->stat['note'],
                        'send_by' => Auth::user()->id
                    ]);
                    event(new CourrierPartage($partage2, 'Un courrier vous a été partagé par ' . Auth::user()->agent->prenom . ' ' . Auth::user()->agent->nom));
                } else {
                    $this->emit('alert', 'error', 'Le partage n\'a pas reussi car la '.$direction->titre.' n\'a pas de directeur');
                    $this->emit('finishPartage');
                    return;
                }

                Historique::create([
                    "key" => "Accusé de reception",
                    "historiquecable_id" => $this->courrier->id,
                    "historiquecable_type" => Courrier::class,
                    "description"  => "".Auth::user()->agent->prenom." ". Auth::user()->agent->nom ." a partagé ce courrier avec la direction ". $direction->titre,
                    "user_id" => Auth::user()->id,
                ]);

            } else {
                $agent = $this->stat['agent_id'];
                $partage = CourriersPartage::create([
                    'courrier_id' => $this->courrier->id,
                    'agent_id' => $agent,
                    'traitement_id' => $this->stat['traitement_id'] ?? null,
                    'note' => $this->stat['note'],
                    'send_by' => Auth::user()->id
                ]);
                event(new CourrierPartage($partage, 'Un courrier vous a été partagé par ' . Auth::user()->agent->prenom . ' ' . Auth::user()->agent->nom));
        
            Historique::create([
                "key" => "Accusé de reception",
                "historiquecable_id" => $this->courrier->id,
                "historiquecable_type" => Courrier::class,
                "description"  => Auth::user()->agent->prenom." ". Auth::user()->agent->nom ." a partagé ce courrier avec la direction ". Auth::user()->agent->direction->titre,
                "user_id" => Auth::user()->id,
            ]);
            
        }

       

        $this->emit('alert', 'success', 'Partagé avec succès');
        $this->emit('finishPartage');
        $this->reset('to','stat');
    } 
}
