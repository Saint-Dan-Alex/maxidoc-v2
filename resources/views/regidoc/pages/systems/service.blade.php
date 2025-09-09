@extends('layouts.app-settings')

@section('content')
    <div class="card card-lg">
        <div class="text-star">
            <h1 class="text-star-title">Service</h1>
            <p class="text-star-subtitle mb-0">
                Gérer les services
            </p>
        </div>
        {{-- <div class="block-circle">
            <div class="circle-white"></div>
            <div class="circle-white"></div>
            <div class="circle-white"></div>
        </div> --}}
    </div>

    @if (session()->has('session'))
        @php $flash = json_decode(session()->get('session')); @endphp
        @if ($flash)
            <div class="message-flash {{ $flash->statut }} show">
                <div class="content-text d-flex justify-content-center  gap-2">
                    <div class="content-text-imageBox d-flex justify-content-center align-items-center">
                        @if ($flash->statut === 'success')
                            <img src="{{ asset('assets/images/icons/iconvert-maxidoc.svg') }}" alt="icon success">
                        @elseif ($flash->statut === 'warnig' || $flash->statut === 'warning')
                            <img src="{{ asset('assets/images/icons/iconorange-maxidoc.svg') }}" alt="icon warning">
                        @else
                            <img src="{{ asset('assets/images/icons/error-icon.png') }}" alt="icon error">
                        @endif
                    </div>
                    <div class="text-star">
                        <h6>{{ $flash->name ?? 'Information' }}</h6>
                        <p>{{ $flash->message ?? '' }}</p>
                    </div>
                </div>
            </div>
            @php Session::forget('session'); @endphp
        @endif
    @endif
    <div class="container-fluid px-lg-2 block-top-margin">


        <div class="mt-3 row g-lg-3">
            <div class="col-lg-12">
                @livewire('systems.service')
            </div>
        </div>
    </div>
@endsection
