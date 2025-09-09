@extends('layouts.app-settings')


@section('content')
    <div class="card card-lg">
        <div class="text-star">
            <h1 class="text-star-title">Fonction</h1>
            <p class="mb-0 text-star-subtitle mb-0">
                Gérer les fonctions
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


        <div class=" mt-2 row g-lg-3">
            <div class="col-lg-12">
                @livewire('systems.fonction')
            </div>
        </div>
    </div>

    @livewire('systems.fonction-add')

    @foreach ($fonctions as $fonction)
        @livewire('systems.fonction-edit', ['fonction' => $fonction])
        </div>
        <div class="modal fade" id="modal-show-fonction-{{ $fonction->id }}" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                            <span>Liste des Employés</span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @foreach ($fonction->agents as $agent)
                            <ul>
                                <li> {{ $agent->prenom . ' ' . $agent->nom }} <strong> {{ $agent->service?->titre }}
                                    </strong>
                                </li>
                            </ul>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <script>
        document.addEventListener('livewire:load', function () {
            if (window.Livewire && typeof Livewire.on === 'function') {
                Livewire.on('alert', (statut, message) => {
                    try {
                        const wrapper = document.createElement('div');
                        wrapper.className = `message-flash ${statut} show`;
                        wrapper.innerHTML = `
                            <div class="content-text d-flex justify-content-center gap-2">
                                <div class="content-text-imageBox d-flex justify-content-center align-items-center">
                                    ${statut === 'success'
                                        ? `<img src='${@json(asset('assets/images/icons/iconvert-maxidoc.svg'))}' alt='icon success'>`
                                        : statut === 'warning' || statut === 'warnig'
                                            ? `<img src='${@json(asset('assets/images/icons/iconorange-maxidoc.svg'))}' alt='icon warning'>`
                                            : `<img src='${@json(asset('assets/images/icons/error-icon.png'))}' alt='icon error'>`}
                                </div>
                                <div class="text-star">
                                    <h6>Informations</h6>
                                    <p>${message ?? ''}</p>
                                </div>
                            </div>`;
                        document.body.appendChild(wrapper);
                        setTimeout(() => {
                            wrapper.classList.remove('show');
                            setTimeout(() => wrapper.remove(), 300);
                        }, 5000);
                    } catch (e) {
                        console.error(e);
                    }
                });
            }
        });
    </script>
@endsection
