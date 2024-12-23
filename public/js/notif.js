if ("serviceWorker" in navigator) {
    navigator.serviceWorker
        .register("/service-worker.js")
        .then((registration) => {
            console.log(
                "Service Worker registered with scope:",
                registration.scope
            );
        })
        .catch((err) => {
            console.error("Service Worker registration failed:", err);
        });
}

if ("serviceWorker" in navigator) {
    navigator.serviceWorker
        .register("/service-worker.js")
        .then((registration) => {
            console.log("Service Worker registered");

            // Inisialisasi Pusher Beams
            const beamsClient = new PusherPushNotifications.Client({
                instanceId: "1c9ef4d6-c234-4989-852b-378a54f8d770",
            });

            beamsClient
                .start()
                .then(() => beamsClient.addDeviceInterest("hello"))
                .then(() => console.log("Successfully registered device"))
                .catch(console.error);
        })
        .catch((err) => {
            console.error("Service Worker registration failed:", err);
        });
}
