// Definisikan TokenProvider
const beamsTokenProvider = new PusherPushNotifications.TokenProvider({
    url: "/beams/auth"
});

async function initializeNotifications() {
    if (!("serviceWorker" in navigator) || !("Notification" in window)) {
        console.error("Push notifications not supported");
        return;
    }

    try {
        // Register service worker
        const registration = await navigator.serviceWorker.register('/service-worker.js');
        console.log('Service Worker registered:', registration);

        const permission = await Notification.requestPermission();
        console.log('Notification permission status:', permission);
        
        if (permission !== "granted") {
            console.warn("Notification permission denied");
            return;
        }

        // Get user ID from meta tag
        const userId = document.querySelector('meta[name="user-id"]').content;
        console.log('User ID:', userId);

        // Initialize Beams Client dengan TokenProvider
        const beamsClient = new PusherPushNotifications.Client({
            instanceId: "1c9ef4d6-c234-4989-852b-378a54f8d770",
            tokenProvider: beamsTokenProvider
        });

        // Start dan setup Beams Client
        await beamsClient.start()
            .then(() => beamsClient.setUserId(userId, beamsTokenProvider))
            .then(() => console.log('Notification setup complete'))
            .catch(error => {
                console.error('Beams setup error:', error);
                throw error;
            });

        // Setup event listener untuk service worker
        navigator.serviceWorker.addEventListener('message', function(event) {
            console.log('Received message from service worker:', event);
            if (event.data.type === 'PUSH_NOTIFICATION') {
                createNotificationBox(event.data.data.title, event.data.data.body);
            }
        });

        // Cleanup function
        window.handlePushNotificationLogout = async () => {
            try {
                await beamsClient.stop();
                console.log('Beams client stopped successfully');
                
                const registration = await navigator.serviceWorker.ready;
                await registration.unregister();
                console.log('Service worker unregistered');
            } catch (error) {
                console.error('Error during push notification logout:', error);
            }
        };

    } catch (error) {
        console.error('Notification setup failed:', error);
        createNotificationBox('Notification Error', error.message);
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', initializeNotifications);

// Cleanup on page unload
window.addEventListener('beforeunload', () => {
    if (window.handlePushNotificationLogout) {
        window.handlePushNotificationLogout();
    }
});

function createNotificationBox(title, message) {
    console.log("Creating notification box:", { title, message });
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

    let container = document.getElementById("notification-container");
    if (!container) {
        container = document.createElement("div");
        container.id = "notification-container";
        container.className = "fixed bottom-5 right-5 z-50";
        document.body.appendChild(container);
    }

    container.appendChild(notifBox);

    requestAnimationFrame(() => {
        notifBox.style.transform = "translateX(0)";
        notifBox.style.opacity = "1";
    });

    setTimeout(() => {
        notifBox.style.transform = "translateX(100%)";
        notifBox.style.opacity = "0";
        setTimeout(() => notifBox.remove(), 300);
    }, 5000);

    notifBox.querySelector("button").addEventListener("click", () => {
        notifBox.style.transform = "translateX(100%)";
        notifBox.style.opacity = "0";
        setTimeout(() => notifBox.remove(), 300);
    });
}