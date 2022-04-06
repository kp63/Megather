<?php

namespace App\Models;

use App\Enums\Providers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Profile extends Model
{
    protected $primaryKey = 'user_id';

    protected $guarded = [];

    protected $casts = [
        'links' => 'json',
        'publish_discord_id' => 'bool',
        'discord_id_updated_at' => 'datetime',
        'avatar_provider' => Providers::class
    ];

    public static string $default_avatar = 'img/userdata/avatar/default.png';

    /**
     * @param $data
     * @return bool 結果
     */
    public static function store($data): bool
    {
        $user = User::find(Auth::id());
        $user->name = $data['username'] ?? Auth::user()->name;

        if (isset($data['username_updated_at'])) {
            $user->name_updated_at = $data['username_updated_at'];
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
        if (isset($data['links-homepage'])) {
            $links['homepage'] = trim($data['links-homepage']);
        }
        if ($links_twitter !== null) {
            $links['twitter'] = trim($links_twitter);
        }
        if ($links_youtube !== null) {
            $links['youtube'] = trim($links_youtube);
        }
        if (isset($data['links-twitch'])) {
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
     * プロフィール画像のURLを取得します
     *
     * @return string URL
     */
    public function getAvatar(): string
    {
        return $this->avatar_url ?? asset('assets/img/avatar/default_x256.png');
    }

    public function user(): belongsTo
    {
        return $this->belongsTo(User::class);
    }
}
