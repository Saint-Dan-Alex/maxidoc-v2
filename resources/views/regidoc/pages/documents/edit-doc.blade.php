@extends('regidoc.layouts.layout-doc')
@section('content')
    <div class="block-scanner">
        <div class="sidebar-doc">
            <div class="header-sidebar">
                <h4 class="ms-0">Modifier un courrier/dossier</h4>
            </div>
            @livewire('document.edit-doc-form', ['document' => $document, 'types' => $types, 'natures' => $natures, 'agents' => $agents])
        </div>
        <div class="content-scanner">
            <div class="container-fluid">
                <iframe src="{{ files($document?->document)->link }}" frameborder="0"
                    class="w-100 @if ($document?->document == '[]' || $document?->document == '' || $document?->document == null) d-none @endif"></iframe>
                <div class="block-no-file @if ($document?->document != '[]' && $document?->document != '' && $document?->document != null) d-none @endif">
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
@endsection
