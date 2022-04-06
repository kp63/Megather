<?php

namespace App\Helpers;

use Google\Exception;
use Google\Service\Sheets;
use Google_Client;
use Google_Service_Sheets;
use function storage_path;

class GoogleSheets
{
    public static Sheets|null $instance = null;

    /**
     * @return Google_Service_Sheets|null
     * @throws Exception
     */
    public static function i(): ?Google_Service_Sheets
    {
        if (static::$instance !== null)
            return static::$instance;

        $credentials_path = storage_path('app/json/credentials.json');
        $client = new Google_Client();
        $client->setScopes([Google_Service_Sheets::SPREADSHEETS]);
        $client->setAuthConfig($credentials_path);
        static::$instance = new Google_Service_Sheets($client);

        return static::$instance;
    }
}
