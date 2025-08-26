console.log('Script courrier-transmission.js chargé');

// Gestion de la transmission du courrier
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM entièrement chargé');
    
    // Écouter l'événement de clic sur le bouton de transmission
    document.addEventListener('click', function(e) {
        console.log('Clic détecté sur:', e.target);
        
        console.log('Élément cliqué:', e.target);
        console.log('ID de l\'élément:', e.target.id);
        console.log('Closest #btn-transmettre:', e.target.closest('#btn-transmettre'));
        
        if (e.target && (e.target.id === 'btn-transmettre' || e.target.closest('#btn-transmettre'))) {
            console.log('Bouton transmettre cliqué');
            e.preventDefault();
            
            // Afficher un message de confirmation
            if (confirm('Êtes-vous sûr de vouloir transmettre ce courrier ? Cette action est irréversible.')) {
                const button = e.target.closest('#btn-transmettre') || e.target;
                const courrierId = button.getAttribute('data-courrier-id');
                console.log('Bouton trouvé:', button);
                console.log('ID du courrier:', courrierId);
                
                // Afficher un indicateur de chargement
                const originalText = button.innerHTML;
                button.disabled = true;
                button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Transmission en cours...';
                
                console.log('Tentative de transmission du courrier ID:', courrierId);
                // Appeler la route de transmission
                const url = `/regidoc/courriers/transmettre`;
                const formData = new FormData();
                formData.append('courrier_id', courrierId);
                console.log('URL de la requête:', url);
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                console.log('CSRF Token:', csrfToken);
                
                console.log('Envoi de la requête de transmission...');
                return fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData,
                    credentials: 'same-origin'
                })
                .then(async response => {
                    console.log('Réponse reçue, statut:', response.status);
                    const responseData = await response.json().catch(() => ({}));
                    console.log('Données de la réponse:', responseData);
                    
                    if (!response.ok) {
                        const errorMsg = responseData.message || `Erreur HTTP! statut: ${response.status}`;
                        console.error('Erreur de réponse:', errorMsg);
                        throw new Error(errorMsg);
                    }
                    
                    return responseData;
                })
                .then(data => {
                    console.log('Traitement des données:', data);
                    
                    if (data && data.success) {
                        toastr.success(data.message || 'Le courrier a été transmis avec succès.');
                        console.log('Transmission réussie, rechargement de la page...');
                        
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    } else {
                        const errorMsg = data && data.message ? data.message : 'Réponse inattendue du serveur';
                        console.error('Erreur dans la réponse:', errorMsg);
                        toastr.error(errorMsg);
                        button.disabled = false;
                        button.innerHTML = originalText;
                    }
                })
                .catch(error => {
                    console.error('Erreur lors de la transmission du courrier:', error);
                    toastr.error('Erreur: ' + (error.message || 'Une erreur inconnue est survenue'));
                    button.disabled = false;
                    button.innerHTML = originalText;
                });
            }
        }
    });
});
