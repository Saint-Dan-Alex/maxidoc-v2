@extends('regidoc.layouts.master')

@section('content')
<div class="flex h-screen bg-gray-50">
    <!-- Sidebar -->
    <div class="w-64 bg-white border-r border-gray-200">
        @include('components.settings.sidebar')
    </div>

    <!-- Main Content -->
    <div class="flex-1 overflow-auto">
        <div class="p-6">
            @if (session('status'))
                <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">
                    {{ session('status') }}
                </div>
            @endif
            
            @yield('content')
        </div>
    </div>
</div>

@push('styles')
<style>
.settings-nav-item {
    display: block;
    padding: 0.75rem 1.5rem;
    color: #4a5568;
    text-decoration: none;
    transition: all 0.2s;
}

.settings-nav-item:hover {
    background-color: #f7fafc;
    color: #1a56db;
}

.settings-nav-item.active {
    background-color: #ebf4ff;
    color: #1a56db;
    border-right: 3px solid #1a56db;
}

.settings-nav-item:hover {
    background-color: #edf2f7;
    color: #2d3748;
}

.settings-nav-item.active {
    background-color: #ebf8ff;
    border-left: 3px solid #3182ce;
    color: #2b6cb0;
    font-weight: 500;
}
</style>
@endpush
@endsection
