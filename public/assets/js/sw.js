"use strict";

self.addEventListener("install", function(event) {
    self.skipWaiting();
});

self.addEventListener("activate", function(event) {
    event.waitUntil(self.clients.claim());
});

self.addEventListener("push", function(event) {
    if (!(self.Notification && self.Notification.permission === 'granted')) {
        return;
    }

    const payload = event.data ? event.data.json() : {};
    event.waitUntil(self.registration.showNotification(payload.title, payload));
});


// self.addEventListener('install', () => {
//     self.skipWaiting();
// });

// self.addEventListener('push', (event) => {
//     const data = event.data ? event.data.json() : {};
//     event.waitUntil(
//         self.registration.showNotification(data.title, {
//             // badge: '',
//             body: data.message,
//             data: data
//         })
//     );
// });


// self.addEventListener('install', () => {
//     self.skipWaiting();
// });

// self.addEventListener('push', function (e) {
//     if (!(self.Notification && self.Notification.permission === 'granted')) {
//         //notifications aren't supported or permission not granted!
//         return;
//     }

//     if (e.data) {
//         var msg = e.data.json();
//         console.log(msg)
//         e.waitUntil(self.registration.showNotification(msg.title, {
//             body: msg.body,
//             icon: msg.icon,
//             actions: msg.actions
//         }));
//     }
// });