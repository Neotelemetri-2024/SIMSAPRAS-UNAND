importScripts("https://js.pusher.com/beams/service-worker.js");

self.addEventListener("push", function (event) {
    if (!event.data) {
        return;
    }

    try {
        const payload = event.data.json();

        const notificationOptions = {
            body: payload.notification.body,
            icon: payload.notification.icon || "/path/to/default/icon.png",
            data: payload.notification,
        };

        event.waitUntil(
            self.registration.showNotification(
                payload.notification.title,
                notificationOptions
            )
        );

        self.clients
            .matchAll({
                type: "window",
                includeUncontrolled: true,
            })
            .then((clients) => {
                clients.forEach((client) => {
                    client.postMessage({
                        type: "PUSH_NOTIFICATION",
                        data: payload.notification,
                    });
                });
            });
    } catch (error) {}
});

self.addEventListener("notificationclick", function (event) {
    event.notification.close();

    if (event.notification.data && event.notification.data.deep_link) {
        event.waitUntil(clients.openWindow(event.notification.data.deep_link));
    }
});

self.addEventListener("install", function (event) {
    event.waitUntil(self.skipWaiting());
});

self.addEventListener("activate", function (event) {
    event.waitUntil(self.clients.claim());
});
