const beamsClient = new PusherPushNotifications.Client({
    instanceId: "1c9ef4d6-c234-4989-852b-378a54f8d770",
});

function createNotificationBox(title, message) {
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

    document.getElementById("notification-container").appendChild(notifBox);

    setTimeout(() => {
        notifBox.style.transform = "translateX(0)";
        notifBox.style.opacity = "1";
    }, 100);

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

beamsClient
    .start()
    .then(() => beamsClient.addDeviceInterest("peminjaman"))
    .then(() => {
        beamsClient.onNotification((notification) => {
            createNotificationBox(
                notification.notification.title,
                notification.notification.body
            );
        });
    })
    .catch(console.error);
