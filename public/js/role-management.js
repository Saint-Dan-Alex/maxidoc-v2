document.addEventListener('livewire:load', function () {
    // Gérer la création réussie d'un rôle
    Livewire.on('roleCreated', function () {
        // Fermer la modale
        const modal = bootstrap.Modal.getInstance(document.getElementById('modal-new-role'));
        if (modal) {
            modal.hide();
        }
        
        // Afficher un message de succès
        Livewire.emit('alert', 'success', 'Rôle créé avec succès !');
        
        // Rafraîchir la liste des rôles après un court délai
        setTimeout(() => {
            Livewire.emit('$refresh');
        }, 500);
    });

    // Réinitialiser le formulaire lorsque la modale est fermée
    const roleModal = document.getElementById('modal-new-role');
    if (roleModal) {
        roleModal.addEventListener('hidden.bs.modal', function () {
            Livewire.emit('resetRoleForm');
        });
    }
    
    // Gérer les erreurs de validation
    Livewire.on('validationError', (message) => {
        Livewire.emit('alert', 'error', message);
    });
});
