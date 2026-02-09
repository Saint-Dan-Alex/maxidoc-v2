<div class="modal fade" id="modal-suggestion" tabindex="-1" aria-labelledby="suggestionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="suggestionModalLabel">Suggestions & Signalement de Bugs</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('regidoc.suggestions.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="type" class="form-label">Type de message</label>
                        <select class="form-select" name="type" id="type" required>
                            <option value="suggestion">Suggestion d'amélioration</option>
                            <option value="bug">Signalement de Bug</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="objet" class="form-label">Objet</label>
                        <input type="text" class="form-control" name="objet" id="objet" placeholder="Ex: Problème d'affichage, Nouvelle fonctionnalité..." required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Votre message</label>
                        <textarea class="form-control" name="message" id="message" rows="4" placeholder="Décrivez votre suggestion ou le bug rencontré..." required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Capture d'écran (Optionnel)</label>
                        <input type="file" class="form-control" name="image" id="image" accept="image/*">
                        <div class="form-text">Formats acceptés: JPG, PNG, GIF. Max 5Mo.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Envoyer</button>
                </div>
            </form>
        </div>
    </div>
</div>
