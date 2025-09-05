@php
    use App\Models\MenuItem;
    
    $currentRoute = request()->route()->getName();
    $menuItems = MenuItem::where('parent_id', 40)
        ->orderBy('order')
        ->get()
        ->filter(fn($item) => auth()->user()->can($item->policy));
    
    // Grouper les éléments par catégorie si nécessaire
    $groupedItems = $menuItems->groupBy('category');
    $hasCategories = $groupedItems->count() > 1;
@endphp


<nav class="settings-nav">
    @if($hasCategories)
        @foreach($groupedItems as $category => $items)
            <div class="settings-category">
                <div class="settings-category-title">
                    {{ $category }}
                </div>
                <div class="settings-category-items">
                    @foreach($items as $item)
                        <a href="{{ route($item->route) }}" 
                           class="settings-nav-item {{ request()->routeIs($item->route) ? 'active' : '' }}"
                           @if(isset($item->description)) 
                               data-bs-toggle="tooltip" 
                               data-bs-placement="right" 
                               title="{{ $item->description }}"
                           @endif>
                            <i class="{{ $item->icon_regular }}"></i>
                            <span>{{ $item->title }}</span>
                            @if(isset($item->badge))
                                <span class="badge bg-primary float-end">{{ $item->badge }}</span>
                            @endif
                        </a>
                    @endforeach
                </div>
            </div>
        @endforeach
    @else
        @foreach($menuItems as $item)
            <a href="{{ route($item->route) }}" 
               class="settings-nav-item {{ request()->routeIs($item->route) ? 'active' : '' }}"
               @if(isset($item->description)) 
                   data-bs-toggle="tooltip" 
                   data-bs-placement="right" 
                   title="{{ $item->description }}"
               @endif>
                <i class="{{ $item->icon_regular }}"></i>
                <span>{{ $item->title }}</span>
                @if(isset($item->badge))
                    <span class="badge bg-primary float-end">{{ $item->badge }}</span>
                @endif
            </a>
        @endforeach
    @endif
</nav>

<style>
    .settings-nav {
        padding: 0 10px;
    }
    
    .settings-category {
        margin-bottom: 20px;
    }
    
    .settings-category:last-child {
        margin-bottom: 0;
    }
    
    .settings-category-title {
        padding: 0 10px 8px;
        margin-bottom: 8px;
        color: var(--colorParagraph);
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        opacity: 0.7;
    }
    
    .settings-nav-item {
        position: relative;
        display: flex;
        align-items: center;
        padding: 10px 15px;
        color: var(--colorParagraph);
        text-decoration: none;
        transition: all 0.3s ease;
        border-radius: 8px;
        margin-bottom: 4px;
        font-size: 14px;
        font-weight: 400;
    }
    
    .settings-nav-item i {
        margin-right: 12px;
        font-size: 18px;
        width: 20px;
        text-align: center;
        color: inherit;
    }
    
    .settings-nav-item .badge {
        font-size: 10px;
        padding: 3px 6px;
        font-weight: 500;
        margin-left: auto;
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
    
    .settings-nav-item.active::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 4px;
        height: 60%;
        background-color: var(--primaryColor);
        border-radius: 0 4px 4px 0;
    }
    
    @media (max-width: 1024px) {
        .settings-nav {
            padding: 0 5px;
        }
        
        .settings-nav-item {
            padding: 10px 12px;
            font-size: 13px;
        }
        
        .settings-nav-item i {
            font-size: 16px;
            margin-right: 10px;
        }
    }
</style>

@push('scripts')
<script>
    // Initialiser les tooltips
    document.addEventListener('DOMContentLoaded', function() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush
