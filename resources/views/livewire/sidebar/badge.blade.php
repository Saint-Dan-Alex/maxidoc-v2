<span wire:poll.30s>
    @if(($count ?? 0) > 0)
        <span class="badge bg-{{ $bg }} ms-2 rounded-pill py-1 px-2 fw-normal" style="font-size:10px">
            {{ $count }}
        </span>
    @endif
</span>
