<!Doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<!--
    # Project developed by Newtech Consulting SARL
    # Contact : Tél: +(243) 977 776 901
                Email: contact@newtech-rdc.net
                Adresse: 374 avenue Colonel Mondjiba C/Ngaliema, Q/Basoko, Réf/Galerie St.Pierre
                Kinshasa - RDC
-->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MaxiDoc | Paramètres</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/regidoc/icon.ico') }}" type="image/x-icon">
    
    <!-- Styles -->
    @include('regidoc.layouts.partials.head.styles')
    @yield('styles')
    @livewireStyles()
    @livewireScripts()
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">

    
    
    
    
    
    <style>
        .settings-nav-item {
            display: flex;
            align-items: center;
            padding: 10px 20px;
            color: var(--colorParagraph);
            text-decoration: none;
            transition: all 0.3s ease;
            border-radius: 8px;
            margin-bottom: 5px;
            font-size: 14px;
            font-weight: 400;
        }
        
        .settings-nav-item:hover {
            background-color: var(--lightBlue);
            color: var(--primaryColor);
        }
        
        .settings-nav-item.active {
            background-color: var(--lightBlue);
            color: var(--primaryColor);
            font-weight: 500;
        }
        
        .settings-nav-item i {
            margin-right: 12px;
            width: 20px;
            text-align: center;
            color: inherit;
        }
        
        .settings-sidebar {
            width: 280px;
            background: var(--bg-card);
            border-right: 1px solid rgba(0, 0, 0, 0.05);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            overflow-y: auto;
            padding: 20px 0;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.03);
            z-index: 100;
        }
        
        .settings-sidebar-header {
            padding: 0 20px 15px;
            margin-bottom: 15px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .settings-sidebar-header h3 {
            color: var(--colorTitre);
            font-size: 18px;
            font-weight: 600;
            margin: 0;
        }
        
        .settings-content {
            margin-left: 280px;
            padding: 30px;
            min-height: 100vh;
            background-color: var(--bgContent);
            transition: margin 0.3s ease;
        }
        
        .settings-card {
            background: var(--bg-card);
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
            padding: 25px;
            margin-bottom: 25px;
        }
        
        .settings-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .settings-card-title {
            color: var(--colorTitre);
            font-size: 18px;
            font-weight: 600;
            margin: 0;
        }
        
        @media (max-width: 1024px) {
            .settings-sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease-in-out;
                z-index: 1000;
                width: 280px;
            }
            
            .settings-sidebar.open {
                transform: translateX(0);
                box-shadow: 5px 0 25px rgba(0, 0, 0, 0.1);
            }
            
            .settings-content {
                margin-left: 0;
                padding: 20px 15px;
            }
            
            .settings-card {
                padding: 20px 15px;
            }
            #responsable_list, #adjoint_list {
                max-height: 200px;
                overflow-y: auto;
                background: white;
                border: 1px solid #ddd;
                border-radius: 0 0 4px 4px;
                display: none;
            }

        }
    </style>
</head>

