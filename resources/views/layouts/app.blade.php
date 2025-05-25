<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <!-- Firebase SDK -->
<script type="module">
    import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-app.js";
    import { getDatabase, ref, query, orderByChild, startAt, onChildAdded } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-database.js";

    const firebaseConfig = {
        apiKey: "AIzaSyC1xwzo3QBVTKrvvLXHg35HhyR1EoGIfPI",
        authDomain: "zoomisapi.firebaseapp.com",
        databaseURL: "https://zoomisapi-default-rtdb.firebaseio.com",
        projectId: "zoomisapi",
        storageBucket: "zoomisapi.firebasestorage.app",
        messagingSenderId: "1075730501303",
        appId: "1:1075730501303:web:685034df168130ab2e8732",
    };

    const app = initializeApp(firebaseConfig);
    const db = getDatabase(app);

    // Get seen notification keys from localStorage
    let seenKeys = JSON.parse(localStorage.getItem('seenNotifKeys') || '[]');

    // Query all notifications with timestamp >= (now - 1 minute) to avoid missing any
    const now = Date.now();
    const notifRef = query(
        ref(db, "notifications"),
        orderByChild("timestamp"),
        startAt(now - 60000)
    );

    const sounds = {
        "Hazard": new Audio("/sounds/hazard_sound.mp3"),
        "Warning": new Audio("/sounds/warning-sound.mp3"),
    };

    let notifContainer = document.getElementById('notif-container');
    if (!notifContainer) {
        notifContainer = document.createElement('div');
        notifContainer.id = 'notif-container';
        notifContainer.className = "fixed top-4 right-4 z-50 flex flex-col space-y-3 max-w-xs w-full";
        document.body.appendChild(notifContainer);
    }

    function createNotification(type, message) {
        const notif = document.createElement('div');
        notif.className =
            "relative flex items-start shadow-lg rounded-lg px-4 py-3 pr-10 animate-slide-in " +
            (type === "Hazard"
                ? "bg-red-600 text-white border-l-4 border-red-800"
                : "bg-yellow-400 text-gray-900 border-l-4 border-yellow-600");

        notif.innerHTML = `
            <span class="mr-3 mt-1">
                ${type === "Hazard"
                    ? `<svg class="w-6 h-6 text-white animate-pulse" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M21 12A9 9 0 113 12a9 9 0 0118 0z" /></svg>`
                    : `<svg class="w-6 h-6 text-yellow-700 animate-bounce" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M21 12A9 9 0 113 12a9 9 0 0118 0z" /></svg>`
                }
            </span>
            <div>
                <div class="font-bold">${type} Alert</div>
                <div class="text-sm">${message}</div>
            </div>
            <button class="absolute top-2 right-2 text-xl font-bold focus:outline-none" aria-label="Close">&times;</button>
        `;

        notif.querySelector('button').onclick = () => notif.remove();

        notif.style.opacity = 0;
        notif.style.transform = "translateX(40px)";
        setTimeout(() => {
            notif.style.opacity = 1;
            notif.style.transform = "translateX(0)";
            notif.style.transition = "all 0.4s cubic-bezier(.4,2,.6,1)";
        }, 10);

        setTimeout(() => {
            notif.style.opacity = 0;
            notif.style.transform = "translateX(40px)";
            setTimeout(() => notif.remove(), 400);
        }, 7000);

        notifContainer.appendChild(notif);
    }

    onChildAdded(notifRef, (snapshot) => {
        const key = snapshot.key;
        if (seenKeys.includes(key)) return; // Already seen

        const data = snapshot.val();
        const type = data.type;
        const message = data.message;

        if (sounds[type]) sounds[type].play();
        createNotification(type, message);

        // Mark as seen
        seenKeys.push(key);
        // Keep only the last 50 keys to avoid localStorage bloat
        if (seenKeys.length > 50) seenKeys = seenKeys.slice(-50);
        localStorage.setItem('seenNotifKeys', JSON.stringify(seenKeys));
    });
</script>
<style>
/* Add slide-in animation for notifications */
@keyframes slide-in {
    from { opacity: 0; transform: translateX(40px);}
    to { opacity: 1; transform: translateX(0);}
}
.animate-slide-in {
    animation: slide-in 0.4s cubic-bezier(.4,2,.6,1);
}
</style>

    </body>
</html>
