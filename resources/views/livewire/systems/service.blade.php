<div class="col-lg-12">

    <div class="card card-table" style="overflow: inherit">
        <div class="d-none position-absolute loader-card d-flex justify-content-center m-0"
            style="z-index: 2; left:5px; right:5px; top:5px; bottom:5px; background-color: rgba(255,255,255,0.95)"
            wire:loading wire:target="filter, changeFilter" wire:loading.class.remove="d-none">
            <div class="text-center m-auto">
                <div class="spinner-border " role="status" style="color: var(--primaryColor)">
                    <span class="sr-only"></span>
                </div>
            </div>
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
        <div class="row">
            <div class="col-lg-4">
                <div class="d-flex align-items-center">
                    <input type="text" class="form-control me-2 input-search-card" placeholder="Recherche"
                        style="border:none;" wire:model='search'>
                    <div class="dropdown">
                        <button class="btn btn-filter" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <svg data-name="Layer 1" viewBox="0 0 24 24" width="512" height="512">
                                <path
                                    d="M24,3c0,.55-.45,1-1,1H1c-.55,0-1-.45-1-1s.45-1,1-1H23c.55,0,1,.45,1,1ZM15,20h-6c-.55,0-1,.45-1,1s.45,1,1,1h6c.55,0,1-.45,1-1s-.45-1-1-1Zm4-9H5c-.55,0-1,.45-1,1s.45,1,1,1h14c.55,0,1-.45,1-1s-.45-1-1-1Z">
                                </path>
                            </svg>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li><a class="dropdown-item" href="javascript:void(0)" wire:click='changeFilter(1)'>Par
                                    défaut</a>
                            </li>
                            <li><a class="dropdown-item" href="javascript:void(0)" wire:click='changeFilter(2)'>A -
                                    Z</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0)" wire:click='changeFilter(3)'>Z -
                                    A</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0)" wire:click='changeFilter(4)'>Date
                                    d'ajout</a>
                            </li>
                            <li><a class="dropdown-item" href="javascript:void(0)" wire:click='changeFilter(5)'>Date de
                                    modification</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 ms-auto d-flex align-items-center justify-content-end">
                <a href="#" class="btn btn-add" data-bs-toggle="modal" style="flex: 0 0 auto"
                    data-bs-target="#modal-new-service">
                    Ajouter
                </a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Nom</th>
                        <th scope="col">Direction</th>
                        <th scope="col">Responsable</th>
                        <th scope="col">Nbe agents</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($services as $service)
                        <tr>
                            <td class="text-truncate"> {{ $service->titre }} </td>
                            <td class="text-truncate"> {{ $service->direction?->titre }} </td>
                            <td> {{ $service->responsable ? $service->responsable->prenom . ' ' . $service->responsable->nom : 'Non défini' }} </td>
                            <td> {{ $service->agents->count() }} </td>
                            <td>
                                <div class="d-flex align-items-center btns-action-table">
                                    {{-- <a href="#" class="btn btn-primary me-2" data-bs-toggle="modal"
                                        data-bs-target="#modal-show-service-{{ $service->id }}">
                                        <i class="fi fi-rr-eye"></i>
                                        <span class="btn-text">Voir</span>
                                    </a> --}}
                                    <a href="#" class="btn btn-success me-2" data-bs-toggle="modal"
                                        data-bs-target="#modal-edit-service-{{ $service->id }}">
                                        <i class="fi fi-rr-pencil"></i>
                                        <span class="btn-text">Éditer</span>
                                    </a>
                                    <form action="{{ route('regidoc.services.destroy', $service) }}" method="POST" class="me-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce service ?')">
                                            <i class="fi fi-rr-trash"></i>
                                            <span class="btn-text">Supprimer</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">
                                <div class="py-4">
                                    <img src="{{ asset('assets/images/sad.gif') }}" alt="" width="35px">
                                    <p class="mt-2 mb-0">Aucun service trouvé</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            
            <!-- Pagination -->
            @if($services->hasPages())
                <div class="mt-4 d-flex justify-content-center">
                    {{ $services->links() }}
                </div>
            @endif
        </div>
    </div>

    <div class="modal fade" id="modal-new-service" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                        <span>Ajouter un service</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('regidoc.services.store') }}" method="POST">
                        @csrf
                        <div class="form-group row g-4">
                            <div class="col-lg-12">
                                <label for="">Titre</label>
                                <input type="text" name="libelle" class="form-control" placeholder="Nom du service"
                                    required>
                            </div>
                            <div class="col-lg-12">
                                <label>Direction</label>
                                <select name="direction_id" class="form-control select2Bis" data-placeholder="Sélectionner une direction" required>
                                    <option value=""></option>
                                    @foreach ($allDirections as $direction)
                                        <option value="{{ $direction->id }}">{{ $direction->titre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- <div class="col-lg-12">
                                <label for="">Division</label>
                                <select name="division_id" class="form-control select2Bis" required
                                    data-placeholder="Selectionnez le Division">
                                    <option value=""></option>
                                    @foreach ($divisions as $division)
                                        <option value="{{ $division->id }}"> {{ $division->libelle }} </option>
                                    @endforeach
                                </select>
                            </div> --}}
                            <div class="col-lg-12">
                                <label>Responsable</label>
                                <select name="responsable_id" class="form-control select2Bis" data-placeholder="Sélectionner un responsable">
                                    <option value=""></option>
                                    @foreach ($agents as $agent)
                                        <option value="{{ $agent->id }}">
                                            {{ $agent->prenom }} {{ $agent->nom }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- <div class="col-lg-12">
                                <label for="">Description</label>
                                <textarea name="description" class="form-control" cols="30" rows="5"></textarea>
                            </div>
                            <div class="col-lg-12">
                                <label for="">Statut</label>
                                <select name="statut_id" class="form-control select2Bis" data-placeholder="Sélectionner un statut" required>
                                    <option value=""></option>
                                    @foreach ($statuts as $statut)
                                        <option value="{{ $statut->id }}">
                                            {{ $statut->libelle }}
                                        </option>
                                    @endforeach
                                </select>
                            </div> --}}
                            <div class="col-lg-12 text-end">
                                <button class="btn btn-add">Ajouter</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @foreach ($services as $service)
        <div class="modal fade" id="modal-edit-service-{{ $service->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                            <span>Modifier un service</span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('regidoc.services.update', $service->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group row g-4">
                                <div class="col-lg-12">
                                    <label for="">Titre</label>
                                    <input type="text" name="libelle" class="form-control" value="{{ $service->titre }}"
                                        placeholder="Nom du service" required>
                                </div>
                                <div class="col-lg-12">
                                    <label for="direction_id">Direction</label>
                                    <select name="direction_id" id="direction_id" class="form-control select2Bis" required
                                        data-placeholder="Sélectionner une direction">
                                        <option value=""></option>
                                        @foreach ($directions as $direction)
                                            <option value="{{ $direction->id }}" {{ $service->direction_id == $direction->id ? 'selected' : '' }}>
                                                {{ $direction->titre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-12">
                                    <label for="responsable_id">Responsable</label>
                                    <select name="responsable_id" id="responsable_id" class="form-control select2Bis" data-placeholder="Sélectionner un responsable">
                                        <option value=""></option>
                                        @foreach ($agents as $agent)
                                            <option value="{{ $agent->id }}" @selected($service->responsable_id == $agent->id)>
                                                {{ $agent->prenom }} {{ $agent->nom }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-12">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" class="form-control" 
                                        rows="3" placeholder="Description du service">{{ $service->description }}</textarea>
                                </div>
                                <div class="col-lg-12">
                                    <label for="statut_id">Statut</label>
                                    <select name="statut_id" id="statut_id" class="form-control select2Bis" data-placeholder="Sélectionner un statut" required>
                                        <option value=""></option>
                                        @foreach($statuts as $statut)
                                            <option value="{{ $statut->id }}" {{ $service->statut_id == $statut->id ? 'selected' : '' }}>
                                                {{ $statut->libelle }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-12 text-end">
                                    <button type="submit" class="btn btn-add">
                                        <i class="fi fi-rr-check"></i> Enregistrer les modifications
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:load', function() {
        // Initialisation de Select2 pour les modaux
        function initSelect2() {
            $('.select2Bis').each(function() {
                $(this).select2({
                    placeholder: $(this).data('placeholder') || 'Sélectionner...',
                    language: "fr",
                    dropdownParent: $(this).closest('.modal'),
                    allowClear: true,
                    width: '100%',
                    theme: 'bootstrap-5',
                    // Pour avoir l'apparence de multiple mais avec une seule sélection
                    templateResult: function(data) {
                        if (!data.id) { return data.text; }
                        return $('<span class="d-flex align-items-center"><span class="flex-grow-1">' + data.text + '</span><span class="badge bg-primary ms-2">1</span></span>');
                    },
                    templateSelection: function(data) {
                        if (!data.id) { return data.text; }
                        return $('<span class="d-flex align-items-center"><span class="flex-grow-1">' + data.text + '</span><span class="badge bg-primary ms-2">1</span></span>');
                    }
                });
            });
        }

        // Initialisation au chargement de la page
        initSelect2();

        // Réinitialisation des champs du modal d'ajout quand il est fermé
        $('#modal-new-service').on('shown.bs.modal', function () {
            initSelect2();
        });

        // Réinitialisation des champs du modal d'édition quand il est fermé
        $('div[id^="modal-edit-service-"]').on('shown.bs.modal', function () {
            initSelect2();
        });

        // Réinitialisation de Select2 quand Livewire met à jour le DOM
        document.addEventListener('livewire:update', function() {
            initSelect2();
        });
    });
</script>
@endpush
