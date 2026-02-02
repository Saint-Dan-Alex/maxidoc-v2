@if (!$isSecretaireDG)
    <div x-data="{ playSound() { $refs.notificationSound.play().catch(e => console.log('Audio play failed:', e)) } }" 
         @play-notification-sound.window="playSound()">
        
        <audio x-ref="notificationSound" src="{{ asset('assets/songs/sendMessage.mp3') }}" preload="auto"></audio>

        <a href="" class="link me-4" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNotif"
            aria-controls="offcanvasRight" wire:poll.10s="fetchNotif">
            <div class="tooltip-indicator">
                Notifications
            </div>
            <i class="fi fi-rr-bell"></i>
            @if ($notifications->count())
                <span class="blink"></span>
            @endif
        </a>
    </div>
@endif
