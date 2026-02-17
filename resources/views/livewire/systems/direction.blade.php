{{-- <script>
    fetch('/ajax/types/get/all/agents')
        .then(response => response.json())
        .then(data => {
            console.log('Liste des agents :', data);
        })
        .catch(error => {
            console.error('Erreur lors de la récupération des agents:', error);
        });
</script> --}}
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
                            {{-- <i class="fi fi-rr-filter me-2"></i> {{ $filterText }} --}}
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li><a class="dropdown-item" href="javascript:void(0)" wire:click='changeFilter(1)'>Par
                                    défaut</a>
                            </li>
                            <li><a class="dropdown-item" href="javascript:void(0)" wire:click='changeFilter(6)'>Lieu
                                    d'Affectation</a>
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
            <div class="col-lg-5 ms-auto">
                <div class="d-flex justify-content-end align-items-center">

                    <a href="#" class="btn btn-add" data-bs-toggle="modal" data-bs-target="#modal-new-direction"
                        style="flex: 0 0 auto">
                        Ajouter
                    </a>
                </div>
            </div>
        </div>

        {{-- @livewire('datatable.datatable', [
            'model' => \App\Models\Direction::class,
            'options' => [
                'headers' => [
                    'Code',
                    'Nom',
                    'Lieu',
                    'Responsable',
                    'Responsable Adjoint',
                    'Nbr Agents',
                ],
                'headers' => [
                    'code',
                    'titre',
                    'Lieu',
                    'Responsable',
                    'Responsable Adjoint',
                    'Nbr Agents',
                ],
            ]
        ]) --}}

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Code</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Lieu</th>
                        <th scope="col">Responsable</th>
                        <th scope="col">Responsable Adjoint</th>
                        <th scope="col">Nbr Agents</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($directions as $direction)
                        <tr>
                            <td> {{ $direction->code }} </td>
                             <td class="text-truncate"> {{ $direction->titre }} </td>
                            <td>
                                @foreach($direction->lieux as $l)
                                    <span class="badge bg-light text-dark border">{{ $l->titre }}</span>
                                @endforeach
                            </td>
                            <td> {{ $direction->responsable ? $direction->responsable->prenom . ' ' . $direction->responsable->nom : 'Non défini' }} </td>
                            <td> {{ $direction->adjoint ? $direction->adjoint->prenom . ' ' . $direction->adjoint->nom : 'Non défini' }} </td>
                            <td> {{ $direction->agents->count() }} </td>
                            <td>
                                <div class="d-flex align-items-center btns-action-table">
                                    <a href="#" class="btn btn-success me-2 btn-edit-direction" 
                                        data-direction-id="{{ $direction->id }}"
                                        data-direction-code="{{ $direction->code }}"
                                        data-direction-titre="{{ $direction->titre }}"
                                        data-direction-lieux="{{ json_encode($direction->lieux->pluck('id')->toArray()) }}"
                                        data-direction-responsable="{{ $direction->responsable_id }}"
                                        data-direction-adjoint="{{ $direction->adjoint_id }}">
                                        <i class="fi fi-rr-pencil"></i>
                                        <span class="btn-text">Éditer</span>
                                    </a>
                                    <form action="{{ route('regidoc.directions.destroy', $direction) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette direction ?')">
                                            <i class="fi fi-rr-trash"></i>
                                            <span class="btn-text">Supprimer</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">
                                <div class="text-center col-12">
                                    <img src="{{ asset('assets/images/sad.gif') }}" alt="" width="35px">
                                    <p>Aucune direction trouvée</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            
            <!-- Pagination -->
            @if($directions->hasPages())
                <div class="mt-4 d-flex justify-content-center">
                    {{ $directions->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- MODALE UNIQUE DE MODIFICATION --}}
    <div class="modal fade" id="modal-edit-direction" tabindex="-1" aria-hidden="true" wire:ignore>
        <div class="modal-dialog modal-dialog-centered">
            <form id="form-edit-direction" method="POST" class="modal-content">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Modifier une Direction</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group row g-3">
                        <div class="col-12 mb-3">
                            <label>Code</label>
                            <input type="text" name="code" id="edit-code" class="form-control" required>
                        </div>
                        <div class="col-12 position-relative mb-3">
                            <label for="edit-lieux">Lieux d'affectation</label>
                            <select name="lieu_ids[]" id="edit-lieux" class="form-control select2-edit" data-placeholder="Sélectionner les lieux" multiple required>
                                @foreach($lieus as $lieu)
                                    <option value="{{ $lieu->id }}">{{ $lieu->titre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 mb-3">
                            <label>Titre</label>
                            <input type="text" name="libelle" id="edit-titre" class="form-control" required>
                        </div>
                        <div class="col-12 position-relative mb-3">
                            <label>Responsable</label>
                            <select name="responsable_id" id="edit-responsable" class="form-control select2-edit" data-placeholder="Sélectionner le responsable">
                                <option value=""></option>
                                @foreach ($agents as $agent)
                                    <option value="{{ $agent->id }}">{{ $agent->prenom }} {{ $agent->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-12 position-relative mb-3">
                            <label>Responsable Adjoint</label>
                            <select name="adjoint_id" id="edit-adjoint" class="form-control select2-edit" data-placeholder="Sélectionner le responsable adjoint">
                                <option value=""></option>
                                @foreach ($agents as $agent)
                                    <option value="{{ $agent->id }}">{{ $agent->prenom }} {{ $agent->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-add">Modifier</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>

@push('scripts')
<script>
    (function() {
        console.log('✅ Init gestionnaire Direction');
        
        // Initialiser Select2 une seule fois au chargement
        function initSelect2() {
            $('.select2-edit').each(function() {
                if ($(this).hasClass("select2-hidden-accessible")) {
                    $(this).select2('destroy');
                }
                
                $(this).select2({
                    dropdownParent: $('#modal-edit-direction'),
                    placeholder: $(this).data('placeholder') || 'Sélectionner...',
                    language: "fr",
                    width: '100%',
                    templateResult: function(data) {
                        return data.text;
                    },
                    templateSelection: function(data) {
                        return data.text;
                    }
                });
            });
            console.log('✅ Select2 initialisés');
        }

        // Initialiser au chargement
        $(document).ready(function() {
            initSelect2();
        });

        // Clic sur le bouton Éditer
        $(document).on('click', '.btn-edit-direction', function(e) {
            e.preventDefault();
            
            const directionId = $(this).data('direction-id');
            const code = $(this).data('direction-code');
            const titre = $(this).data('direction-titre');
            const lieuIds = $(this).data('direction-lieux');
            const responsableId = $(this).data('direction-responsable');
            const adjointId = $(this).data('direction-adjoint');
            
            console.log('📂 Ouverture édition direction:', directionId);
            
            // Mettre à jour l'action du formulaire
            const formAction = "{{ route('regidoc.directions.update', ':id') }}".replace(':id', directionId);
            $('#form-edit-direction').attr('action', formAction);
            
            // Remplir les champs
            $('#edit-code').val(code);
            $('#edit-titre').val(titre);
            
            // Définir les valeurs Select2
            $('#edit-lieux').val(lieuIds).trigger('change');
            $('#edit-responsable').val(responsableId).trigger('change');
            $('#edit-adjoint').val(adjointId).trigger('change');
            
            // Ouvrir la modale
            $('#modal-edit-direction').modal('show');
        });

        // Réinitialiser à la fermeture
        $('#modal-edit-direction').on('hidden.bs.modal', function() {
            console.log('📁 Fermeture modale');
            $('#form-edit-direction')[0].reset();
            $('.select2-edit').val(null).trigger('change');
        });
    })();
</script>
@endpush
