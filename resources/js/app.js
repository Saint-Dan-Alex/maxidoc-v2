import "./bootstrap";

import Alpine from "alpinejs";
import { Livewire } from "../../vendor/livewire/livewire/dist/livewire.esm";

window.Alpine = Alpine;

// Gestionnaire pour fermer les modales
window.addEventListener('close-modal', event => {
    const modalId = event.detail.modalId;
    const modal = document.getElementById(modalId);
    if (modal) {
        // Fermer la modale avec Bootstrap
        const modalInstance = bootstrap.Modal.getInstance(modal);
        if (modalInstance) {
            modalInstance.hide();
        }
    }
});

Alpine.start();
