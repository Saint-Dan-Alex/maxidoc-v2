<div class="position-lg-relative search-lg-nav" wire:ignore.self>
    <div class="icon">
        <i class="fi fi-rr-search"></i>
    </div>
    <input type="text" class="form-control"
        placeholder="Rechercher un document"
        wire:model="query"
        wire:keydown.escape="resetAll"
        wire:keydown.tab="resetAll"
        wire:focusout="resetAll"
        wire:keydown.arrow-up="decrementHighlight"
        wire:keydown.arrow-down="incrementHighlight"
        wire:keydown.enter="selectContact" />

    <div wire:loading.class.remove="d-none" class="d-none position-absolute block-spiner">
        <span></span>
    </div>
    <div class="close-search-nav d-flex d-lg-none position-absolute">
        <i class="fi fi-rr-cross"></i>
    </div>
    @if (!empty($query))
        <div class="fixed top-0 bottom-0 left-0 right-0" wire:click="reset"></div>

        <div class="position-absolute z-10 w-full bg-white rounded-t-none shadow-lg list-group">
            {{-- <h6 style="font-size: 15px; font-weight: 600; color: var(--primaryColor)" class="mb-3">Resultats</h6> --}}
            @if (!empty($results))
                <div class="block-result">
                    @foreach ($results as $i => $result)
                        <a href="{{ $result['url'] }}"
                            class="list-group-item d-flex justify-content-between align-items-center {{ $highlightIndex === $i ? 'bg-primary' : '' }}">
                            <div class="block-text">
                                <span>{{ $result['title'] }}</span>
                            </div>
                            <span class="badge bg-light">{{ $result['categorie'] }}</span>
                        </a>
                    @endforeach
                </div>
                <a href="" class="btn mt-3">Recherche avancée</a>
            @else
                <div class="list-group-item text-center">
                    <img src="{{ asset('assets/images/sad.gif') }}" alt="" width="35px" class="">
                    <br>
                    Pas de resultat!
                </div>
            @endif
        </div>
    @endif
</div>
