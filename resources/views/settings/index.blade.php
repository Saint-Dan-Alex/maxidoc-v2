@extends('layouts.app-settings')

@section('content')
<div class="settings-dashboard">
    <div class="settings-header">
        <h1 class="settings-title">
            <i class="fi fi-rr-settings mr-2"></i>
            {{ __('Tableau de bord des paramètres') }}
        </h1>
        <p class="settings-subtitle">
            {{ __('Gérez les différents paramètres de votre application') }}
        </p>
    </div>

    <div class="settings-grid">
        @foreach($menuItems as $item)
            <a href="{{ $item->url }}" class="settings-card">
                <div class="settings-card-icon">
                    <i class="{{ $item->icon_regular }}"></i>
                </div>
                <div class="settings-card-content">
                    <h3 class="settings-card-title">
                        {{ $item->title }}
                    </h3>
                    <p class="settings-card-description">
                        {{ $item->description ?? 'Gérer les ' . strtolower($item->title) }}
                    </p>
                </div>
                <div class="settings-card-arrow">
                    <i class="fi fi-rr-angle-right"></i>
                </div>
            </a>
        @endforeach
    </div>
</div>

<style>
    .settings-dashboard {
        max-width: 1200px;
        margin: 0 auto;
    }
    
    .settings-header {
        margin-bottom: 30px;
        padding-bottom: 15px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .settings-title {
        color: var(--colorTitre);
        font-size: 24px;
        font-weight: 600;
        margin: 0 0 10px 0;
        display: flex;
        align-items: center;
    }
    
    .settings-title i {
        font-size: 22px;
        margin-right: 10px;
        color: var(--primaryColor);
    }
    
    .settings-subtitle {
        color: var(--colorParagraph);
        font-size: 14px;
        margin: 0;
        opacity: 0.8;
    }
    
    .settings-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }
    
    .settings-card {
        background: var(--bg-card);
        border-radius: 10px;
        padding: 20px;
        display: flex;
        align-items: flex-start;
        transition: all 0.3s ease;
        border: 1px solid rgba(0, 0, 0, 0.05);
        text-decoration: none;
        position: relative;
        overflow: hidden;
    }
    
    .settings-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        border-color: var(--primaryColor);
    }
    
    .settings-card-icon {
        width: 50px;
        height: 50px;
        background: var(--lightBlue);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        flex-shrink: 0;
    }
    
    .settings-card-icon i {
        font-size: 22px;
        color: var(--primaryColor);
    }
    
    .settings-card-content {
        flex: 1;
    }
    
    .settings-card-title {
        color: var(--colorTitre);
        font-size: 15px;
        font-weight: 600;
        margin: 0 0 5px 0;
    }
    
    .settings-card-description {
        color: var(--colorParagraph);
        font-size: 13px;
        margin: 0;
        opacity: 0.8;
        line-height: 1.4;
    }
    
    .settings-card-arrow {
        color: var(--colorParagraph);
        opacity: 0.3;
        transition: all 0.3s ease;
        margin-left: 10px;
        display: flex;
        align-items: center;
    }
    
    .settings-card:hover .settings-card-arrow {
        opacity: 1;
        color: var(--primaryColor);
        transform: translateX(3px);
    }
    
    @media (max-width: 1024px) {
        .settings-grid {
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 15px;
        }
    }
    
    @media (max-width: 768px) {
        .settings-grid {
            grid-template-columns: 1fr;
        }
        
        .settings-header {
            margin-bottom: 20px;
        }
        
        .settings-title {
            font-size: 20px;
        }
    }
</style>
@endsection
