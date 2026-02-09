@extends('layouts.home')

@section('content')
<style>
    .suggestion-card {
        transition: all 0.3s ease;
        border-radius: 12px;
    }
    .suggestion-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .status-badge {
        font-weight: 500;
        padding: 6px 12px;
        border-radius: 20px;
    }
    .type-icon {
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        margin-right: 12px;
    }
    .bg-bug { background-color: rgba(235, 59, 90, 0.1); color: #eb3b5a; }
    .bg-suggestion { background-color: rgba(32, 191, 107, 0.1); color: #20bf6b; }
    .modal-content { border-radius: 15px; border: none; }
    .btn-view { border-radius: 8px; padding: 5px 15px; transition: all 0.2s; }
    .btn-view:hover { background: #4b7bec; color: white; }
</style>

<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1 text-dark fw-bold">Suggestions & Signalements</h4>
                <p class="text-muted small mb-0">Gestion des retours utilisateurs et rapports de bugs.</p>
            </div>
        </div>

        <div class="card border-0 shadow-sm suggestion-card">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 bg-transparent">Date</th>
                                <th class="border-0 bg-transparent">Utilisateur</th>
                                <th class="border-0 bg-transparent">Sujet & Type</th>
                                <th class="border-0 bg-transparent">Statut</th>
                                <th class="border-0 bg-transparent">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($suggestions as $suggestion)
                                <tr>
                                    <td>{{ $suggestion->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="ms-2">
                                                <div class="fw-bold">{{ $suggestion->user->name ?? 'Utilisateur supprimé' }}</div>
                                                <small class="text-muted">{{ $suggestion->user->email ?? '' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                         <div class="d-flex align-items-center">
                                             @if($suggestion->type == 'bug')
                                                 <div class="type-icon bg-bug" title="Bug">
                                                     <i class="fi fi-rr-bug"></i>
                                                 </div>
                                             @else
                                                 <div class="type-icon bg-suggestion" title="Suggestion">
                                                     <i class="fi fi-rr-lightbulb"></i>
                                                 </div>
                                             @endif
                                             <div>
                                                 <div class="fw-bold">{{ Str::limit($suggestion->objet, 40) }}</div>
                                                 <small class="text-muted">{{ $suggestion->type == 'bug' ? 'Rapport de Bug' : 'Suggestion' }}</small>
                                             </div>
                                         </div>
                                     </td>
                                     <td>
                                         @php
                                             $statusClass = [
                                                 'ouvert' => 'bg-warning',
                                                 'en_cours' => 'bg-primary',
                                                 'ferme' => 'bg-success'
                                             ][$suggestion->status] ?? 'bg-secondary';
                                         @endphp
                                         <span class="badge {{ $statusClass }} status-badge text-white">
                                             {{ ucfirst(str_replace('_', ' ', $suggestion->status)) }}
                                         </span>
                                     </td>
                                     <td>
                                         <button class="btn btn-sm btn-outline-primary btn-view" data-bs-toggle="modal" data-bs-target="#modal-view-{{ $suggestion->id }}">
                                             <i class="fi fi-rr-eye me-1"></i> Détails
                                         </button>
                                     </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">Aucun message trouvé</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $suggestions->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODALES EN DEHORS DE LA BOUCLE PRINCIPALE POUR ÉVITER LE CLIGNOTEMENT --}}
@foreach($suggestions as $suggestion)
    <!-- Modal de visualisation pour {{ $suggestion->id }} -->
    <div class="modal fade" id="modal-view-{{ $suggestion->id }}" tabindex="-1" aria-hidden="true" data-bs-backdrop="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content shadow-lg">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Détails du message</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-7">
                            <h6 class="text-muted small text-uppercase fw-bold mb-2">Message:</h6>
                            <div class="border p-3 rounded mb-4" style="background-color: #f8f9fa; min-height: 100px;">
                                {{ $suggestion->message }}
                            </div>
                            
                            @if($suggestion->image_path)
                                <h6 class="text-muted small text-uppercase fw-bold mb-2">Pièce jointe:</h6>
                                <div class="border p-2 rounded text-center bg-white shadow-sm">
                                    <img src="{{ asset('storage/' . $suggestion->image_path) }}" class="img-fluid rounded" style="max-height: 350px;" alt="Capture d'écran">
                                    <div class="mt-3">
                                        <a href="{{ asset('storage/' . $suggestion->image_path) }}" target="_blank" class="btn btn-sm btn-secondary px-4">
                                            <i class="fi fi-rr-expand me-1"></i> Ouvrir l'image
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-5 border-start ps-md-4">
                            <div class="mb-4">
                                <h6 class="text-muted small text-uppercase fw-bold mb-2">Infos:</h6>
                                <p class="mb-1 small"><strong>Envoyé par:</strong> {{ $suggestion->user->name ?? 'Inconnu' }}</p>
                                <p class="mb-1 small"><strong>Date:</strong> {{ $suggestion->created_at->format('d/m/Y H:i') }}</p>
                            </div>

                            <h6 class="text-muted small text-uppercase fw-bold mb-2">Changer le statut:</h6>
                            <form action="{{ route('regidoc.admin.suggestions.updateStatus', $suggestion) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <select name="status" class="form-select border shadow-none">
                                        <option value="ouvert" {{ $suggestion->status == 'ouvert' ? 'selected' : '' }}>Ouvert / Nouveau</option>
                                        <option value="en_cours" {{ $suggestion->status == 'en_cours' ? 'selected' : '' }}>En cours de traitement</option>
                                        <option value="ferme" {{ $suggestion->status == 'ferme' ? 'selected' : '' }}>Fermé / Résolu</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 shadow-sm py-2">
                                    <i class="fi fi-rr-refresh me-1"></i> Mettre à jour
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
@endsection
