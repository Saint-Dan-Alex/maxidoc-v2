<div>
    <div class="sidebar sidebar-mobile">
        <div class="content-sidebar d-flex flex-column" style="overflow: hidden">
            <div class="logo normal">
                <a href="{{ route('regidoc.home') }}">
                    <div class="block-logo">
                        <img src="{{ asset('assets/regidoc/logo.png') }}" alt="">
                        <img src="{{ asset('assets/regidoc/icon.png') }}">
                    </div>
                </a>
            </div>
            <div class="logo white d-none">
                <a href="{{ route('regidoc.home') }}">
                    <div class="block-logo">
                        <img src="{{ asset('assets/regidoc/logo-white.png') }}" alt="">
                        <img src="{{ asset('assets/regidoc/icon-white.png') }}">
                    </div>
                </a>
            </div>

            {{-- <div class="block-btn">
                <a href="{{ route('regidoc.personnels.create') }}" class="btn-add btn w-100">
                    <i class="fi fi-rr-"></i> Ajouter un employé
                </a>
            </div> --}}

            <div class="block-search">
                <form action="">
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">
                            <i class="fi fi-rr-search"></i>
                        </span>
                        <input type="text" class="form-control" placeholder="Recherche"
                            wire:model.debounce.500ms='search' wire:.ignore.self>
                    </div>
                </form>
                <ul class="nav nav-tabs nav-sm mt-3 nav-tab-users">
                    <li class="nav-item">
                        <button class="nav-link {{ $tab == 1 ? 'active' : '' }} nav-link-agent" data-bs-toggle="tab"
                            data-bs-target="#person-active" type="button" role="tab"
                            wire:click="changeTab(1)">Actifs</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link {{ $tab == 2 ? 'active' : '' }} nav-link-agent" data-bs-toggle="tab"
                            data-bs-target="#person-unactive" type="button" role="tab"
                            wire:click="changeTab(2)">Suspendus</button>
                    </li>
                </ul>
            </div>

            <div class="tab-content flex-grow-1" id="myTabContent" style="overflow-y: auto; scrollbar-width: thin;"
                wire:ignore.self>

                <div class="tab-pane fade {{ $tab == 1 ? 'show active' : '' }} " id="person-active" role="tabpanel"
                    aria-labelledby="home-tab" wire:ignore.self>
                    <div class="block-personnels">
                        <ul class="nav nav-tabs all-person pb-0" id="list-contact" wire:ignore.self>
                            @forelse ($actifAgents ?? [] as $actifAgent)
                                <li class="nav-item">
                                    <button class="nav-link click link-user-tab"
                                        wire:click="showUser({{ $actifAgent->id }})">
                                        <div class="block-detail-person d-flex align-items-center w-100">
                                            <div class="avatar-person">
                                                <img src="{{ imageOrDefault($actifAgent?->image) }}"
                                                    alt="photo profil">
                                            </div>
                                            <div class="name-person">
                                                <h6>{{ $actifAgent?->prenom . ' ' . $actifAgent?->nom }}</h6>
                                                <p>{{ $actifAgent?->poste?->titre }}</p>
                                            </div>
                                            @if (Auth::user()->agent->id == $actifAgent?->id)
                                                <small class="badge bg-info ms-3" style="font-size:8px">Vous</small>
                                            @endif
                                        </div>
                                    </button>
                                </li>
                            @empty
                            @endforelse
                        </ul>
                    </div>
                    {!! $actifAgents->links() !!}
                </div>

                <div class="tab-pane fade {{ $tab == 2 ? 'show active' : '' }}" id="person-unactive" role="tabpanel"
                    aria-labelledby="profile-tab" wire:ignore.self>
                    <div class="block-personnels">
                        <ul class="nav nav-tabs all-person" id="list-contact" wire:ignore.self>
                            @forelse ($inactifAgents ?? [] as $inactifAgent)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link click" wire:click="showUser({{ $inactifAgent->id }})">
                                        <div class="block-detail-person d-flex align-items-center w-100">
                                            <div class="avatar-person">
                                                <img src="{{ imageOrDefault($inactifAgent?->image) }}"
                                                    alt="photo profil">
                                            </div>
                                            <div class="name-person">
                                                <h6>{{ $inactifAgent?->prenom . ' ' . $inactifAgent?->nom }}</h6>
                                                <p>{{ $inactifAgent?->poste?->titre }}</p>
                                            </div>
                                            @if (Auth::user()->agent->id == $inactifAgent?->id)
                                                <small class="badge bg-info ms-3" style="font-size:8px">Vous</small>
                                            @endif
                                        </div>
                                    </button>
                                </li>
                            @empty
                            @endforelse
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="container-fluid px-lg-2">

        {{-- <div class="d-flex   align-items-center mb-lg-3 mb-2">
            <a href="{{ route('regidoc.home') }}" class="back mb-0">
                <i class="fi fi-rr-angle-left"></i>
                <div class="tooltip-indicator">
                    Retour
                </div>
            </a>
            <h1 class=" ms-2 mb-0" style="flex: 0 0 auto;">Création d'un Agent </h1>

            <button class="btn btn-list btn-list-agent d-flex d-lg-none">Liste des agents</button>
        </div> --}}

        <div class="tab-content" id="myTabContent" wire:ignore.self>

            <div class="tab-pane fade show active" id="block-details-person" role="tabpanel" aria-labelledby="home-tab"
                wire:ignore.self>
                <div class="row g-lg-2 g-2">
                    <div class="m-2 d-none position-absolute loader-card d-flex justify-content-center"
                        style="z-index: 2; height:98%; width:100%; background-color: rgba(244,245,252,0.99)"
                        wire:loading wire:target="showUser,archiveAgent" wire:loading.class.remove="d-none">
                        <div class="m-auto text-center">
                            <div class="spinner-border" role="status" style="color: var(--primaryColor)">
                                <span class="sr-only"></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card card-lg">

                            <div class="card card-lg">
                                <div class="text-star d-flex align-items-center g-2 gap-2">
                                    <a href="/ressources-humaines/personnels" class="back mb-0">
                                        <i class="fi fi-rr-angle-left"></i>
                                        <div class="tooltip-indicator">
                                            Retour
                                        </div>
                                    </a>
                                    <h1> Création d'un Agent</h1>

                                </div>
                                <div class="block-circle">
                                    <div class="circle-white"></div>
                                    <div class="circle-white"></div>
                                    <div class="circle-white"></div>
                                </div>
                            </div>
                            <div class="container-fluid px-lg-3 block-top-margin">


                                <div class="mt-3 row g-lg-3">
                                    <div class="col-lg-12">
                                        @livewire('admin.agents.create-personnel-form')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('components.admin.modals.personals', ['divisions' => $divisions, 'fonctions' => $fonctions])
