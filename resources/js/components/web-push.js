function registerPushStuff () {
    if (!('serviceWorker' in navigator)) {
        // Service Worker isn't supported on this browser, disable or hide UI.
        return;
    }

    if (!('PushManager' in window)) {
        // Push isn't supported on this browser, disable or hide UI.
        return;
    }

    return navigator.serviceWorker
        .register('/service-worker.js')
        .then(function (registration) {
            return registration;
        })
        .catch(function (err) {
            console.error('Unable to register service worker.', err);
        });
}


function askPermission () {
    return new Promise(function (resolve, reject) {
        const permissionResult = Notification.requestPermission(function (result) {
            resolve(result);
        });

        if (permissionResult) {
            permissionResult.then(resolve, reject);
        }
    }).then(function (permissionResult) {
        if (permissionResult !== 'granted') {
            throw new Error("We weren't granted permission.");
        }
    });
}

function urlBase64ToUint8Array (base64String) {
    var padding = '='.repeat((4 - base64String.length % 4) % 4);
    var base64 = (base64String + padding)
        .replace(/\-/g, '+')
        .replace(/_/g, '/');

    var rawData = window.atob(base64);
    var outputArray = new Uint8Array(rawData.length);

    for (var i = 0; i < rawData.length; ++i) {
        outputArray[i] = rawData.charCodeAt(i);
    }
    return outputArray;
}

function subscribeUserToPush (publicKey) {
    return new Promise((resolve, reject) => {
        navigator.serviceWorker
            .register('/service-worker.js')

            .then(function (registration) {
                const subscribeOptions = {
                    userVisibleOnly: true,
                    applicationServerKey: urlBase64ToUint8Array(
                        publicKey,
                    ),
                };

                return registration.pushManager.subscribe(subscribeOptions);
            })
            .then(async function (pushSubscription) {
                console.log(
                    'Received PushSubscription: ',
                    JSON.stringify(pushSubscription),
                );

                resolve(
                    JSON.parse(JSON.stringify(pushSubscription))
                );
            });
    });
}


export default ({publicKey}) => ({

    publicKey,

    async subscribe() {

        const subscription = await subscribeUserToPush(this.publicKey);
        this.$wire.call('saveSubscription', {
            endpoint: subscription.endpoint,
            key: subscription.keys.p256dh,
            auth: subscription.keys.auth,
        });

    }

})
