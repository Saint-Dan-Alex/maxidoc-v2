
// var csrftoken = document.querySelector('meta[name="csrf-token"]').getAttribute('Content');

// if ("serviceWorker" in navigator) {
//     window.addEventListener("load", function () {
//         navigator.serviceWorker.register("/assets/js/sw.js");
//     });
// }

// if (!('Notification' in window)) {
//     alert("This browser does not support notifications.");
// }

// function urlBase64ToUint8Array(base64String) {
//     var padding = "=".repeat((4 - base64String.length % 4) % 4);
//     var base64 = (base64String + padding).replace(/\-/g, "+").replace(/_/g, "/");
//     var rawData = window.atob(base64);
//     var outputArray = new Uint8Array(rawData.length);

//     for (var i = 0; i < rawData.length; ++i) {
//         outputArray[i] = rawData.charCodeAt(i);
//     }

//     return outputArray;
// }

// function enablePushNotifications() {

//     navigator.serviceWorker.ready.then(function (registration) {
//         registration.pushManager.getSubscription().then(function (subscription) {
//             if (subscription) {
//                 console.log('Subscription already exists.');
//                 return subscription;
//             }

//             var serverKey = urlBase64ToUint8Array("BGGT-bBQOWZCTNCYbO8iNN_ifnOg96du206eNXC9SmJUraQh4JQLoIHJmP2jslTNwSGndciXzrXoO-PGuiLSIog");
//             return registration.pushManager.subscribe({
//                 userVisibleOnly: true,
//                 applicationServerKey: serverKey
//             });
//         }).then(function (subscription) {
//             if (!subscription) {
//                 alert("Error occured while subscribing");
//                 return;
//             }

//             subscribe(subscription);
//         });
//     });

// }

// function disablePushNotifications() {
//     navigator.serviceWorker.ready.then(function (registration) {
//         registration.pushManager.getSubscription().then(function (subscription) {
//             if (!subscription) {
//                 console.log('No subscription found.');
//                 return;
//             }

//             console.log('Found subscription, unsubscribing...');
//             subscription.unsubscribe().then(function () {
//                 fetch('/notifications/unsubscribe', {
//                     method: 'POST',
//                     headers: {
//                         'Content-Type': 'application/json',
//                         'X-CSRF-TOKEN': csrftoken
//                     },
//                     body: JSON.stringify({
//                         endpoint: subscription.endpoint
//                     })
//                 }).then(function (response) {
//                     return response.json();
//                 }).then(function (data) {
//                     console.log('Success:', data);
//                 })["catch"](function (error) {
//                     console.error('Error:', error);
//                 });
//             });
//         });
//     });
// }

// function subscribe(sub) {
//     var key = sub.getKey('p256dh');
//     var token = sub.getKey('auth');
//     var contentEncoding = (PushManager.supportedContentEncodings || ['aesgcm'])[0];
//     var data = {
//         endpoint: sub.endpoint,
//         public_key: key ? btoa(String.fromCharCode.apply(null, new Uint8Array(key))) : null,
//         auth_token: token ? btoa(String.fromCharCode.apply(null, new Uint8Array(token))) : null,
//         encoding: contentEncoding
//     };
//     fetch('/notifications/subscribe', {
//         method: 'POST',
//         headers: {
//             'Content-Type': 'application/json',
//             'X-CSRF-TOKEN': csrftoken
//         },
//         body: JSON.stringify(data)
//     }).then(function (response) {
//         return response.json();
//     }).then(function (data) {
//         console.log('Success:', data);
//     })["catch"](function (error) {
//         console.error('Error:', error);
//     });
// }

// document.getElementById('enable-push').addEventListener('click', function () {
//   enablePushNotifications();
// });
// document.getElementById('disable-push').addEventListener('click', function () {
//   disablePushNotifications();
// });

// function initSW() {
//     if (!"serviceWorker" in navigator) {
//         //service worker isn't supported
//         return;
//     }

//     //don't use it here if you use service worker
//     //for other stuff.
//     if (!"PushManager" in window) {
//         //push isn't supported
//         return;
//     }