</div>

@section('scripts')
    <script>
        $('document').ready(function() {

            $('.permission-group').on('change', function() {
                var parentChecked = this.checked;
                var input = $(this).siblings('ul').find("input[type='checkbox']");
                input.prop('checked', parentChecked);
            });

            $('.save-permission').on('click', function() {
                var input = $('.permission-group').siblings('ul').find("input[type='checkbox']");
                input.each(function() {
                    if (this.checked) {
                        @this.call('selectPermission', $(this).val())
                    }
                });
                @this.call('changePermission')

            });

            $('.permission-select-all').on('click', function() {
                $('ul.permissions').find("input[type='checkbox']").prop('checked', true);
                return false;
            });

            $('.permission-deselect-all').on('click', function() {
                $('ul.permissions').find("input[type='checkbox']").prop('checked', false);
                return false;
            });

            function parentChecked() {
                $('.permission-group').each(function() {
                    var allChecked = true;
                    $(this).siblings('ul').find("input[type='checkbox']").each(function() {
                        if (!this.checked) allChecked = false;
                    });
                    $(this).prop('checked', allChecked);
                });
            }

            parentChecked();

            $('.the-permission').on('change', function() {
                parentChecked();
            });

            livewire.on('tab2Change', function() {
                parentChecked();
            });

            $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function(event) {
                parentChecked();
            })

        });
        $('.link-user-tab').click(function() {
            $('.link-user-tab').removeClass('active')
            $(this).addClass('active')
        })

        // const nvImg_profil = document.querySelector('.file-img-profil');
        // var nsr = document.getElementById('img_profil');
        // // console.log(nvImg_profil);
        // nvImg_profil.addEventListener('change', function() {
        //     const fichier_img = this.files[0];
        //     if (fichier_img) {
        //         const analyseur_file = new FileReader();
        //         analyseur_file.readAsDataURL(fichier_img);
        //         analyseur_file.addEventListener('load', function() {
        //             nsr.setAttribute('src', this.result);
        //             $(nsr).addClass('fade')
        //             $("#label-2").addClass('active')
        //         })
        //     }
        //     setTimeout(() => {
        //         $(nsr).removeClass('fade')
        //     }, 3000);
        // })
    </script>

    <script>
        // Livewire.on('userShown', function () {
        //     $('.select2').select2({
        //         tags: $(this).data('tags') ? $(this).data('tags') : false,
        //         placeholder: $(this).data('placeholder'),
        //         language: "fr",
        //         width: '100%',
        //         maximumSelectionLength: $(this).data('max-selection') ? $(this).data('max-selection') : null,
        //     })
        // })

        $('select[name=lieu_id]').on('change', function(e) {
            livewire.emit('changeLieu', e.target.value);
        });

        $('select[name=direction_id]').on('change', function(e) {
            livewire.emit('changeDirection', e.target.value);
        });

        $('select[name=division_id]').on('change', function(e) {
            livewire.emit('changeDivision', e.target.value);
        });

        $('select[name=sevice_id]').on('change', function(e) {
            // console.log(e);
            livewire.emit('changeService', e.target.value);
        });

        $('select[name=section_id]').on('change', function(e) {
            livewire.emit('changeSection', e.target.value);
        });

        window.livewire.on('select2', () => {
            $('.select2').each(function() {
                var old = $('.select2-container.select2-container--default.select2-container--open');
                if (old.length > 0) {
                    // console.log(old);
                    old.remove();
                }

                $(this).select2({
                    width: '100%',
                    placeholder: 'Selectionnez'
                });
                // $(this).on('select2:open', event =>
                //     setTimeout(() =>
                //         $(event.target).data('select2').dropdown.$search.get(0).focus(), 10
                //     )
                // );
            });

            $('select[name=fonction_id]').select2({
                tags: true,
                placeholder: 'Selectionnez',
                language: "fr",
                createTag: function(params) {
                    var term = $.trim(params.term);

                    if (term === '') {
                        return null;
                    }

                    return {
                        id: term,
                        text: term,
                        newTag: true
                    }
                },
                width: '100%',
                maximumSelectionLength: 1,
            })

            $('select[name=fonction_id]').on('select2:select', function(e) {
                var data = e.params.data;

                if (data.id == '') {
                    // "None" was selected. Clear all selected options
                    $(this).val([]).trigger('change');
                } else {
                    $(e.currentTarget).find("option[value='" + data.id + "']").attr('selected', 'selected');
                }
            });

            $('select[name=fonction_id]').on('select2:unselect', function(e) {
                var data = e.params.data;
                $(e.currentTarget).find("option[value='" + data.id + "']").attr('selected', false);
            });

            $('select[name=fonction_id]').on('select2:selecting', function(e) {
                var $el = $(this);
                // var route = $el.data('route');
                // var label = $el.data('label');
                // var relativeId = $el.data('relative-id');
                // var errorMessage = $el.data('error-message');
                var newTag = e.params.args.data.newTag;

                if (!newTag) return;

                $el.select2('close');

                @this.saveFonction(e.params.args.data.text)

                return false;
            });

        });

        $('select[name=grade_id]').on('change', function(e) {
            livewire.emit('changeGrade', e.target.value);
        });


        $('.btn-switch input').on('change', function() {
            $('.btn-switch').toggleClass('active')
        })
    </script>
@endsection

<script>
    // Initialisation des tooltips Bootstrap
    document.addEventListener('DOMContentLoaded', function() {
        const tooltipTrigger = document.getElementById('tooltip-svg');
        const tooltip = new bootstrap.Tooltip(tooltipTrigger);

        // Ajouter un événement pour cacher le tooltip au clic
        tooltipTrigger.addEventListener('click', function() {
            tooltip.hide(); // Cache le tooltip
        });
    });
</script>
