

{{-- @if(Auth::user()->isAdmin()==2) --}}
{{-- @include('components.admin.aside') --}}
{{-- @endif

@if (Auth::user()->isPersonel()==4)
@include('components.personnel.aside')
@endif
@if (Auth::user()->isHumanRes()==3)
@include('components.humanres.aside')
@endif --}}
<div class="sidebar">

    <div class="close-menu">
        <i class="fi fi-rr-menu-burger"></i>
    </div>
    <div class="content-sidebar">
        <div class="logo">
            <a href="/">
               <div class="block-logo">
                   <img src="{{asset('assets/img/logos/logo-ads1.svg')}}" alt="">
                   <img src="{{asset('assets/img/logos/logo-ads1.svg')}}">
               </div>
               <div class="name-entreprise">
                   <h6>Name brand</h6>
                   <p>Direction générale</p>
               </div>
            </a>

        </div>
        <div class="block-links">
            <ul class="lists">
                <li>
                    <span class="tooltip-sm">
                       Courrier
                    </span>
                    <a href="{{route('courriers.shows')}}">
                       <span>
                        <i class="fi fi-rr-envelope fi-rr"></i>
                        <i class="fi fi-sr-envelope fi-sr"></i>
                       </span>
                       <span class="title">
                            Courrier
                       </span>
                    </a>
                </li>

                <li>
                    <span class="tooltip-sm">
                        Archivage
                    </span>
                    <a href="{{ route('archives') }}" class="{{ request()->is('archives/classeurs') ? 'active' : ''}}">
                       <span>
                        <i class="fi fi-rr-box fi-rr"></i>
                        <i class="fi fi-sr-box fi-sr"></i>
                       </span>
                       <span class="title">
                            Archivage
                       </span>
                    </a>
                </li>

                <li>
                    <span class="tooltip-sm">
                        Parametre
                    </span>
                    <a href="#">
                       <span>
                        <i class="fi fi-rr-settings-sliders fi-rr"></i>
                        <i class="fi fi-sr-settings-sliders fi-sr"></i>
                       </span>
                       <span class="title">
                            Parametre
                       </span>
                    </a>
                </li>
            </ul>
            <a href="#" data-bs-toggle="modal" data-bs-target="#modal-new-task">
                <div class="card card-sm pointer" data-bs-toggle="modal" data-bs-target="#modal-new-task">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#modal-new-task">
                    <div class="text-center" data-bs-toggle="modal" data-bs-target="#modal-new-task">
                        <h6>Créer une tâche</h6>
                        <a href="#" class="btn" data-bs-toggle="modal" data-bs-target="#modal-new-task" ><i class="fi fi-rr-plus"></i></a>
                    </div>
                    </a>
                </div>
            </a>
        </div>
        <img src="images/logoUjumbe.png" alt="" class="logo-app">
    </div>
</div>
