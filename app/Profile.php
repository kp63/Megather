<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;

/**
 * App\Profile
 *
 * @property int $id
 * @property string|null $nickname
 * @property string|null $avatar_url
 * @property string|null $bio
 * @property array|null $links
 * @property int $publish_discord_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereAvatarUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereLinks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile wherePublishDiscordId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
