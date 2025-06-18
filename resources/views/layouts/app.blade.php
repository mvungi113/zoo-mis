<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Zoo Intelligence') }}</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/favicon.png">
    
    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 dark:from-gray-900 dark:via-blue-900/40 dark:to-indigo-900/40 relative">
        <!-- Floating Background Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-0 -right-40 w-80 h-80 bg-purple-200/30 dark:bg-purple-900/20 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob"></div>
            <div class="absolute -bottom-8 left-20 w-72 h-72 bg-blue-200/30 dark:bg-blue-900/20 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-2000"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-indigo-200/20 dark:bg-indigo-900/10 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-4000"></div>
        </div>
        
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm shadow-md">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main class="relative z-10">
            {{ $slot }}
        </main>
        
        <!-- Footer -->
        <footer class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm shadow-inner mt-auto">
            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row justify-between items-center text-sm text-gray-500 dark:text-gray-400">
                    <div class="mb-2 md:mb-0">
                        <span>© {{ date('Y') }} Zoo Intelligence System</span>
                    </div>
                    <div class="flex space-x-4">
                        <a href="#" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition">Developed by ROGASIAN G HAJI</a>
                      
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- Notification Container with Enhanced Styling -->
    <div id="notif-container" class="fixed top-4 right-4 z-50 flex flex-col space-y-3 max-w-xs w-full"></div>

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

        function createNotification(type, message) {
            const notif = document.createElement('div');
            notif.className = 
                "relative flex items-start shadow-lg rounded-lg px-4 py-3 pr-10 backdrop-blur-sm border animate-slide-in " +
                (type === "Hazard"
                    ? "bg-red-600/95 text-white border-l-4 border-red-800"
                    : "bg-yellow-400/95 text-gray-900 border-l-4 border-yellow-600");

            notif.innerHTML = `
                <div class="mr-3 mt-0.5">
                    ${type === "Hazard"
                        ? `<div class="bg-red-700/50 p-2 rounded-full">
                             <i class="bi bi-exclamation-triangle-fill text-white text-lg"></i>
                           </div>`
                        : `<div class="bg-yellow-500/50 p-2 rounded-full">
                             <i class="bi bi-exclamation-circle-fill text-yellow-900 text-lg"></i>
                           </div>`
                    }
                </div>
                <div class="flex-1">
                    <div class="font-semibold">${type} Alert</div>
                    <div class="text-sm opacity-90">${message}</div>
                </div>
                <button class="absolute top-2 right-2 text-xl font-bold focus:outline-none hover:opacity-70 transition" aria-label="Close">&times;</button>
            `;

            notif.querySelector('button').onclick = () => {
                notif.style.opacity = 0;
                notif.style.transform = "translateX(40px)";
                setTimeout(() => notif.remove(), 400);
            };

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

            document.getElementById('notif-container').appendChild(notif);
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
        /* Add animations for background elements and notifications */
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob {
            animation: blob 7s infinite alternate;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }
        
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
