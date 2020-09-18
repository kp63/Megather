<?php

namespace App;

use Google_Client;
use Google_Service_Sheets;
use Illuminate\Database\Eloquent\Model;

class GoogleSheets extends Model
{
    public static $instance = null;

    public static function i() {
        if (self::$instance !== null) return self::$instance;

        $credentials_path = storage_path('app/json/credentials.json');
        $client = new Google_Client();
        $client->setScopes([Google_Service_Sheets::SPREADSHEETS]);
        $client->setAuthConfig($credentials_path);
        self::$instance = new Google_Service_Sheets($client);

        return self::$instance;
    }
}
