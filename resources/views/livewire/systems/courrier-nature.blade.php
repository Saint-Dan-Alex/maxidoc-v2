<div class="col-lg-12">
    <div class="card card-table" style="overflow: inherit">
        <div class="d-none position-absolute loader-card d-flex justify-content-center m-0"
            style="z-index: 2; left:5px; right:5px; top:5px; bottom:5px; background-color: rgba(255,255,255,0.95)"
            wire:loading wire:target="filter, changeFilter" wire:loading.class.remove="d-none">
            <div class="text-center m-auto">
                <div class="spinner-border" role="status" style="color: var(--primaryColor)">
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
                <a href="#" class="btn btn-add" data-bs-toggle="modal" data-bs-target="#modal-new-nature">
                    Ajouter
                </a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Libellé</th>
                        <th scope="col">Description</th>
                        <th scope="col">Date de création</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($natures as $nature)
                        <tr>
                            <td>{{ $nature->libelle }}</td>
                            <td>{{ $nature->description ? Str::limit($nature->description, 50) : 'Aucune description' }}</td>
                            <td>{{ $nature->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <div class="d-flex align-items-center btns-action-table">
                                    <a href="#" class="btn btn-success me-2" data-bs-toggle="modal"
                                        data-bs-target="#modal-edit-nature-{{ $nature->id }}">
                                        <i class="fi fi-rr-pencil"></i>
                                        <span class="btn-text">Éditer</span>
                                    </a>
                                    <button type="button" class="btn btn-danger"
                                        onclick="confirm('Êtes-vous sûr de vouloir supprimer cette nature ?') || event.stopImmediatePropagation()"
                                        wire:click="delete({{ $nature->id }})">
                                        <i class="fi fi-rr-trash"></i>
                                        <span class="btn-text">Supprimer</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">
                                <div class="py-4">
                                    <img src="{{ asset('assets/images/sad.gif') }}" alt="" width="35px">
                                    <p class="mt-2 mb-0">Aucune nature trouvée</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($natures->hasPages())
            <div class="card-footer">
                {{ $natures->links() }}
            </div>
        @endif
    </div>

    <!-- Modal Ajout -->
    <div class="modal fade" id="modal-new-nature" tabindex="-1" aria-labelledby="modalNewNature" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center" id="modalNewNature">
                        <span>Ajouter une nature</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="store">
                        @csrf
                        <div class="form-group row g-4">
                            <div class="col-lg-12">
                                <label for="titre">Titre <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('titre') is-invalid @enderror"
                                    id="titre" wire:model="titre" required>
                                @error('titre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Édition -->
    @foreach ($natures as $nature)
        <div class="modal fade" id="modal-edit-nature-{{ $nature->id }}" tabindex="-1"
            aria-labelledby="modalEditNature{{ $nature->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title d-flex align-items-center" id="modalEditNature{{ $nature->id }}">
                            <span>Modifier la nature</span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="edit({{ $nature->id }})">
                            @csrf
                            <div class="form-group row g-4">
                                <div class="col-lg-12">
                                    <label for="edit_titre_{{ $nature->id }}">Titre <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('titre') is-invalid @enderror"
                                        id="edit_titre_{{ $nature->id }}" wire:model="titre" value="{{ $nature->titre }}" required>
                                    @error('titre')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-primary">Mettre à jour</button>
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
            // Fermer le modal après l'ajout ou la mise à jour
            window.livewire.on('close-modal', () => {
                $('.modal').modal('hide');
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
            });

            // Afficher le modal d'édition
            window.livewire.on('show-edit-modal', () => {
                $('.modal').modal('hide');
                $('#modal-edit-nature-' + window.livewire.get('editingId')).modal('show');
            });
        });
    </script>
@endpush
