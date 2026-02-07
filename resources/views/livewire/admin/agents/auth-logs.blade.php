<div>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="input-group" style="max-width: 360px;">
            <span class="input-group-text"><i class="fi fi-rr-search"></i></span>
            <input type="text" class="form-control" placeholder="Rechercher IP / User-Agent"
                   wire:model.debounce.400ms="search">
        </div>
        <div class="text-muted" style="font-size: 12px;">
            Actualisation auto
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Connexion</th>
                    <th>IP</th>
                    <th>Appareil</th>
                    <th>Succès</th>
                    <th>Déconnexion</th>
                    <th>Localisation</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                    <tr>
                        <td>{{ $log->login_at ? \Carbon\Carbon::parse($log->login_at)->format('d/m/Y H:i') : '-' }}</td>
                        <td>{{ $log->ip_address ?? '-' }}</td>
                        <td style="max-width: 360px;">
                            <span class="d-inline-block text-truncate text-primary" style="max-width: 340px;" title="{{ $log->user_agent }}">
                                {{ parseUA($log->user_agent) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge {{ $log->login_successful ? 'badge-green' : 'badge-red' }}">
                                {{ $log->login_successful ? 'Oui' : 'Non' }}
                            </span>
                        </td>
                        <td>{{ $log->logout_at ? \Carbon\Carbon::parse($log->logout_at)->format('d/m/Y H:i') : '-' }}</td>
                        <td>
                            @php
                                $loc = '-';
                                if (!empty($log->location)) {
                                    try {
                                        $arr = is_array($log->location) ? $log->location : json_decode($log->location, true);
                                        if (is_array($arr)) {
                                            $parts = [];
                                            foreach (['city','regionCode','countryCode'] as $k) {
                                                if (!empty($arr[$k])) $parts[] = $arr[$k];
                                            }
                                            $loc = count($parts) ? implode(', ', $parts) : '-';
                                        }
                                    } catch (\Throwable $e) { $loc = '-'; }
                                }
                            @endphp
                            {{ $loc }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">Aucune connexion trouvée</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-end">
        {{ $logs->links() }}
    </div>
</div>
