document.addEventListener('livewire:load', function () {
    // Fermer la modale après la création d'un rôle
    Livewire.on('roleCreated', function () {
        const modal = bootstrap.Modal.getInstance(document.getElementById('modal-new-role'));
        if (modal) {
            modal.hide();
        }
    });

    // Réinitialiser le formulaire lorsque la modale est fermée
    document.getElementById('modal-new-role').addEventListener('hidden.bs.modal', function () {
        Livewire.emit('resetRoleForm');
    });
});
