<div class="col-lg-12">

    <div class="card card-table">
        <div class="row g-1">
            <div class="col-12">
                <h4 class="mb-0">Visualisez vos archives</h4>
            </div>
        </div>
        <hr class="mb-4">
        <div class="row g-3">
            @php
                $groupeFiles = $groupeFiles->groupBy(function ($doc) {
                    $date = $doc->date_du_courrier ?? $doc->archived_at ?? $doc->created_at;
                    return \Carbon\Carbon::parse($date)->format('Y');
                });
            @endphp
            @forelse ($groupeFiles as $annee => $groupeFile)
                <div class="col-lg-2">
                    <div class="col-folder">
                        <a href="{{ route('regidoc.archive-classeurs.index', $annee) }}">
                            <div class="text-center">
                                <img src="{{ asset('assets/images/icons/Fichier 29.png') }}" alt="">
                                <div class="mt-2 text-center">
                                    <h6>{{ $annee }}</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            @empty
                <div class="text-center col-12">
                    <p>Aucun document archivé</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