//     const permission = document.getElementById('push-permission');
//     const button = document.createElement('button');
//     button.classList.add('btn');
//     button.classList.add('btn-dark');
//     button.innerText = 'Recevoir des notifications';

//     permission.appendChild(button);

//     button.addEventListener('click', enablePushNotifications)

// }
// initSW();



// initSW();

// function initSW() {
//     if (!"serviceWorker" in navigator) {
//         //service worker isn't supported
//         return;
//     }

//     //don't use it here if you use service worker
//     //for other stuff.
//     if (!"PushManager" in window) {
//         //push isn't supported
//         return;
//     }

//     const permission = document.getElementById('push-permission');
//     const button = document.createElement('button');
//     button.classList.add('btn');
//     button.classList.add('btn-dark');
//     button.innerText = 'Recevoir des notifications';

//     permission.appendChild(button);

//     button.addEventListener('click', askPermission)


// }

// function askPermission() {
//     //register the service worker
//     // navigator.serviceWorker.register('/assets/js/sw.js')
//     //     .then(() => {
//     //         console.log('serviceWorker installed!')
//             initPush();
//         // })
//         // .catch((err) => {
//         //     console.log(err)
//         // });
// }

// function initPush() {
//     if (!navigator.serviceWorker.ready) {
//         return;
//     }

//     new Promise(function (resolve, reject) {
//         const permissionResult = Notification.requestPermission(function (result) {
//             resolve(result);
//         });

//         if (permissionResult) {
//             permissionResult.then(resolve, reject);
//         }
//     }).then((permissionResult) => {
//         console.log(permissionResult);
//         if (permissionResult !== 'granted') {
//             throw new Error('We weren\'t granted permission.');
//         }
//         subscribeUser();
//     });
// }

// function subscribeUser() {
//     const key = "BGGT-bBQOWZCTNCYbO8iNN_ifnOg96du206eNXC9SmJUraQh4JQLoIHJmP2jslTNwSGndciXzrXoO-PGuiLSIog";
//     // Ensure that the service worker is registered and activated
//     navigator.serviceWorker.register('/assets/js/sw.js')
//         .then((registration) => {
//             // Service worker registration was successful
//             return registration.ready;
//         })
//         .then((serviceWorkerRegistration) => {
//             // Now you have the service worker registration, proceed with push subscription
//             const subscribeOptions = {
//                 userVisibleOnly: true,
//                 applicationServerKey: urlBase64ToUint8Array(key)
//             };

//             console.log(subscribeOptions);

//             return serviceWorkerRegistration.pushManager.subscribe(subscribeOptions);
//         })
//         .then((pushSubscription) => {
//             console.log('Received PushSubscription:', JSON.stringify(pushSubscription));
//             storePushSubscription(pushSubscription);
//         })
//         .catch((error) => {
//             console.error('Error subscribing user:', error);
//         });
// }

// function subscribeUser() {
//     getPublicKey()
//         .then((key) => navigator.serviceWorker.ready
//             .then(registration => {
//                 const subscribeOptions = {
//                     userVisibleOnly: true,
//                     applicationServerKey: urlBase64ToUint8Array(key)
//                 };

//                 console.log(subscribeOptions);

//                 return registration.pushManager.subscribe(subscribeOptions);
//             })
//             .then(pushSubscription => {
//                 console.log('Received PushSubscription: ', JSON.stringify(pushSubscription));
//                 storePushSubscription(pushSubscription);
//             }))
//         .catch(error => {
//             console.error('Error subscribing user:', error);
//         });
// }

// function subscribeUser() {

//     const key = "BGGT-bBQOWZCTNCYbO8iNN_ifnOg96du206eNXC9SmJUraQh4JQLoIHJmP2jslTNwSGndciXzrXoO-PGuiLSIog";

//     navigator.serviceWorker.ready
//         .then((registration) => {

//             console.log(urlBase64ToUint8Array(key));

//             const subscribeOptions = {
//                 userVisibleOnly: true,
//                 applicationServerKey: urlBase64ToUint8Array(key)
//             };