<body>
    <div class="global-div">
        <!-- Navbar Horizontale -->
        <nav class="navbar navbar-expand-lg fixed-top">
            <div class="container-fluid px-lg-4">
                <div class="row w-100 ms-0">
                    <div class="col-lg-6 col-4 col-sm-6 ps-0">
                        <div class="d-flex align-items-center">
                            <div class="logo-header">
                                <a href="/">
                                    <div class="block-logo">
                                        <img src="{{ asset('assets/regidoc/icon.png') }}" class="theme-light-show">
                                        <img src="{{ asset('assets/regidoc/icon-white.png') }}" class="theme-dark-show">
                                        <img src="{{ asset('assets/regidoc/logo.png') }}" alt="Maxidoc" style="height: 40px; margin-left: 10px;">
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-8 col-sm-6 pe-0">
                        <div class="d-flex ms-auto align-items-center justify-content-end">
                            <!-- Ici vous pouvez ajouter d'autres éléments de navigation si nécessaire -->
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        
        <!-- Settings Sidebar -->
        <div class="settings-sidebar" style="top: 70px; height: calc(100vh - 70px);">
            <div class="settings-sidebar-header">
                <h3>Paramètres</h3>
            </div>
            @include('components.settings.sidebar')
        </div>

        <!-- Main Content -->
        <div class="settings-content">
            @include('regidoc.layouts.partials.header.navbar')
            
            <div class="content">
                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                @yield('content')
            </div>
            
            @include('regidoc.layouts.partials.footer.footer')
        </div>
        
        <div class="backdropFilter"></div>
    </div>
    @if (session()->has('session'))
        @if (json_decode(session()->get('session'))->statut == 'success')
            <div class="message-flash success">
                <div class="content-text d-flex justify-content-center  gap-2">
                    <div class="content-text-imageBox d-flex justify-content-center align-items-center">
                        <img src="{{ asset('assets/images/icons/iconvert-maxidoc.svg') }}" alt="icon success">
                    </div>
                    <div class="text-star">
                        <h6>{{ json_decode(session()->get('session'))->name }}</h6>
                        <p>{{ json_decode(session()->get('session'))->message }}</p>
                    </div>
                </div>
            </div>
        @elseif(json_decode(session()->get('session'))->statut == 'warnig')
            <div class="message-flash warning">
                <div class="content-text d-flex justify-content-center  gap-2">
                    <div class="content-text-imageBox d-flex justify-content-center align-items-center">
                        <img src="{{ asset('assets/images/icons/iconorange-maxidoc.svg') }}" alt="icon warning">
                    </div>
                    <div class="text-star">
                        <h6>{{ json_decode(session()->get('session'))->name }}</h6>
                        <p>{{ json_decode(session()->get('session'))->message }}</p>
                    </div>
                </div>
            </div>
        @elseif(json_decode(session()->get('session'))->statut == 'error')
            <div class="message-flash error">
                <div class="content-text d-flex justify-content-center  gap-2">
                    <div class="content-text-imageBox d-flex justify-content-center align-items-center">
                        <img src="{{ asset('assets/images/icons/error-icon.png') }}" alt="icon error">
                    </div>
                    <div class="text-star">
                        <h6>{{ json_decode(session()->get('session'))->name }}</h6>
                        <p>{{ json_decode(session()->get('session'))->message }}</p>
                    </div>
                </div>
            </div>
        @endif
        @php
            Session::forget('session');
        @endphp
    @endif

    @if ($errors->any())
        <div class="message-flash error">
            <div class="content-text d-flex">
                <div class="icon">
                    <i data-feather="x-circle"></i>
                </div>
                <div class="text-star">
                    <h6>{{ __('Whoops! Something went wrong.') }}</h6>
                    <ul class="mt-3 list-unstyled error-list">
                        @foreach ($errors->all() as $error)
                            <li class="text-danger">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    @livewire('livewire-alert')

    <!-- Scripts -->
    @include('regidoc.layouts.partials.head.scripts')
    @stack('scripts')
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu toggle
            const menuToggle = document.createElement('button');
            menuToggle.className = 'btn btn-sm btn-primary d-lg-none position-fixed';
            menuToggle.style.bottom = '20px';
            menuToggle.style.right = '20px';
            menuToggle.style.zIndex = '1000';
            menuToggle.style.borderRadius = '50%';
            menuToggle.style.width = '50px';
            menuToggle.style.height = '50px';
            menuToggle.style.display = 'flex';
            menuToggle.style.alignItems = 'center';
            menuToggle.style.justifyContent = 'center';
            menuToggle.innerHTML = '<i class="fi fi-rr-menu-burger"></i>';
            
            menuToggle.addEventListener('click', function() {
                document.querySelector('.settings-sidebar').classList.toggle('open');
                document.querySelector('.backdropFilter').classList.toggle('show');
                document.body.classList.toggle('overflow-hidden');
            });
            
            document.body.appendChild(menuToggle);
            
            // Close sidebar when clicking outside
            document.addEventListener('click', function(e) {
                const sidebar = document.querySelector('.settings-sidebar');
                const backdrop = document.querySelector('.backdropFilter');
                if (!sidebar.contains(e.target) && e.target !== menuToggle) {
                    sidebar.classList.remove('open');
                    backdrop.classList.remove('show');
                    document.body.classList.remove('overflow-hidden');
                }
            });
            
            // Close sidebar when clicking on backdrop
            document.querySelector('.backdropFilter').addEventListener('click', function() {
                document.querySelector('.settings-sidebar').classList.remove('open');
                this.classList.remove('show');
                document.body.classList.remove('overflow-hidden');
            });
            
            // Add active class to current nav item
            const currentPath = window.location.pathname;
            document.querySelectorAll('.settings-nav-item').forEach(item => {
                if (item.getAttribute('href') === currentPath) {
                    item.classList.add('active');
                }
            });
        });
    </script>
    
    @if ($errors->any())
        <div class="message-flash error">
            <div class="content-text d-flex">
                <div class="icon">
                    <i data-feather="x-circle"></i>
                </div>
                <div class="content">
                    <h6>Erreur</h6>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <button class="btn-close"><i data-feather="x"></i></button>
        </div>
    @endif
    
    @if(session('success'))
        <div class="message-flash success">
            <div class="content-text d-flex">
                <div class="icon">
                    <i data-feather="check-circle"></i>
                </div>
                <div class="content">
                    <h6>Succès</h6>
                    <p class="mb-0">{{ session('success') }}</p>
                </div>
            </div>
            <button class="btn-close"><i data-feather="x"></i></button>
        </div>
    @endif
    
    <script>
        // Close flash messages
        document.querySelectorAll('.message-flash .btn-close').forEach(button => {
            button.addEventListener('click', function() {
                this.closest('.message-flash').classList.add('fadeOut');
                setTimeout(() => {
                    this.closest('.message-flash').remove();
                }, 300);
            });
        });
        
        // Auto-hide flash messages after 5 seconds
        setTimeout(() => {
            document.querySelectorAll('.message-flash').forEach(flash => {
                flash.classList.add('fadeOut');
                setTimeout(() => {
                    flash.remove();
                }, 300);
            });
        }, 5000);
    </script>
</body>
</html>
