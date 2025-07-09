@extends('regidoc.layouts.layout-doc')
@section('content')
    <div class="block-scanner">
        {{-- @livewire('add-courrier-form', ['courrier' => $courrier,'types' => $types, 'natures'=> $natures, 'departements' => $departements, 'agents' => $agents]) --}}
        @livewire('courrier.edit-courrier-form', [
            'courrier' => $courrier,
            'types' => $types,
            'natures' => $natures,
            'services' => $services,
            'agents' => $agents,
        ])
    </div>

    @livewire('courrier.select-document')
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
        document.addEventListener('livewire:load', () => {
            Livewire.onPageExpired((response, message) => location.reload())
        })
    </script>
@endsection
