<div>
    <h5 class="mb-3">Logs d'authentification</h5>
    <div class="d-flex justify-content-between align-items-center mb-3 p-2 border rounded-3 bg-light">
        <div class="input-group" style="max-width: 360px;">
            <span class="input-group-text"><i class="fi fi-rr-search"></i></span>
            <input type="text" class="form-control" placeholder="Rechercher IP / User-Agent" wire:model.debounce.400ms="search">
        </div>
        <div class="text-muted" style="font-size: 12px;">Actualisation auto</div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Connexion</th>
                    <th>Utilisateur</th>
                    <th>IP</th>
                    <th>Appareil</th>
                    <th>Succès</th>
                    <th>Déconnexion</th>
                    <th>Localisation</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>
            @forelse ($logs as $row)
                @php $loc = $row->location ? json_decode($row->location, true) : null; @endphp
                <tr>
                    <td>{{ $row->login_at ? \Carbon\Carbon::parse($row->login_at)->format('d/m/Y H:i') : '-' }}</td>
                    <td>{{ $row->user_name ?? (class_basename($row->authenticatable_type).' #'.$row->authenticatable_id) }}</td>
                    <td>{{ $row->ip_address ?? '-' }}</td>
                    <td class="text-truncate" style="max-width:340px;" title="{{ $row->user_agent }}">{{ $row->user_agent }}</td>
                    <td>
                        @if($row->login_successful)
                            <span class="d-inline-flex align-items-center">
                                <span class="me-1 d-inline-block rounded-circle bg-success" style="width:8px;height:8px;"></span>
                                <span class="badge badge-green">Oui</span>
                            </span>
                        @else
                            <span class="d-inline-flex align-items-center">
                                <span class="me-1 d-inline-block rounded-circle bg-danger" style="width:8px;height:8px;"></span>
                                <span class="badge badge-red">Non</span>
                            </span>
                        @endif
                    </td>
                    <td>{{ $row->logout_at ? \Carbon\Carbon::parse($row->logout_at)->format('d/m/Y H:i') : '-' }}</td>
                    <td>
                        @if($loc && (($loc['latitude'] ?? null) && ($loc['longitude'] ?? null)))
                            {{ $loc['city'] ?? '' }}{{ !empty($loc['city']) && !empty($loc['countryCode']) ? ', ' : '' }}{{ $loc['countryCode'] ?? '' }}
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <button type="button" class="btn btn-sm btn-outline-primary" wire:click="show({{ $row->id }})" title="Voir">
                            <i class="fi fi-rr-eye"></i>
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">Aucun log</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-end">
        {{ $logs->links() }}
    </div>

    <!-- Modal détail log -->
    <div class="modal fade" id="authLogModal" tabindex="-1" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Détail du log</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if($selected && !empty($selected['id']))
                        @livewire('admin.logs.authentication-log-show', ['id' => $selected['id']], key('auth-log-'.$selected['id']))
                    @else
                        <div class="text-muted">Aucune donnée à afficher.</div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('open-auth-log-modal', () => {
            const el = document.getElementById('authLogModal');
            if (!el) return;
            const modal = bootstrap.Modal.getOrCreateInstance(el);
            modal.show();
        });
    </script>
</div>
