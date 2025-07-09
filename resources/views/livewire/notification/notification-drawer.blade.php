<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNotif" aria-labelledby="offcanvasRightLabel"
    wire:ignore.self>
    <div class="offcanvas-header" wire:ignore.self>
        <h5 id="offcanvasRightLabel">Notifications</h5>
        {{-- <hr> --}}

        <button class="btn btn-primary btn-notification-delete" data-tooltip="Vider les notifications"
            style="color: var(--bgBtnPrimary)">
            Vider toutes les notifications
        </button>
        {{-- <button class="btn btn-primary btn-notification-delete" title="vider les notification"
            style="color: var(--bgBtnPrimary) ">
        
            vider toutes les notification
        </button> --}}
        <button type="button" class="btn-close btn-close-notification text-reset" data-bs-dismiss="offcanvas"
            aria-label="Close">
            <i class="fi fi-rr-cross"></i>
        </button>
    </div>
    <div class="offcanvas-body align-items-center justify-content-center d-flex flex-column" wire:ignore.self
        style="overflow-x: hidden">
        <div wire:poll.1000ms class="w-100 h-100 @if (!$notifications->count()) d-none @endif">
            @foreach ($notifications as $notification)
                @livewire('notification.notification-item', ['notification' => $notification], key($notification->id))
            @endforeach
        </div>
        <div class="block-empty-notif w-100 @if (!$notifications->count()) show @endif">
            <i class="fi fi-rr-bell"></i>
            <p>Vous n'avez aucune notification</p>
        </div>
    </div>
    <div class="offcanvas-footer" wire:ignore>
        <div class="text-center" id="push-permission">
            {{-- <a href="#" class="see-more">Authoriser les Notification</a> --}}
        </div>
    </div>

    {{-- <div class="offcanvas-body" wire:ignore.self>
        <div class="mb-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Chats</h5>
            <p class="mb-0">{{ '( ' . $chatNotifications->where('read_at', null)->count() . ' )' ?? '( 0 )' }}</p>
        </div>
        @foreach ($chatNotifications as $chatNotification)
            <a href="#">
                <div class="card card-notification see">
                    <div class="avatar-user-float">
                        <img src="{{ asset('assets/img/team/1.jpg') }}" alt="photo profil">
                    </div>
                    <div class="text-star text-content">
                        <h6 class="date d-flex justify-content-between align-items-center">
                            <span>{{ $message->Send->name ?? '' }}</span>
                            <span>{{ $message->created_at->format('H:i') ?? '' }}</span></h6>
                        <p> {{ $message->content ?? '' }} </p>
                    </div>
                    <div class="d-flex justify-content-end">
                        <div class="num">1</div>
                    </div>
                </div>
            </a>
        @endforeach

    </div>
    <div class="offcanvas-footer">
        <div class="text-center">
            <a href="#" class="btn">Plus des courriers</a>
        </div>
    </div> --}}
</div>
