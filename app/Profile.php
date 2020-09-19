<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Profile extends Model
{
    protected $table = 'profiles';
    protected $guarded = [];
    protected $casts = ['links' => 'json', 'publish_discord_id' => 'bool'];

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
        if (preg_match('/^[a-zA-Z0-9\-_]+$/', ($data['links-youtube'] ?? ''))) {
            $links_youtube = $data['links-youtube'];
        }

        $links_twitter = null;
        if (preg_match('/^@?[a-zA-Z0-9_]{5,15}$/', ($data['links-twitter'] ?? ''))) {
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


    /**
     * IDからユーザー名を取得する
     *
     * @param int $id ユーザーID
     * @return string ユーザー名
     */
    public static function getUsernameFromId(int $id) {
        $user = User::find($id);
        if ($user === null) {
            return 'Unknown User';
        }

        switch (true) {
//            case $user->status === 'active':
//                return $user->username;
//                break;
            case $user->status === 'deleted':
                return 'Deleted User';
                break;
            default:
                return $user->username;
                break;
        }
    }

    /**
     * IDからアバターURLを取得する
     *
     * @param int $id ユーザーID
     * @param bool $check_user_state ユーザーの状態確認
     * @return string アバターURL
     */
    public static function getAvatarFromId(int $id, bool $check_user_state = true) {
        if ($check_user_state === true) {
            $user = User::find($id);
            if ($user !== null && $user->status !== 'deleted') {
                $profile = Profile::find($id);
                if ($profile !== null) {
                    return $profile->avatar_url;
                }
            }
        } else {
            $profile = Profile::find($id);
            if ($profile !== null) {
                return $profile->avatar_url;
            }
        }
        return asset('img/userdata/avatar/default.png');
    }

    /**
     * ユーザーのユーザー名を取得する
     *
     * @return string ユーザー名
     */
    public static function getUsername() {
        $id = Auth::id();
        if ($id === null) {
            return false;
        }
        return Profile::getUsernameFromId($id);
    }

    /**
     * ユーザーのアバターURLを取得する
     *
     * @param bool $check_user_state ユーザーの状態確認
     * @return string アバターURL
     */
    public static function getAvatar(bool $check_user_state = true) {
        $id = Auth::id();
        if ($id === null) {
            return false;
        }
        return Profile::getAvatarFromId($id, $check_user_state);
    }
}
