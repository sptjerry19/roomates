<?php

namespace App\Services;

use Google\Client as GoogleClient;

class GoogleClientService
{
    protected $client;

    public function __construct()
    {
        $this->client = new GoogleClient();
        $this->client->setClientId(env('GOOGLE_CLIENT_ID'));
        $this->client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
    }

    public function verifyIdToken($idToken)
    {
        return $this->client->verifyIdToken($idToken);
    }
}
