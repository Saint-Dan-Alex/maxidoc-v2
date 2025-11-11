<div>
    <h5 class="mb-3">Détail du log #{{ $log['id'] ?? '' }}</h5>

    @if($log)
        @php $loc = !empty($log['location']) ? json_decode($log['location'], true) : null; @endphp
        <div class="card">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-6"><strong>Utilisateur</strong></div>
                    <div class="col-6">{{ $log['user_name'] ?? (class_basename($log['authenticatable_type'] ?? '').' #'.($log['authenticatable_id'] ?? '')) }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-6"><strong>IP</strong></div>
                    <div class="col-6">{{ $log['ip_address'] ?? '' }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-6"><strong>User Agent</strong></div>
                    <div class="col-6"><span class="text-break">{{ $log['user_agent'] ?? '' }}</span></div>
                </div>
                <div class="row mb-2">
                    <div class="col-6"><strong>Login</strong></div>
                    <div class="col-6">{{ $log['login_at'] ?? '' }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-6"><strong>Succès</strong></div>
                    <div class="col-6">{{ !empty($log['login_successful']) ? 'Oui' : 'Non' }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-6"><strong>Logout</strong></div>
                    <div class="col-6">{{ $log['logout_at'] ?? '—' }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-6"><strong>Localisation</strong></div>
                    <div class="col-6">
                        @if($loc && ($loc['latitude'] ?? null) && ($loc['longitude'] ?? null))
                            {{ $loc['city'] ?? '' }} {{ $loc['countryCode'] ?? '' }} ({{ $loc['latitude'] }}, {{ $loc['longitude'] }})
                            <a class="ms-2" target="_blank" href="https://maps.google.com/?q={{ $loc['latitude'] }},{{ $loc['longitude'] }}">Voir la carte</a>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-muted">Log introuvable.</div>
    @endif
</div>
