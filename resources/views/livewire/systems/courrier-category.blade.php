<div class="col-lg-12">
    <div class="block-info-page">
        <h3 class="text-page">Catégories de courrier</h3>
        <p class="para-page mb-4">Gérez les différentes catégories de courrier utilisées pour classer les documents entrants et sortants.</p>
    </div>

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
                            <li><a class="dropdown-item" href="javascript:void(0)" wire:click='changeFilter(1)'>Par défaut</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0)" wire:click='changeFilter(2)'>A - Z</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0)" wire:click='changeFilter(3)'>Z - A</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0)" wire:click='changeFilter(4)'>Date d'ajout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 ms-auto d-flex align-items-center justify-content-end">
                <a href="#" class="btn btn-add" data-bs-toggle="modal" data-bs-target="#modal-new-category">
                    Ajouter
                </a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Titre</th>
                        <th scope="col">Description</th>
                        <th scope="col" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr>
                            <td class="text-truncate">{{ $category->titre }}</td>
                            <td class="text-truncate">{{ $category->description ?? 'Aucune description' }}</td>
                            <td>
                                <div class="d-flex align-items-center btns-action-table justify-content-end">
                                    <a href="#" class="btn btn-success me-2" data-bs-toggle="modal"
                                        data-bs-target="#modal-edit-category-{{ $category->id }}">
                                        <i class="fi fi-rr-pencil"></i>
                                        <span class="btn-text">Éditer</span>
                                    </a>
                                    <form action="{{ route('regidoc.categories.destroy', $category) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" 
                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')">
                                            <i class="fi fi-rr-trash"></i>
                                            <span class="btn-text">Supprimer</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">
                                <div class="py-4">
                                    <img src="{{ asset('assets/images/sad.gif') }}" alt="" width="35px">
                                    <p class="mt-2 mb-0">Aucune catégorie trouvée</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            
            @if($categories->hasPages())
                <div class="mt-4 d-flex justify-content-center">
                    {{ $categories->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Ajout -->
    <div class="modal fade" id="modal-new-category" tabindex="-1" aria-labelledby="modalNewCategory" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center" id="modalNewCategory">
                        <span>Ajouter une catégorie</span>
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
                            <div class="col-lg-12">
                                <label for="description">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" wire:model="description" rows="3"></textarea>
                                @error('description')
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
    @foreach ($categories as $category)
        <div class="modal fade" id="modal-edit-category-{{ $category->id }}" tabindex="-1"
            aria-labelledby="modalEditCategory{{ $category->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title d-flex align-items-center" id="modalEditCategory{{ $category->id }}">
                            <span>Modifier la catégorie</span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="edit({{ $category->id }})">
                            @csrf
                            <div class="form-group row g-4">
                                <div class="col-lg-12">
                                    <label for="edit_titre_{{ $category->id }}">Titre <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('titre') is-invalid @enderror"
                                        id="edit_titre_{{ $category->id }}" wire:model="titre" required>
                                    @error('titre')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-lg-12">
                                    <label for="edit_description_{{ $category->id }}">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="edit_description_{{ $category->id }}" wire:model="description" rows="3">{{ $category->description }}</textarea>
                                    @error('description')
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

@section('scripts')
    <script>
        $(document).ready(function() {
            // Gestion de la fermeture des modals
            window.livewire.on('close-modal', () => {
                $('.modal').modal('hide');
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
            });

            // Gestion de l'affichage du modal d'édition
            window.livewire.on('show-edit-modal', () => {
                $('.modal').modal('hide');
                $('#modal-edit-category-' + window.livewire.get('editingId')).modal('show');
            });

            // Réinitialiser le formulaire lorsque le modal est fermé
            $('.modal').on('hidden.bs.modal', function () {
                window.livewire.emit('resetForm');
            });
        });
    </script>
@endsection
