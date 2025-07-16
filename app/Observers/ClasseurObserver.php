<?php

namespace App\Observers;

use App\Models\Classeur;
use Illuminate\Support\Str;

class ClasseurObserver
{
    /**
     * Handle the Classeur "creating" event.
     *
     * @param  \App\Models\Classeur  $classeur
     * @return void
     */
    public function creating(Classeur $classeur)
    {
        if (empty($classeur->reference)) {
            $nextId = Classeur::withTrashed()->count() + 1;
            $classeur->reference = 'DIR/' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
        }
    }
}
