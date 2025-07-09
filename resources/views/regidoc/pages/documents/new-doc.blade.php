@extends('regidoc.layouts.layout-doc')
@section('content')
    <div class="block-scanner">
        <div class="sidebar-doc">
            <div class="header-sidebar">
                <a href="{{ url()->previous() }}" class="btn-back" style="font-size: 14px; color: var(--colorTitle)">
                    <i class="fi fi-rr-angle-left"></i>
                    <div class="tooltip-indicator">
                        Retour
                    </div>
                </a>
                <h4 class="ms-0">Enregistrer un courrier/dossier</h4>
            </div>
            @livewire('document.add-doc-form', ['types' => $types, 'natures' => $natures, 'services' => $services, 'agents' => $agents, 'dossier_id' => $dossier_id])
        </div>
        <div class="content-scanner">
            <div class="container-fluid">
                <iframe src="" frameborder="0" class="w-100 d-none"></iframe>
                <div class="block-no-file">
                    <i class="bi bi-file icon"></i>
                    <h4>Pas encore de document importé</h4>
                    <p>Le document numérisé apparaîtra ici.</p>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('javascript')
    <script>
        $(document).ready(function() {
            $('#check-date').on('click', function() {
                // var parent = $('#inputPassword').parent().parent();
                $('.date-limite').toggleClass('d-none');

                // console.log($(this).val());
                // $('#inputPassword').attr('required');
            });

            $('input[name=confidentiel]').on('click', function() {
                // var parent = $('#inputPassword').parent().parent();
                // $('.date-limite').toggleClass('d-none');
                console.log($(this));
            });

        });
    </script>

    {{-- <div wire:scroll="scrollHandler">Contenu défilable</div> --}}
    {{-- public function scrollHandler($event)
    {
        // Vous pouvez accéder à la position du défilement via $event['scrollTop']
        $scrollPosition = $event['scrollTop'];

        // Faites quelque chose avec la position du défilement...
    } --}}
@endsection
