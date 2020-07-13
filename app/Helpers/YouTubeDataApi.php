<?php


namespace App\Helpers;


use Illuminate\Support\Facades\Cache;

class YouTubeDataApi
{
    public static function channelId(string $id) {
        $url = 'https://www.googleapis.com/youtube/v3/channels?id=' . $id . '&key=' . env('YOUTUBE_DATA_API_KEY') . '&part=snippet';
        $data = file_get_contents($url);
        $data = json_decode($data, true);
        return $data;
    }

    /**
     * YouTubeチャンネルのユーザー名を返します。
     *
     * @param string $channel_id
     * @return string|null
     */
    public static function getYouTubeChannelName($channel_id) {
        $channel_name = null;
        if (!is_string($channel_id) || !preg_match('/^(channel|user)\/[a-zA-Z0-9\-]+$/', $channel_id)) {
            return null;
        }
        $channel_name = Cache::get('youtube_channel_name_' . base64_encode($channel_id));
        if ($channel_name === null) {
            if (0 === strncmp($channel_id, 'user', 4)) {
                $channel_name = file_get_contents('https://www.googleapis.com/youtube/v3/channels?forUsername=' . substr($channel_id, 5) . '&key=AIzaSyBkuIUEx9im7B20vAgb7lYDSxVChYCsgjA&part=snippet');
            } elseif (0 === strncmp($channel_id, 'channel', 7)) {
                $channel_name = file_get_contents('https://www.googleapis.com/youtube/v3/channels?id=' . substr($channel_id, 8) . '&key=AIzaSyBkuIUEx9im7B20vAgb7lYDSxVChYCsgjA&part=snippet');
            }
            $channel_name = ($channel_name !== null && trim($channel_name) !== '' && $channel_name !== false) ? json_decode($channel_name, true) : null;
            if (is_array($channel_name) && isset($channel_name['items'])) {
                $channel_name = $channel_name['items'][0]['snippet']['title'];
                if (!isset($channel_name) || $channel_name === null) {
                    return null;
                }
                Cache::put('youtube_channel_name_' . base64_encode($channel_id), $channel_name, 86400);
            } else {
                return $channel_id;
            }
        }
        return $channel_name;
    }
}
