<x-mail::layout>
    {{-- Header --}}
    <x-slot name="header">
        <x-mail::header :url="config('app.url')">
            <img src="{{ asset('assets/img/mail_logo.svg') }}" class="logo" alt="{{ config('app.name') }}">
        </x-mail::header>
    </x-slot>

    {{-- Body --}}
    {{ $slot }}

    {{-- Subcopy --}}
    @isset($subcopy)
        <x-slot name="subcopy">
            <x-mail::subcopy>
                {{ $subcopy }}
            </x-mail::subcopy>
        </x-slot>
    @endisset

    {{-- Footer --}}
    <x-slot name="footer">
        <x-mail::footer>
            &COPY; Copyright {{ date('Y') }} MaxiDoc | @lang('All rights reserved.')
        </x-mail::footer>
        <a href="https://newtech-rdc.net/">
            <img src="{{ asset('assets/regidoc/logo2.png') }}" alt="logoNewtech">
        </a>
    </x-slot>
</x-mail::layout>
