<?php
// config/firebase.php
// This file is part of the Zoomis project.

return [
    'credentials' => storage_path('app/firebase/firebase_credentials.json'),

    'database' => [
        'url' => env('FIREBASE_DATABASE_URL'),
    ],
];
