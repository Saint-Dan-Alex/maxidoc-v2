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

                <li class="item mb-2  d-flex justify-content-center align-items-center ">
                    <button class="sidebar-sm-btn-search">
                        <svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="m19.485 20.154l-6.262-6.262q-.75.639-1.725.989t-1.96.35q-2.402 0-4.066-1.663T3.808 9.503T5.47 5.436t4.064-1.667t4.068 1.664T15.268 9.5q0 1.042-.369 2.017t-.97 1.668l6.262 6.261zM9.539 14.23q1.99 0 3.36-1.37t1.37-3.361t-1.37-3.36t-3.36-1.37t-3.361 1.37t-1.37 3.36t1.37 3.36t3.36 1.37" />
                        </svg>
                    </button>
                </li>
                @foreach ($menuItems as $item)
                    <li class="item">
                        @if ($item->id == 40) {{-- Paramètres --}}
                            <a href="{{ route('regidoc.settings') }}"
                                class="{{ request()->routeIs('regidoc.settings*') ? 'active' : '' }} panelsession">
                                <span>
                                    <i class="{{ $item->icon_regular }}"></i>
                                    <i class="{{ $item->icon_solid }}"></i>
                                </span>
                                <span class="title">
                                    {{ $item->title }}
                                    @livewire('sidebar.badge', ['label' => $item->title])
                                </span>
                                <div class="tooltip-indicator">
                                    {{ $item->title }}
                                </div>
                            </a>
                            {{-- Lien Logs d’activités juste après Paramètres --}}
                            <a href="{{ route('regidoc.logs.auth.index') }}" class="{{ request()->routeIs('regidoc.logs.auth.*') ? 'active' : '' }} panelsession">
                                <span>
                                    <i class="fi fi-rr-activity"></i>
                                    <i class="fi fi-sr-activity"></i>
                                </span>
                                <span class="title">Logs d’activités</span>
                                <div class="tooltip-indicator">Logs d’activités</div>
                            </a>
                        @else
                            <a href="{{ $item->link() }}" class="{{ $item->isActive() ? 'active' : '' }} panelsession"
                                @if ($item->hasChildren() && $item->id != 40)
                                    data-bs-toggle="collapse" data-bs-target="#{{ Str::slug($item->title) }}"
                                    aria-expanded="{{ $item->isActive() ? 'true' : 'false' }}"
                                    aria-controls="{{ Str::slug($item->title) }}"
                                @endif>
                                <span>
                                    <i class="{{ $item->icon_regular }}"></i>
                                    <i class="{{ $item->icon_solid }}"></i>
                                </span>
                                <span class="title">
                                    {{ $item->title }}
                                    @livewire('sidebar.badge', ['label' => $item->title])
                                </span>
                                @if ($item->hasChildren() && $item->id != 40)
                                    <i class="fi fi-rr-angle-down arrow"></i>
                                @endif
                                <div class="tooltip-indicator">
                                    {{ $item->title }}
                                </div>
                            </a>
                        @endif

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
                                                    @livewire('sidebar.badge', ['label' => $child->title])
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
                                                    @livewire('sidebar.badge', ['label' => $child->title])
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
    @php
        $user = Auth::user();
        $showButton = true;
        
        // Vérifier si l'utilisateur est le super admin (ID = 1)
        if ($user->id === 1) {
            $showButton = true;
        } 
        // Vérifier si l'utilisateur a un agent avec une direction
        elseif ($user->agent && $user->agent->direction) {
            $showButton = !$user->agent->direction->services->pluck('id')->contains(3) || !$user->agent->IsDG();
        }
        // Pour les autres cas (pas d'agent ou agent sans direction)
        else {
            $showButton = false;
        }
    @endphp
    
    @if ($showButton)
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
        @endcan
    @endif
    <div class="tooltip-lg">
        Tooltip
    </div>
</div>