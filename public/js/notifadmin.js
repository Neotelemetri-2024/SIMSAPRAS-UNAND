let hasNewNotifications = false;

function isNotificationPage() {
    return window.location.pathname === "/admin/notifikasi";
}

function updateNotificationBadge(show) {
    const badge = document.querySelector(".notification-badge");
    if (badge) {
        badge.style.display = show ? "flex" : "none";
    }
    localStorage.setItem("hasNewNotifications", show);
}

if ("serviceWorker" in navigator) {
    navigator.serviceWorker
        .getRegistrations()
        .then(() => {
            return navigator.serviceWorker.register("/service-worker.js");
        })
        .then((registration) => {
            const beamsClient = new PusherPushNotifications.Client({
                instanceId: "a4ee9c23-af7c-4ff5-906a-76a948d016b1",
            });

            return beamsClient
                .start()
                .then(() => {
                    return beamsClient.getDeviceInterests();
                })
                .then((interests) => {
                    if (!interests.includes("peminjamanadmin")) {
                        return beamsClient.addDeviceInterest("peminjamanadmin");
                    } else {
                    }
                });
        })
        .catch((error) => {});

    navigator.serviceWorker.addEventListener("message", function (event) {
        if (event.data.type === "PUSH_NOTIFICATION") {
            const notifData = event.data.data;
            createNotificationBox(
                notifData.title || "New Notification",
                notifData.message || notifData.body || ""
            );

            hasNewNotifications = true;
            if (!isNotificationPage()) {
                updateNotificationBadge(true);
            }

            if (typeof displaylisnotifpage === "function") {
                displaylisnotifpage(event.data.data);
            }
        }
    });
}

if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initializeNotificationButton);
} else {
    initializeNotificationButton();
}

function cleanup() {
    hasNewNotifications = false;
    updateNotificationBadge(false);
}

if ("Notification" in window) {
    Notification.requestPermission().then(function (permission) {});
}

function createNotificationBox(title, message) {
    hasNewNotifications = true;
    if (!isNotificationPage()) {
        updateNotificationBadge(true);
    }

    if (!title || !message) {
        return;
    }

    const notifBox = document.createElement("div");
    notifBox.className =
        "bg-white backdrop-blur-lg bg-opacity-95 border border-gray-100 " +
        "rounded-xl shadow-lg p-4 mb-4 max-w-sm transform transition-all " +
        "duration-300 opacity-0 hover:shadow-2xl hover:scale-105";
    notifBox.style.transform = "translateX(100%)";

    const safeTitle = document.createTextNode(title).textContent;
    const safeMessage = document.createTextNode(message).textContent;

    notifBox.innerHTML = `
        <div class="flex items-start space-x-4">
            <!-- Icon container -->
            <div class="flex-shrink-0 bg-blue-50 rounded-full p-2">
                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                    </path>
                </svg>
            </div>
            
            <!-- Content -->
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-gray-900 mb-1">
                    ${safeTitle}
                </p>
                <p class="text-sm text-gray-500 line-clamp-2">
                    ${safeMessage}
                </p>
                <div class="mt-2 h-1 w-full bg-gray-100 rounded">
                    <div class="h-1 bg-blue-500 rounded progress-bar"></div>
                </div>
            </div>
            
            <!-- Close button -->
            <button class="flex-shrink-0 ml-4 text-gray-400 hover:text-gray-600 
                          transition-colors duration-200 focus:outline-none">
                <span class="sr-only">Close</span>
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>
    `;

    if (!document.querySelector("#notification-style")) {
        const style = document.createElement("style");
        style.id = "notification-style";
        style.textContent = `
            @keyframes progress {
                from { width: 100%; }
                to { width: 0%; }
            }
            .progress-bar {
                animation: progress 5s linear forwards;
            }
        `;
        document.head.appendChild(style);
    }

    let container = document.getElementById("notification-container");
    if (!container) {
        container = document.createElement("div");
        container.id = "notification-container";
        container.className =
            "fixed bottom-5 right-5 z-50 flex flex-col items-end space-y-2";
        document.body.appendChild(container);
    }

    container.appendChild(notifBox);

    requestAnimationFrame(() => {
        notifBox.style.transform = "translateX(0) translateY(0)";
        notifBox.style.opacity = "1";
    });

    const hideTimeout = setTimeout(() => {
        hideNotification(notifBox);
    }, 5000);

    const closeButton = notifBox.querySelector("button");
    closeButton.addEventListener("click", () => {
        clearTimeout(hideTimeout);
        hideNotification(notifBox);
    });

    notifBox.addEventListener("mouseenter", () => {
        notifBox.querySelector(".progress-bar").style.animationPlayState =
            "paused";
    });

    notifBox.addEventListener("mouseleave", () => {
        notifBox.querySelector(".progress-bar").style.animationPlayState =
            "running";
    });
}

function initializeNotificationButton() {
    const notifButton = document.querySelector(".notification-button");
    if (notifButton) {
        notifButton.innerHTML = `
            <span class="sr-only">View notifications</span>
            <div class="relative inline-block">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path>
                </svg>
                <div class="notification-badge absolute top-0 right-0 w-3 h-3 bg-red-500 rounded-full flex items-center justify-center" style="display: none;"></div>
            </div>
        `;

        notifButton.addEventListener("click", handleNotificationClick);

        const hasNewNotifications =
            localStorage.getItem("hasNewNotifications") === "true";

        if (isNotificationPage()) {
            updateNotificationBadge(false);
        } else {
            updateNotificationBadge(hasNewNotifications);
        }
    }
}

function handleNotificationClick() {
    hasNewNotifications = false;
    updateNotificationBadge(false);

    window.location.href = "/admin/notifikasi";
}

function hideNotification(notifBox) {
    notifBox.style.transform = "translateX(100%) translateY(10px)";
    notifBox.style.opacity = "0";
    setTimeout(() => {
        notifBox.remove();
    }, 300);
}
