<?php

namespace App\Models;

use App\Enums\Providers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Socialite extends Model
{
    protected $table = 'socialite';
    protected $primaryKey = 'user_id';
    protected $guarded = [];
    protected $casts = [];

    /**
     * プロバイダのユーザーIDからユーザー情報を特定します。
     *
     * @param Providers $provider プロバイダ名
     * @param string $id OpenID
     * @return User|null ユーザー情報
     */
    public static function getUserByOpenId(Providers $provider, string $id): ?User
    {
        $socialite = static::where($provider->value, $id)->first();
        return $socialite?->user;
    }

    public function user(): belongsTo
    {
        return $this->belongsTo(User::class);
    }
}
