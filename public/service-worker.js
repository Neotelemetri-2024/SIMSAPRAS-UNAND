importScripts("https://js.pusher.com/beams/service-worker.js");

console.log("Service Worker loaded");

PusherPushNotifications.onNotificationReceived = ({ pushEvent, payload }) => {
    console.log("RAW Notification received in SW:", pushEvent);
    console.log("RAW Payload received in SW:", payload);

    pushEvent.waitUntil(
        self.registration.showNotification(payload.notification.title, {
            body: payload.notification.body,
            icon: payload.notification.icon,
            deep_link: payload.notification.deep_link,
            data: payload.data,
            actions: [{ action: "open_url", title: "Open" }],
        })
    );

    self.clients.matchAll().then((clients) => {
        console.log("Found clients:", clients);
        clients.forEach((client) => {
            console.log("Attempting to post message to client:", client);
            client.postMessage({
                type: "PUSH_NOTIFICATION",
                data: payload.notification,
            });
        });
    });
};

self.addEventListener("push", function (event) {
    console.log("Push event received:", event);
});

self.addEventListener("install", function (event) {
    console.log("Service Worker installing.");
    self.skipWaiting();
});

self.addEventListener("activate", function (event) {
    console.log("Service Worker activating.");
    event.waitUntil(clients.claim());
});
