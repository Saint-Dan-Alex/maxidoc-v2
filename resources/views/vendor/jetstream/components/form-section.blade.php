@props(['submit'])

{{-- <div {{ $attributes->merge(['class' => '']) }}> --}}
    {{-- <x-jet-section-title>
        <x-slot name="title">{{ $title }}</x-slot>
        <x-slot name="description">{{ $description }}</x-slot>
    </x-jet-section-title> --}}

    {{-- <div class="mt-5 md:mt-0 md:col-span-2"> --}}
        <form wire:submit.prevent="{{ $submit }}">
            {{-- <div class="px-4 py-5 bg-white sm:p-6 shadow {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}"> --}}
                <div class="form-group row g-3">
                    {{ $form }}
                </div>
            {{-- </div> --}}

            @if (isset($actions))
                <div class="mt-4 col-12 d-flex">
                    {{ $actions }}
                </div>
            @endif
        </form>
    {{-- </div> --}}
{{-- </div> --}}
