<div class="p-4">
    <div class="mb-6">
        <h2 class="text-xl font-bold text-gray-800">Paramètres</h2>
        <p class="text-sm text-gray-500">Gérez vos préférences</p>
    </div>
    
    <nav class="space-y-1">
        @php
            $currentRoute = request()->route()->getName();
            $menuItems = \App\Models\MenuItem::where('parent_id', 40)
                ->orderBy('order')
                ->get()
                ->filter(fn($item) => auth()->user()->can($item->policy));
        @endphp
        
        @foreach($menuItems as $item)
            <a href="{{ route($item->route) }}" 
               class="settings-nav-item flex items-center px-4 py-2 text-sm font-medium rounded-md {{ request()->routeIs($item->route) ? 'active' : '' }}">
                <i class="{{ $item->icon_regular }} w-5 h-5 mr-3"></i>
                <span>{{ $item->title }}</span>
            </a>
        @endforeach
    </nav>
</div>
