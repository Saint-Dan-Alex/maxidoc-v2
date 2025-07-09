<?php

namespace App\Http\Livewire\Taches;

use App\Events\TacheCreated;
use App\Models\Tache;
use App\Models\TacheObjectif;
use Livewire\Component;

class ObjectifCheck extends Component
{

    public $tache;
    public $pourcentage;

    public function mount($tache, $pan = null)
    {
        $this->tache = $tache;
        $this->pourcentage = $tache->pourcentage;
    }

    public function objetcifChangeStatut($id)
    {
        try {
            
            $objectif = TacheObjectif::findOrFail($id);
            $statut = $objectif->statut;

            $objectif->update([
                'statut' => !$statut
            ]);

            $tache = Tache::findOrFail($objectif->tache_id);
            $a = TacheObjectif::where('tache_id',$this->tache->id)->count();
            $b = TacheObjectif::where('tache_id',$this->tache->id)->where('statut',1)->count();
            $pourcentage = ($b / $a) * 100;
            $tache->pourcentage = $pourcentage;
            $tache->save();

            $this->tache = $tache;
            $this->pourcentage = $pourcentage;

            $this->emit('alert', 'success', 'Objectif mis à jour avec succès');
            event(new TacheCreated($tache, $tache->user->agent->id, 'Objectif ' . $objectif->libelle . ' est mis à jour pour la tâche ' . $tache->titre));

        } catch (\Throwable $th) {
            //throw $th;
            $this->emit('alert', 'error', 'Echec de l\`opération');
        }

    }

    public function render()
    {
        return view('livewire.taches.objectif-check');
    }
}
