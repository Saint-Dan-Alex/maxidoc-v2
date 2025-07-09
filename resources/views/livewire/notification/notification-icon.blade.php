<a href="" class="link me-4" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNotif"
    aria-controls="offcanvasRight" wire:poll="fetchNotif">
    <div class="tooltip-indicator">
        Notifications
    </div>
    <i class="fi fi-rr-bell"></i>
    @if ($notifications->count())
        <span class="blink"></span>
    @endif
</a>
