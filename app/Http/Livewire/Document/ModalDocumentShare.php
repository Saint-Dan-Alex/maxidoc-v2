<?php

namespace App\Http\Livewire\Document;

use App\Events\CourrierPartage;
use App\Events\DocumentPartage;
use App\Models\Agent;
use App\Models\Cible;
use App\Models\Courrier;
use App\Models\CourriersPartage;
use App\Models\CourrierTypesTraitement;
use App\Models\Direction;
use App\Models\Document;
use App\Models\DocumentFollower;
use App\Models\Historique;
use App\Models\PivotUserTache;
use App\Models\Priorite;
use App\Models\Tache;
use App\Models\TacheObjectif;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ModalDocumentShare extends Component
{
    public $priorites;
    public $agents;
    public $directions;
    public $traitements;
    public $document;
    public $to;

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

    public function render()
    {
        $this->priorites = Priorite::all();
        $this->agents = Auth::user()->agent->direction->agents;
        $this->directions = Direction::where('id', '!=', Auth::user()->agent->direction->id)->get();
        $this->traitements = CourrierTypesTraitement::all();
        return view('livewire.document.modal-document-share');
    }

    public function mapSecretaires($secretaire)
    {
        return $secretaire->responsable->id;
    }

    public function savePartager()
    {
            $direction = null;
            $agent = null;

            if ($this->stat['to'] == 1) {
                $direction = Direction::find($this->stat['direction_id']);
                $secretaires = $direction->secretaires->map([$this, 'mapSecretaires']);
               
                if($secretaires->count()){ 
                    $partageSecretaire = DocumentFollower::create([
                        'document_id' => $this->document->id,
                        'agent_id' => $secretaires->first(),
                        'note' => $this->stat['note'],
                        'send_by' => Auth::user()->id,
                        'created_at' => now()->format('Y-m-d H:i:s')
                    ]);
                    event(new DocumentPartage($partageSecretaire, 'Un document vous a été partagé par ' . Auth::user()->agent->prenom . ' ' . Auth::user()->agent->nom));

                } else {
                    $this->emit('alert', 'error', 'Le partage n\'a pas reussi car la '.$direction->titre.' n\'a pas de secretaire');
                    $this->emit('finishPartage');
                    return;
                }

                if ($direction->responsable) {
                    $partageResponsable = DocumentFollower::create([
                        'document_id' => $this->document->id,
                        'agent_id' => $direction->responsable->id,
                        'note' => $this->stat['note'],
                        'send_by' => Auth::user()->id,
                        'created_at' => now()->format('Y-m-d H:i:s')
                    ]);
                    event(new DocumentPartage($partageResponsable, 'Un document vous a été partagé par ' . Auth::user()->agent->prenom . ' ' . Auth::user()->agent->nom));
                
                } else {
                    $this->emit('alert', 'error', 'Le partage n\'a pas reussi car la '.$direction->titre.' n\'a pas de directeur');
                    $this->emit('finishPartage');
                    return;
                }

                Historique::create([
                    "key" => "Accusé de reception",
                    "historiquecable_id" => $this->document->id,
                    "historiquecable_type" => Document::class,
                    "description"  => "".Auth::user()->agent->prenom." ". Auth::user()->agent->nom ." a partagé ce courrier avec la direction ". $direction->titre,
                    "user_id" => Auth::user()->id,
                ]);

            } else {
                $agent = Agent::find($this->stat['agent_id']);
                if (!$agent) {
                    // Si l'agent n'existe pas
                    $this->emit('alert', 'error', 'L\'agent sélectionné est introuvable.');
                    return;
                }
                $partageAgent = DocumentFollower::create([
                    'document_id' => $this->document->id,
                    'agent_id' => $agent->id,
                    'note' => $this->stat['note'],
                    'send_by' => Auth::user()->id,
                    'created_at' => now()->format('Y-m-d H:i:s')
                ]); 
                event(new DocumentPartage($partageAgent, 'Un document vous a été partagé par ' . Auth::user()->agent->prenom . ' ' . Auth::user()->agent->nom));
        
            Historique::create([
                "key" => "Accusé de reception",
                "historiquecable_id" => $this->document->id,
                "historiquecable_type" => Document::class,
                "description"  => Auth::user()->agent->prenom . ' ' . Auth::user()->agent->nom . ' a partagé ce document avec l\'agent ' . $agent->prenom . ' ' . $agent->nom,
                "user_id" => Auth::user()->id,
            ]);
            
        } 
        $this->emit('alert', 'success', 'Partagé avec succès');
        $this->emit('finishPartage');
        $this->reset('to','stat');
    } 
}
