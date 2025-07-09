@extends('regidoc.layouts.layout-doc')
@section('content')
    <div class="block-scanner">
        @livewire('courrier.create-courrier-form')
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
    </script>
@endsection
