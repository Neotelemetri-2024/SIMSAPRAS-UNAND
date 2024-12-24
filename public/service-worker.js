importScripts("https://js.pusher.com/beams/service-worker.js");

console.log("Service Worker loaded");

self.addEventListener("push", function(event) {
    console.log("Push event received in SW:", event);
    if (!event.data) {
        console.log("No data received in push event");
        return;
    }

    try {
        const payload = event.data.json();
        console.log("Parsed payload in SW:", payload);

        const notificationOptions = {
            body: payload.notification.body,
            icon: payload.notification.icon || '/path/to/default/icon.png',
            data: payload.notification
        };

        event.waitUntil(
            self.registration.showNotification(payload.notification.title, notificationOptions)
        );

        self.clients.matchAll({
            type: 'window',
            includeUncontrolled: true
        }).then(clients => {
            console.log("Found clients:", clients.length);
            clients.forEach(client => {
                console.log("Posting message to client");
                client.postMessage({
                    type: 'PUSH_NOTIFICATION',
                    data: payload.notification
                });
            });
        });
    } catch (error) {
        console.error("Error handling push event:", error);
    }
});

self.addEventListener('notificationclick', function(event) {
    console.log('Notification click received in SW');
    event.notification.close();

    if (event.notification.data && event.notification.data.deep_link) {
        event.waitUntil(
            clients.openWindow(event.notification.data.deep_link)
        );
    }
});

self.addEventListener("install", function(event) {
    console.log("Service Worker installing...");
    event.waitUntil(self.skipWaiting());
});

self.addEventListener("activate", function(event) {
    event.waitUntil(self.clients.claim());
});