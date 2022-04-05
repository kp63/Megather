<?php


namespace App\Helpers;


use Illuminate\Support\Facades\Cache;

class YouTubeDataApi
{

    /**
     * YouTube Data APIと通信してチャンネルIDからチャンネル名を取得します。
     *
     * @param string $channel_id チャンネルID
     * @return null|string チャンネル名
     */
    public static function getChannelNameFromChannelId(string $channel_id): ?string
    {
        if (!config('api.youtube_data_api_key') || !preg_match('/^[a-zA-Z0-9\-_]{1,60}$/', $channel_id))
            return null;

        $query = [
            'id' => $channel_id,
            'key' => config('api.youtube_data_api_key'),
            'part' => 'snippet',
        ];

        $url = 'https://www.googleapis.com/youtube/v3/channels?' . http_build_query($query);
        $data = file_get_contents($url);
        $data = json_decode($data);
        return $data->items[0]->snippet->title ?? null;
    }

    /**
     * キャッシュを取得またはYouTube Data APIと通信してチャンネルIDからチャンネル名を取得します。
     *
     * @param string $channel_id チャンネルID
     * @return null|string ユーザー名
     */
    public static function getChannelNameFromChannelIdUsingCache(string $channel_id): ?string
    {
        if (!config('api.youtube_data_api_key') || !preg_match('/^[a-zA-Z0-9\-_]+$/', $channel_id))
            return null;

        $cache_prefix = 'youtube_channel_name_';

        $channel_name = Cache::get($cache_prefix . base64_encode($channel_id));
        if ($channel_name !== null)
            return $channel_name;

        $channel_name = self::getChannelNameFromChannelId($channel_id);
        if ($channel_name !== false) {
            Cache::put($cache_prefix . base64_encode($channel_id), $channel_name, 86400); // 1 day cache
            return $channel_name;
        }

        return null;
    }

    /**
     * チャンネルIDからチャンネル名を取得します。
     *
     * @param string $channel_id チャンネルID
     * @return null|string ユーザー名
     */
    public static function getChannelName(string $channel_id): ?string
    {
        return self::getChannelNameFromChannelIdUsingCache($channel_id);
    }
}
