<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
    
    <!-- Custom styles for settings -->
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
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-50">
    <div class="global-div">
        <!-- Settings Sidebar -->
        <div class="settings-sidebar">
            <div class="settings-sidebar-header">
                <h3>Paramètres</h3>
            </div>
            @include('components.settings.sidebar')
        </div>

        <!-- Main Content -->
        <div class="settings-content">
            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            @yield('content')
        </div>
    </div>

    <!-- Scripts -->
    @include('regidoc.layouts.partials.head.scripts')
    @stack('scripts')
    
    <script>
        // Script pour gérer le menu mobile
        document.addEventListener('DOMContentLoaded', function() {
            // Ajouter ici tout script nécessaire pour la gestion du menu mobile
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
            });
            
            document.body.appendChild(menuToggle);
            
            // Fermer le menu au clic en dehors
            document.addEventListener('click', function(e) {
                const sidebar = document.querySelector('.settings-sidebar');
                if (!sidebar.contains(e.target) && e.target !== menuToggle) {
                    sidebar.classList.remove('open');
                }
            });
        });
    </script>
</body>
</html>
