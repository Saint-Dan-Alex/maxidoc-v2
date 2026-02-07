<?php

namespace App\Http\Livewire\Taches;

use Livewire\Component;
use Carbon\Carbon;

class TacheInfo extends Component
{
    public $tache;
    public $traitementTime = null;

    protected $listeners = [
        'reloadInfo' => '$refresh',
        'participantUpdated' => 'handleParticipantUpdated',
        'participantAdded' => 'handleParticipantAdded'
    ];
    
    protected $rules = [
        'message' => 'required|string',
        'file' => 'required|file',
    ];

    public function mount($tache)
    {
        $this->tache = $tache;
        $this->calculerTempsTraitement();
        // \Log::debug('TraitementTime après calcul', [
        //     'tache_id' => $this->tache->id,
        //     'traitementTime' => $this->traitementTime,
        //     'objectifs_count' => $this->tache->objectifs ? $this->tache->objectifs->count() : 0,
        //     'objectif_statut' => $this->tache->objectifs && $this->tache->objectifs->count() > 0 ? $this->tache->objectifs->first()->statut : 'N/A'
        // ]);
    }

    public function calculerTempsTraitement()
    {
        // Vérifier si la relation objectifs est chargée
        if (!$this->tache->relationLoaded('objectifs')) {
            // \Log::warning('La relation objectifs n\'est pas chargée pour la tâche ' . $this->tache->id);
            return;
        }

        $objectif = $this->tache->objectifs->first();
        
        if (!$objectif) {
            // \Log::info('Aucun objectif trouvé pour la tâche ' . $this->tache->id);
            return;
        }

        // Journaliser les dates pour le débogage
        // \Log::debug('Objectif trouvé pour la tâche ' . $this->tache->id, [
        //     'created_at' => $objectif->created_at,
        //     'updated_at' => $objectif->updated_at,
        //     'statut' => $objectif->statut ?? 'non défini'
        // ]);

        try {
            // Utiliser created_at comme date de début (accusé de réception)
            // et updated_at comme date de fin (validation)
            $debut = Carbon::parse($objectif->created_at);
            $fin = Carbon::parse($objectif->updated_at);
            
            // Vérifier si l'objectif est marqué comme terminé (statut = 1)
            if (isset($objectif->statut) && $objectif->statut == 1) {
                if ($fin->lessThan($debut)) {
                    // \Log::warning('La date de mise à jour est antérieure à la date de création', [
                    //     'debut' => $debut,
                    //     'fin' => $fin
                    // ]);
                    return;
                }
                
                $secondes = $fin->diffInSeconds($debut);
                
                if ($secondes < 60) {
                    $this->traitementTime = $secondes . ' secondes';
                } elseif ($secondes < 3600) {
                    $minutes = floor($secondes / 60);
                    $resteSecondes = $secondes % 60;
                    $this->traitementTime = $minutes . ' min' . ($resteSecondes > 0 ? ' ' . $resteSecondes . 's' : '');
                } elseif ($secondes < 86400) {
                    $heures = floor($secondes / 3600);
                    $minutes = floor(($secondes % 3600) / 60);
                    $this->traitementTime = $heures . 'h' . ($minutes > 0 ? ' ' . $minutes . 'min' : '');
                } else {
                    $jours = floor($secondes / 86400);
                    $heures = floor(($secondes % 86400) / 3600);
                    $this->traitementTime = $jours . 'j' . ($heures > 0 ? ' ' . $heures . 'h' : '');
                }
                
                // \Log::info('Temps de traitement calculé', [
                //     'tache_id' => $this->tache->id,
                //     'temps' => $this->traitementTime,
                //     'secondes' => $secondes,
                //     'statut' => $objectif->statut
                // ]);
            } else {
                // Si l'objectif n'est pas marqué comme terminé, on ne calcule pas le temps
                $this->traitementTime = 'En cours';
                // \Log::info('Objectif non terminé, pas de calcul de temps', [
                //     'tache_id' => $this->tache->id,
                //     'statut' => $objectif->statut
                // ]);
            }
            
        } catch (\Exception $e) {
            // \Log::error('Erreur lors du calcul du temps de traitement', [
            //     'tache_id' => $this->tache->id,
            //     'error' => $e->getMessage(),
            //     'trace' => $e->getTraceAsString()
            // ]);
        }
    }

    public function handleParticipantUpdated()
    {
        $this->tache->refresh();
        $this->emit('reloadInfo');
    }
    
    public function handleParticipantAdded()
    {
        $this->tache->refresh();
        $this->emit('reloadInfo');
    }

    public function render()
    {
        $this->tache->load('children.user.agent');
        return view('livewire.taches.tache-info');
    }
}