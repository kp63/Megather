<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Profile extends Model
{
    protected $table = 'profiles';
    protected $guarded = [];
    protected $casts = ['links' => 'json'];

    /**
     * @param $data
     * @return bool 結果
     */
    public static function store($data)
    {
        $user = User::find(Auth::id());
        $user->username = $data['username'] ?? Auth::user()->username;

        if (isset($data['username_updated_at'])) {
            $user->username_updated_at = $data['username_updated_at'];
        }

        $prof = Profile::find(Auth::id());

        $links_youtube = null;
        if (isset($data['links-youtube']) && $data['links-youtube'] !== null && trim($data['links-youtube']) !== '') {
            $links_youtube = preg_replace('/^(https?:\/\/|\/\/)?(www\.|m\.)?(youtube\.com\/)?(channel|user)\/([a-zA-Z0-9\-]+).*$/', '$4/$5', $data['links-youtube']);
        }

        $links_twitter = null;
        if (isset($data['links-twitter']) && $data['links-twitter'] !== null && trim($data['links-twitter']) !== '') {
            $links_twitter = ltrim($data['links-twitter'], '@');
        }

        $links = [];
        if (isset($data['links-homepage']) && $data['links-homepage'] !== null) {
            $links['homepage'] = trim($data['links-homepage']);
        }
        if ($links_twitter !== null) {
            $links['twitter'] = trim($links_twitter);
        }
        if ($links_youtube !== null) {
            $links['youtube'] = trim($links_youtube);
        }
        if (isset($data['links-twitch']) && $data['links-twitch'] !== null) {
            $links['twitch'] = trim($data['links-twitch']);
        }

        $prof->fill([
                        'nickname' => $data['nickname'] ?? null,
                        'bio' => $data['bio'] ?? null,
                        'links' => ($links !== [] ? $links : null),
                        'publish_discord_id' => (bool) ($data['links-discord-publish'] ?? false),
                    ]);

        if ($prof->save() && $user->save()) {
            return true;
        } else {
            return false;
        }
    }
}
