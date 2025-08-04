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
            padding: 0.75rem 1.5rem;
            color: #4a5568;
            text-decoration: none;
            transition: all 0.2s;
            border-radius: 0.375rem;
            margin-bottom: 0.25rem;
        }
        
        .settings-nav-item:hover {
            background-color: #f7fafc;
            color: #1a56db;
        }
        
        .settings-nav-item.active {
            background-color: #ebf4ff;
            color: #1a56db;
            font-weight: 500;
        }
        
        .settings-nav-item i {
            margin-right: 0.75rem;
            width: 1.25rem;
            text-align: center;
        }
        
        .settings-sidebar {
            width: 280px;
            background: white;
            border-right: 1px solid #e2e8f0;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            overflow-y: auto;
            padding: 1.5rem 0;
        }
        
        .settings-content {
            margin-left: 280px;
            padding: 2rem;
            min-height: 100vh;
            background-color: #f8fafc;
        }
        
        @media (max-width: 1024px) {
            .settings-sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease-in-out;
                z-index: 40;
            }
            
            .settings-sidebar.open {
                transform: translateX(0);
            }
            
            .settings-content {
                margin-left: 0;
                padding: 1rem;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-50">
    <div class="flex h-screen">
        <!-- Settings Sidebar -->
        <div class="settings-sidebar">
            @include('components.settings.sidebar')
        </div>

        <!-- Main Content -->
        <div class="settings-content flex-1 overflow-auto">
            @if (session('status'))
                <div class="p-4 mb-6 text-sm text-green-700 bg-green-100 rounded-lg">
                    {{ session('status') }}
                </div>
            @endif
            
            @yield('content')
        </div>
    </div>

    <!-- Scripts -->
    @include('regidoc.layouts.partials.head.scripts')
    @stack('scripts')
    
    <script>
        // Script pour gérer le menu mobile si nécessaire
        document.addEventListener('DOMContentLoaded', function() {
            // Ajouter ici tout script nécessaire pour la gestion du menu mobile
        });
    </script>
</body>
</html>
