<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\YouTubeDataAPI
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\YouTubeDataAPI newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\YouTubeDataAPI newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\YouTubeDataAPI query()
 * @mixin \Eloquent
 */
class YouTubeDataAPI extends Model
{
    public static function channelId(string $id) {
        $url = 'https://www.googleapis.com/youtube/v3/channels?id=' . $id . '&key=' . env('YOUTUBE_DATA_API_KEY') . '&part=snippet';
        $data = file_get_contents($url);
        $data = json_decode($data, true);
        return $data;
    }
}