//             console.log(subscribeOptions);

//             return registration.pushManager.subscribe(subscribeOptions);
//         })
//         .then((pushSubscription) => {
//             console.log('Received PushSubscription: ', JSON.stringify(pushSubscription));
//             storePushSubscription(pushSubscription);
//         }).catch(error => {
//             console.error('Error subscribing user:', error);
//         });
// }

// function urlBase64ToUint8Array(base64String) {
//     var padding = '='.repeat((4 - base64String.length % 4) % 4);
//     var base64 = (base64String + padding)
//         .replace(/\-/g, '+')
//         .replace(/_/g, '/');

//     var rawData = window.atob(base64);
//     var outputArray = new Uint8Array(rawData.length);

//     for (var i = 0; i < rawData.length; ++i) {
//         outputArray[i] = rawData.charCodeAt(i);
//     }
//     return outputArray;
// }

// function getPublicKey() {
//     const { key } = fetch('/push/key', {
//         headers: {
//             Accept: 'application/json'
//         }
//     }).then(r => r.json());

//     return key;
// }

// function getPublicKey() {
//     return fetch('/push/key', {
//         headers: {
//             Accept: 'application/json'
//         }
//     })
//     .then(response => response.json())
//     .then(data => data.key);
// }


// function storePushSubscription(pushSubscription) {
//     const token = document.querySelector('meta[name=csrf-token]').getAttribute('content');

//     fetch('/push/subscribe', {
//         method: 'POST',
//         body: JSON.stringify(pushSubscription),
//         headers: {
//             'Accept': 'application/json',
//             'Content-Type': 'application/json',
//             'X-CSRF-Token': token
//         }
//     })
//         .then((res) => {
//             return res.json();
//         })
//         .then((res) => {
//             console.log(res)
//         })
//         .catch((err) => {
//             console.log(err)
//         });
// }






function main() {
    const permission = document.getElementById('push-permission');
    if ((!permission && !('Notification' in window) && !('serviceWorker' in navigator)) || Notification.permission != 'default') {
        return;
    }

    if (!"PushManager" in window) {
        //push isn't supported
        return;
    }

    const button = document.createElement('button');
    button.classList.add('btn');
    button.classList.add('btn-dark');
    button.innerText = 'Recevoir des notifications';
    if (permission) {
        permission.appendChild(button);
    }
    button.addEventListener('click', askPermission)

}

async function askPermission() {
    const permission = await Notification.requestPermission();
    if (permission == 'granted') {
        registerServiceWorker();
        $('#push-permission').empty();
    }
}

async function registerServiceWorker() {
    try{
        const registration = await navigator.serviceWorker.register('/assets/js/sw.js');
        let subscription = await registration.pushManager.getSubscription();


        if (!subscription) {

            console.log(urlBase64ToUint8Array(await getPublicKey()));

            subscription = await registration.pushManager.subscribe({
                userVisibleOnly: true,
                applicationServerKey: urlBase64ToUint8Array(await getPublicKey())
            });

            console.log(subscription);
        }

        await saveSubscription(subscription);
    } catch (error) {
        console.error('Error in registerServiceWorker :', error);
        registerServiceWorker();
    }
}

async function getPublicKey() {
    const { key } = await fetch('/push/key', {
        headers: {
            Accept: 'application/json'
        }
    }).then(r => r.json());

    return key;
}

async function saveSubscription(subscription) {
    await fetch('/notifications/subscribe', {
        method: 'post',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        body: JSON.stringify(subscription)
    }).then((res) => {
        console.log(res);
        main();
    });
}

function urlBase64ToUint8Array(base64String) {
    var padding = "=".repeat((4 - base64String.length % 4) % 4);
    var base64 = (base64String + padding).replace(/\-/g, "+").replace(/_/g, "/");
    var rawData = window.atob(base64);
    var outputArray = new Uint8Array(rawData.length);

    for (var i = 0; i < rawData.length; ++i) {
        outputArray[i] = rawData.charCodeAt(i);
    }

    return outputArray;
}

main();
