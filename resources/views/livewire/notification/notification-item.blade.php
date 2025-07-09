<div @class(['card card-notification', 'see' => $notification->unread()]) wire:ignore>
    <a href="javascript:void(0)" class="btn-close position-absolute d-flex align-items-center justify-content-center"
        style="top:11px; right:11px; font-size:8px" wire:click='markAsRead'>
        <i class=" iconNotification fi fi-rr-cross"></i>
    </a>
    <a href="javascript:void(0)" wire:click='open'>
        <div class="avatar-user-float">
            <img src="{{ imageOrDefault($notification->data['data']['agent']['image']) }}"
                alt="{{ $notification->data['data']['agent']['name'] }}">
        </div>
        <div class="text-star text-content">
            <h6 class="date d-flex justify-content-between align-items-center">
                <span>{{ $notification->data['data']['agent']['name'] }}</span>
            </h6>
            <p>
                {!! $notification->data['data']['message'] !!}
            </p>
            <div class="text-start">
                <span class="time-notif"><i class="fi fi-rr-clock mx-1"></i>
                    {{ $notification->created_at->format('d/m/Y à H:i') ?? '' }}</span>
            </div>
            @if ($notification->type == \App\Notifications\DocumentNotification::class)
                <div class="mt-2 block-file d-flex align-items-center">
                    <div class="icon-sm">
                        <i class="fi fi-rr-file"></i>
                    </div>
                    <div class="block-detail-file">
                        <h6>{{ $notification->data['data']['object']['libelle'] ?? '' }}</h6>
                        <p>Référence : {{ $notification->data['data']['object']['reference'] }}</p>
                    </div>
                </div>
            @endif
        </div>
    </a>
</div>
