@extends('regidoc.layouts.layout-doc')

@section('style')
    <style>
        input:invalid {
            border: 1px solid red;
        }
        select:invalid {
            border: 1px solid red;
        }
    </style>
@endsection

@section('content')
    <div class="block-scanner">
        @livewire('courrier.add-courrier-form', [
            'types' => $types,
            'natures' => $natures,
            'services' => $services,
            // 'agents' => $agents,
            'newDoc' => isset($newDoc) ? true : false,
            'textSelected' => isset($textSelected) ? $textSelected : '',
            'fileName' => isset($fileName) ? $fileName : '',
        ])
    </div>

    {{-- @livewire('courrier.select-document') --}}
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
        // document.addEventListener('livewire:load', () => {
        //     Livewire.onPageExpired((response, message) => location.reload())
        // })
    </script>
@endsection
