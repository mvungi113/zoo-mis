<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Database;

class FirebaseService
{
    protected Database $database;

    public function __construct()
    {
        $factory = (new Factory)
            ->withServiceAccount(config('firebase.credentials'))
            ->withDatabaseUri(config('firebase.database.url'));

        $this->database = $factory->createDatabase();
    }

    public function pushLog(array $logData)
    {
        $this->database
            ->getReference('zoo_logs')
            ->push($logData);
    }

    public function getLogs()
    {
        return $this->database
            ->getReference('zoo_logs')
            ->getValue();
    }
}
