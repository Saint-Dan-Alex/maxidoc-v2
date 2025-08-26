// Gestion de la transmission du courrier
document.addEventListener('DOMContentLoaded', function() {
    // Écouter l'événement de clic sur le bouton de transmission
    document.addEventListener('click', function(e) {
        if (e.target && e.target.id === 'btn-transmettre') {
            e.preventDefault();
            
            // Afficher un message de confirmation
            if (confirm('Êtes-vous sûr de vouloir transmettre ce courrier ? Cette action est irréversible.')) {
                const courrierId = e.target.getAttribute('data-courrier-id');
                
                // Afficher un indicateur de chargement
                const button = e.target;
                const originalText = button.innerHTML;
                button.disabled = true;
                button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Transmission en cours...';
                
                // Appeler la route de transmission
                fetch(`/courriers/${courrierId}/transmettre`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Afficher un message de succès
                        toastr.success(data.message || 'Le courrier a été transmis avec succès.');
                        
                        // Recharger la page après un court délai
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    } else {
                        // Afficher un message d'erreur
                        toastr.error(data.message || 'Une erreur est survenue lors de la transmission du courrier.');
                        button.disabled = false;
                        button.innerHTML = originalText;
                    }
                })
                .catch(error => {
                    console.error('Erreur lors de la transmission du courrier:', error);
                    toastr.error('Une erreur est survenue lors de la transmission du courrier.');
                    button.disabled = false;
                    button.innerHTML = originalText;
                });
            }
        }
    });
});
