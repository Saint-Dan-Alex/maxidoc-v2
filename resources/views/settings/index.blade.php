@extends('layouts.app-settings')

@section('content')
<div class="flex-1 overflow-auto">
    <div class="p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-lg font-medium text-gray-900">
                    {{ __('Tableau de bord des paramètres') }}
                </h3>
                <p class="mt-1 text-sm text-gray-500">
                    {{ __('Gérez les différents paramètres de votre application') }}
                </p>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($menuItems as $item)
                        <a href="{{ $item->url }}" 
                           class="group relative bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-blue-500 rounded-lg border border-gray-200 hover:shadow-md transition-shadow duration-200">
                            <div class="flex items-center">
                                <span class="rounded-lg inline-flex p-3 bg-blue-50 text-blue-600 ring-4 ring-white">
                                    <i class="{{ $item->icon_regular }} w-6 h-6"></i>
                                </span>
                                <div class="ml-4">
                                    <h3 class="text-lg font-medium text-gray-900">
                                        {{ $item->title }}
                                        <span class="absolute inset-0" aria-hidden="true"></span>
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-500">
                                        {{ $item->description ?? 'Gérer les ' . strtolower($item->title) }}
                                    </p>
                                </div>
                            </div>
                            <span class="pointer-events-none absolute top-6 right-6 text-gray-300 group-hover:text-blue-400" aria-hidden="true">
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z" />
                                </svg>
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
