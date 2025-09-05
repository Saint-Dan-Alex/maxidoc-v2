@if ($tache->objectifs->count() > 0)
    @foreach ($tache->objectifs as $objectif)
        @livewire('taches.edit-tache-participant-modal', ['objectif' => $objectif], key('edit-participant-'.$objectif->id))
    @endforeach
@endif

@if ($tache->pourcentage < 100 && $tache->statut_id != '3')
    @livewire('taches.add-tache-participant-modal', ['tache' => $tache], key('add-participant-'.$tache->id))
@endif
