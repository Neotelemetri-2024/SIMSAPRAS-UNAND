if ("serviceWorker" in navigator) {
    console.log("Starting service worker registration");

    // Unregister existing service workers
    navigator.serviceWorker
        .getRegistrations()
        .then(function (registrations) {
            console.log("Found existing registrations:", registrations);
            return Promise.all(registrations.map((r) => r.unregister()));
        })
        .then(() => {
            console.log("All old service workers unregistered");

            return navigator.serviceWorker.register("/service-worker.js");
        })
        .then((registration) => {
            console.log("Service Worker registered:", registration);

            // Initialize Beams
            const beamsClient = new PusherPushNotifications.Client({
                instanceId: "1c9ef4d6-c234-4989-852b-378a54f8d770",
            });

            console.log("Initializing Beams client");

            return beamsClient
                .start()
                .then(() => {
                    console.log("Beams started");
                    return beamsClient.addDeviceInterest("debug-peminjaman");
                })
                .then(() => {
                    console.log("Successfully added device interest");
                    console.log(
                        "Current service worker:",
                        navigator.serviceWorker.controller
                    );
                });
        })
        .catch((error) => {
            console.error("Setup failed:", error);
        });

    // Listen for messages
    navigator.serviceWorker.addEventListener("message", function (event) {
        console.log("Message received from SW:", event.data);
        if (event.data.type === "PUSH_NOTIFICATION") {
            console.log("Processing notification:", event.data.data);
            // Use the createNotificationBox function directly
            const notifData = event.data.data;
            createNotificationBox(
                notifData.title || "New Notification",
                notifData.message || notifData.body || ""
            );

            // Optional: Add to notification list if needed
            if (typeof displaylisnotifpage === "function") {
                displaylisnotifpage(event.data.data);
            }
        }
    });
}

// Add this to check permission
if ("Notification" in window) {
    Notification.requestPermission().then(function (permission) {
        console.log("Notification permission:", permission);
    });
}

function createNotificationBox(title, message) {
    console.log("Creating notification box:", { title, message }); // Debug log
    const notifBox = document.createElement("div");
    notifBox.className =
        "bg-white border border-gray-200 rounded-lg shadow-lg p-4 mb-3 max-w-sm transform transition-all duration-300 opacity-0";
    notifBox.style.transform = "translateX(100%)";
    notifBox.innerHTML = `
        <div class="flex items-start">
            <div class="ml-3 w-0 flex-1">
                <p class="text-sm font-medium text-gray-900">${title}</p>
                <p class="mt-1 text-sm text-gray-500">${message}</p>
            </div>
            <button class="ml-4 text-gray-400 hover:text-gray-500">
                <span class="sr-only">Close</span>
                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"/>
                </svg>
            </button>
        </div>
    `;

    // Ensure notification container exists
    let container = document.getElementById("notification-container");
    if (!container) {
        container = document.createElement("div");
        container.id = "notification-container";
        container.className = "fixed bottom-5 right-5 z-50";
        document.body.appendChild(container);
    }

    container.appendChild(notifBox);

    // Trigger animation after a brief delay
    requestAnimationFrame(() => {
        notifBox.style.transform = "translateX(0)";
        notifBox.style.opacity = "1";
    });

    // Auto-remove after 5 seconds
    setTimeout(() => {
        notifBox.style.transform = "translateX(100%)";
        notifBox.style.opacity = "0";
        setTimeout(() => notifBox.remove(), 300);
    }, 5000);

    // Close button handler
    notifBox.querySelector("button").addEventListener("click", () => {
        notifBox.style.transform = "translateX(100%)";
        notifBox.style.opacity = "0";
        setTimeout(() => notifBox.remove(), 300);
    });
}
