<div class="message-flash {{ $type }} wire">
    <div class="content-text d-flex justify-content-center align-items-center  g-3 gap-3">

        <div class="content-text-imageBox d-flex justify-content-center align-items-center ">

            @if ($type == 'success')
                {{-- <img src="{{ asset('assets/images/icons/check.png') }}" alt="icon success"> --}}
                <svg xmlns="http://www.w3.org/2000/svg" width="1024" height="1024" viewBox="0 0 1024 1024"
                    class="svg-success">
                    <path fill="currentColor"
                        d="M512 64a448 448 0 1 1 0 896a448 448 0 0 1 0-896m-55.808 536.384l-99.52-99.584a38.4 38.4 0 1 0-54.336 54.336l126.72 126.72a38.27 38.27 0 0 0 54.336 0l262.4-262.464a38.4 38.4 0 1 0-54.272-54.336z" />
                </svg>
            @endif
            @if ($type == 'warning')
                {{-- <img src="{{ asset('assets/images/icons/warning-icon.png') }}" alt="icon warning"> --}}
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    class="svg-warning">
                    <g fill="none">
                        <path
                            d="m12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.018-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z" />
                        <path fill="currentColor"
                            d="M12 2c5.523 0 10 4.477 10 10s-4.477 10-10 10S2 17.523 2 12S6.477 2 12 2m0 13a1 1 0 1 0 0 2a1 1 0 0 0 0-2m0-9a1 1 0 0 0-.993.883L11 7v6a1 1 0 0 0 1.993.117L13 13V7a1 1 0 0 0-1-1" />
                    </g>
                </svg>
            @endif
            @if ($type == 'error')
                <svg xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 512 512"
                    class="svg-error">
                    <path fill="currentColor" fill-rule="evenodd"
                        d="M256 42.667c117.803 0 213.334 95.53 213.334 213.333S373.803 469.334 256 469.334S42.667 373.803 42.667 256S138.197 42.667 256 42.667m48.918 134.25L256 225.836l-48.917-48.917l-30.165 30.165L225.835 256l-48.917 48.918l30.165 30.165L256 286.166l48.918 48.917l30.165-30.165L286.166 256l48.917-48.917z" />
                </svg>
                {{-- <img src="{{ asset('assets/images/icons/error-icon.png') }}" alt="icon error"> --}}
            @endif
        </div>
        {{-- <div class="icon text-white">
            <i @class([
                'fi',
                'fi-rr-check' => $type == 'success',
                'fi-rr-shield-exclamation' => $type == 'warning',
                'fi-rr-cross' => $type == 'error',
            ])></i>
        </div> --}}
        <div class="text-star">
            <h6>{{ __($type) }}</h6>
            @if ($errors->any())
                <div>
                    <small class="text-danger">{{ __('Whoops! Something went wrong.') }}</small>
                    <ul class="mt-3 list-unstyled error-list">
                        @foreach ($errors->all() as $error)
                            <li class="text-danger">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @else
                <p>
                    {!! __($message) !!}
                </p>
            @endif
        </div>
    </div>
</div>
