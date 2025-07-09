<?php

namespace App\Observers;

use App\Models\Tache;
use Carbon\Carbon;

class TacheObserver
{
    public function updating(Tache $tache)
    {
        if ($tache->tache_statut_id != 3 && $tache->tache_statut_id != 4) {
            // Vérifie si la date d'aujourd'hui est supérieure à la date_fin
            if (Carbon::now()->greaterThan($tache->date_fin)) {
                // Met à jour la colonne tache_statut_id avec la valeur 4
                $tache->tache_statut_id = 4;
            }
        }
    }
    /**
     * Handle the Tache "created" event.
     *
     * @param  \App\Models\Tache  $tache
     * @return void
     */
    public function created(Tache $tache)
    {
        //
    }

    /**
     * Handle the Tache "updated" event.
     *
     * @param  \App\Models\Tache  $tache
     * @return void
     */
    public function updated(Tache $tache)
    {
        //
    }

    /**
     * Handle the Tache "deleted" event.
     *
     * @param  \App\Models\Tache  $tache
     * @return void
     */
    public function deleted(Tache $tache)
    {
        //
    }

    /**
     * Handle the Tache "restored" event.
     *
     * @param  \App\Models\Tache  $tache
     * @return void
     */
    public function restored(Tache $tache)
    {
        //
    }

    /**
     * Handle the Tache "force deleted" event.
     *
     * @param  \App\Models\Tache  $tache
     * @return void
     */
    public function forceDeleted(Tache $tache)
    {
        //
    }
}
