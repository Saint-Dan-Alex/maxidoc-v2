document.addEventListener('livewire:load', function() {
    // Vérifier si Echo est disponible
    if (typeof window.Echo !== 'undefined') {
        // S'abonner au canal des courriers
        window.Echo.channel('addedcourriers')
            .listen('CourrierCreated', (e) => {
                console.log('Nouveau courrier reçu:', e.courrier);
                
                // Émettre un événement Livewire pour mettre à jour l'interface utilisateur
                if (typeof window.livewire !== 'undefined') {
                    window.livewire.emit('courrierCreated', e.courrier);
                }
                
                // Jouer un son de notification
                const notificationSound = new Audio('/assets/sounds/notification.mp3');
                notificationSound.play().catch(e => console.log('Impossible de jouer le son de notification:', e));
            });
    } else {
        console.warn('Echo n\'est pas disponible. Les mises à jour en temps réel ne fonctionneront pas.');
    }
});
