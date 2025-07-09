@if ($errors->any())
    <div {{ $attributes }}>
        <small class="text-danger">{{ __('Whoops! Something went wrong.') }}</small>

        <ul class="mt-3 list-unstyled error-list">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
