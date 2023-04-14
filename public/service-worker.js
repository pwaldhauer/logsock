// Register event listener for the 'push' event.
self.addEventListener('push', function(event) {
    // Keep the service worker alive until the notification is created.

    const payload = event.data ? event.data.json() : 'no payload';

    event.waitUntil(
        self.registration.showNotification(
            payload.title ?? 'Logsock', {
            body: payload.body ?? 'No body attached',
        })
    );
});
