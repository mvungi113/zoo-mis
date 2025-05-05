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
    // Import Firebase modules
    import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-app.js";
    import { getDatabase, ref, onChildAdded } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-database.js";

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

    const notifRef = ref(db, "notifications");

    const sounds = {
        "Hazard": new Audio("/sounds/hazard_sound.mp3"),
        "Warning": new Audio("/sounds/warning-sound.mp3"),
    };

    onChildAdded(notifRef, (snapshot) => {
        const data = snapshot.val();
        const type = data.type;
        const message = data.message;

        // Play sound
        if (sounds[type]) sounds[type].play();

        // Show popup (you can customize this further)
        const notif = document.createElement('div');
        notif.className = "fixed top-4 right-4 bg-white shadow-lg rounded p-4 border border-" + (type === "Hazard" ? "red-500" : "yellow-400") + " z-50";
        notif.innerHTML = `<strong>${type}:</strong> ${message}`;

        document.body.appendChild(notif);

        setTimeout(() => notif.remove(), 7000); // Auto-remove after 7 seconds
    });
</script>

    </body>
</html>
