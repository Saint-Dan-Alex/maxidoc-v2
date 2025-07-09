<div class="@if ($annoteCount > 0) col-lg-3 border-start vignette-column @endif">
    @if ($annoteCount > 0)
        <div class="position-sticky sticky-top all-annot d-flex flex-column" style="height: calc(100vh - 71px); top:65px; padding-bottom: 20px; overflow:hidden">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 style="color: var(--colorTitre); font-size: 16px; font-family: 'Roboto-regular' !important" class="mb-0">
                    Annotations
                </h5>
                <div class="close-parent d-sm-none d-flex">
                    <i class="fi fi-rr-cross"></i>
                </div>
            </div>
            {{-- <a href="#" class="" wire:click="$emit('addAnnotation')">
                <div class="card card-sm pointer">
                    <div class="text-center">
                        <i class="fi fi-rr-plus"></i>
                        <span>
                            Ajouter une annotation
                        </span>
                    </div>
                </div>
            </a> --}}
            <div class="block-anotation d-flex flex-column flex-grow-1 g-3" style="overflow-y:auto;">
                @foreach ($courrier->annotations->sortByDesc('id') as $annotation)
                    <div class="item-anotation position-relative">
                        @if ($annotation->is_done)
                            <div class="position-absolute bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="right: 5px; top: 5px; font-size:12px; width: 24px; height:24px;" title="Traité">
                                <i class="fi fi-rr-check"></i>
                            </div>
                        @else
                            <div class="dropdown position-absolute" style="right: 5px; top: 5px;">
                                <button class="btn p-0 d-flex align-items-center justify-content-center" id="dropdownMenuButton1"
                                    data-bs-toggle="dropdown" aria-expanded="true"
                                    style="font-size: 14px; width: 28px; height: 28px">
                                    <i class="fi fi-rr-menu-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1"
                                    data-popper-placement="bottom-end">
                                    @if ($annotation->user_id != Auth::user()->id)
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0)" wire:click='markAsDone({{ $annotation->id }})'>
                                                <i class="fi fi-rr-check"></i> Marquer comme effectuée
                                            </a>
                                        </li>
                                    @endif
                                    @if ($annotation->user_id == Auth::user()->id)
                                        <li class="border-top my-1"></li>
                                        <li> 
                                            <a class="dropdown-item" href="javascript:void(0)" wire:click="$emit('editAnnotation', {{ $annotation->id }})">
                                                <i class="fi fi-rr-edit"></i> Modifier
                                            </a>
                                            
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0)" wire:click='deleteAnnotation({{ $annotation->id }})'>
                                                <i class="fi fi-rr-trash"></i>Supprimer
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        @endif

                        <div class="d-flex info-user-an mb-2">
                            <div class="avatar">
                                <img src="{{ imageOrDefault(\App\Models\User::find($annotation->user_id)->agent->image) }}" alt="image profil">
                            </div>
                            <div class="content-name">
                                <h6>
                                    {{ \App\Models\User::find($annotation->user_id)->agent->prenom }} {{ \App\Models\User::find($annotation->user_id)->agent->nom }}
                                    <span class="text-muted">
                                        - {{ \App\Models\User::find($annotation->user_id)->agent->poste?->titre }}
                                    </span>
                                </h6>
                                <div class="date">
                                    {{ $annotation->created_at->format('d/m/Y') }}
                                </div>
                            </div>
                        </div>
                        <div class="content-anotation">
                            <p>
                                {!! $annotation->note !!}
                            </p>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    @endif
</div>

@push('livewireScripts')
    <script>
        var count = @js($annoteCount);

        if (count > 0) {
            $('.show-vignette').parent().removeClass('d-none');
        }else{
            $('.show-vignette').parent().addClass('d-none');
        }
    </script>
@endpush
