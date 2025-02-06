<?php

namespace App\Services;

use Google\Client;
use Google\Service\Gmail;

class GmailService
{
    protected $client;
    protected $gmail;

    public function __construct()
    {
        $this->client = new Client();
        $this->client->setClientId(env('GOOGLE_CLIENT_ID'));
        $this->client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $this->client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));
        $this->client->addScope(Gmail::GMAIL_READONLY);
    }

    public function getAuthUrl()
    {
        return $this->client->createAuthUrl();
    }

    public function fetchAccessToken($code)
    {
        $this->client->fetchAccessTokenWithAuthCode($code);
        return $this->client->getAccessToken();
    }

    public function getGmailService()
    {
        // Retrieve the access token from the session
        $accessToken = session('google_access_token');

        // Check if the access token is available
        if (!$accessToken) {
            throw new \Exception("Access token is missing.");
        }

        // Set the access token to the Google Client
        $this->client->setAccessToken($accessToken);

        // Check if the access token is set correctly
        if (!$this->client->getAccessToken()) {
            throw new \Exception("Failed to set the access token.");
        }

        return new Gmail($this->client);
    }

}
