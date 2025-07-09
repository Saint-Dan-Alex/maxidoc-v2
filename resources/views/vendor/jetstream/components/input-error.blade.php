@props(['for'])

@error($for)
    <div {{ $attributes->merge(['class' => '']) }}>{{ $message }}</div>
@enderror
