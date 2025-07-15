<div class="sidebar sidebar-mobile">
    <div class="close-menu">
        <div class="bubble"></div>
        <div class="tooltip-indicator">
            Reduire
        </div>
    </div>

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

    <div class="mb-auto content-sidebar">

        <div class="block-links ">

            <ul class="lists">
                <li class="item mb-3 ">
                    <div class="align-items-center block-search-sidebar d-lg-flex">
                        @livewire('search.search-engin')
                    </div>
                </li>

                <li class="item mb-2   d-flex justify-content-center align-items-center ">
                    <button class="sidebar-sm-btn-search">
                        <svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="m19.485 20.154l-6.262-6.262q-.75.639-1.725.989t-1.96.35q-2.402 0-4.066-1.663T3.808 9.503T5.47 5.436t4.064-1.667t4.068 1.664T15.268 9.5q0 1.042-.369 2.017t-.97 1.668l6.262 6.261zM9.539 14.23q1.99 0 3.36-1.37t1.37-3.361t-1.37-3.36t-3.36-1.37t-3.361 1.37t-1.37 3.36t1.37 3.36t3.36 1.37" />
                        </svg>
                    </button>
                </li>
                @foreach ($menuItems as $item)
                    <li class="item">
                        <a href="{{ $item->link() }}" class="{{ $item->isActive() ? 'active' : '' }} panelsession"
                            @if ($item->hasChildren()) data-bs-toggle="collapse" data-bs-target="#{{ Str::slug($item->title) }}" aria-expanded="{{ $item->isActive() ? 'true' : 'false' }}"
                                aria-controls="{{ Str::slug($item->title) }}" @endif>
                            <span>
                                <i class="{{ $item->icon_regular }}"></i>
                                <i class="{{ $item->icon_solid }}"></i>
                            </span>
                            <span class="title">
                                {{ $item->title }}
                            </span>
                            @if ($item->hasChildren())
                                <i class="fi fi-rr-angle-down arrow"></i>
                            @endif
                            <div class="tooltip-indicator">
                                {{ $item->title }}
                            </div>
                            {{-- @can('Traiter un courrier')
                                @if ($item->id == 53)
                                    <div class="notif">
                                        9+
                                    </div>
                                @endif
                            @endcan --}}
                        </a>

                        @if ($item->hasChildren())
                            <div class="collapse {{ $item->isActive() ? 'show' : '' }}"
                                id="{{ Str::slug($item->title) }}">
                                <div class="card-bod">
                                    <div class="block-drop-list">
                                        @foreach ($item->items as $child)
                                            @can($child->policy, $child)
                                                <a href="{{ $child->link() }}"
                                                    class="{{ $child->isActive() ? 'active' : '' }} panelsession">
                                                    {{ $child->title }}
                                                </a>
                                            @endcan
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="collapse-menu">
                                <div class="header-collapse">
                                    {{ $item->title }}
                                </div>
                                <ul>
                                    @foreach ($item->items as $child)
                                        <li>
                                            @can($child->policy, $child)
                                                <a href="{{ $child->link() }}"
                                                    class="{{ $child->isActive() ? 'active' : '' }} panelsession">
                                                    {{ $child->title }}
                                                </a>
                                            @endcan
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    {{-- @can('Créer un document') --}}

    {{-- <a href="#" class="link-action" data-bs-toggle="modal" data-bs-target="#modalNewDoc">
            <div class="card card-sm pointer">
                <div class="text-center">
                    <i class="fi fi-rr-plus"></i>
                    <span>
                        Créer un document
                    </span>
                </div>
            </div>
        </a> --}}
    {{-- @if (Auth::user()->agent->direction->services->first()->id != 3)
            @can('Créer un document')
                <a href="{{ route('document.creation') }}" class="link-action">
                    <div class="card card-sm pointer" >
                        <div class="text-center">
                            <i class="fi fi-rr-plus"></i>
                            <span>
                                Créer un document
                            </span>
                        </div>
                    </div> 
                </a> 
            @endcan
        @else --}}
    {{-- @can('Créer un document') --}}
    @if (!Auth::user()->agent->direction->services->pluck('id')->contains(3) || !Auth::user()->agent->IsDG())
        <a href="{{ route('regidoc.courriers.create') }}" class="link-action">
            <div class="card card-sm pointer">
                <div class="text-center">
                    <i class="fi fi-rr-"></i>
                    <span>
                        Numériser un document
                    </span>
                </div>
            </div>
            <div class="card card-mobil pointer">
                <div class="text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 16 16">
                        <path fill="currentColor"
                            d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                    </svg>
                </div>
            </div>
        </a>
    @else
        @can('Créer un document')
            {{-- <a href="{{ route('document.creation') }}" class="link-action">
                <div class="card card-sm pointer">
                    <div class="text-center d-flex justify-content-center align-items-center g-2 gap-2">
                        <i class="fi fi-rr-plus icon-plus" style="font-size: 10px;"></i>
                        <span>
                            Créer un document  
                        </span>
                    </div>
                </div>
            </a> --}}
        @endcan
    @endif
    <div class="tooltip-lg">
        Tooltip
    </div>
</div>
