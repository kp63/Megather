<?php


namespace App\Helpers;


use Illuminate\Support\Facades\Cache;

class YouTubeDataApi
{

    /**
     * YouTube Data APIと通信してチャンネルIDからチャンネル名を取得します。
     *
     * @param string $channel_id チャンネルID
     * @return false|string チャンネル名
     */
    public static function getChannelNameFromChannelId(string $channel_id) {
        $url = 'https://www.googleapis.com/youtube/v3/channels?id=' . urlencode($channel_id) . '&key=' . env('YOUTUBE_DATA_API_KEY') . '&part=snippet';
        $data = file_get_contents($url);
        $data = json_decode($data, true);
        return isset($data['items'][0]['snippet']['title']) ? $data['items'][0]['snippet']['title'] : false;
    }

    /**
     * キャッシュを取得またはYouTube Data APIと通信してチャンネルIDからチャンネル名を取得します。
     *
     * @param string $channel_id チャンネルID
     * @return false|string ユーザー名
     */
    public static function getChannelNameFromChannelIdUsingCache(string $channel_id) {
        if (!preg_match('/^[a-zA-Z0-9\-_]+$/', $channel_id)) return false;

        $cache_prefix = 'youtube_channel_name_';

        $channel_name = Cache::get($cache_prefix . base64_encode($channel_id));
        if ($channel_name === null) {
            $channel_name = self::getChannelNameFromChannelId($channel_id);
            if ($channel_name !== false) {
                Cache::put($cache_prefix . base64_encode($channel_id), $channel_name, 86400); // 1 day cache
                return $channel_name;
            }
        }
        return $channel_id;
    }

    /**
     * チャンネルIDからチャンネル名を取得します。
     *
     * @param string $channel_id チャンネルID
     * @return false|string ユーザー名
     */
    public static function getChannelName(string $channel_id) {
        return self::getChannelNameFromChannelIdUsingCache($channel_id);
    }
}
