<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Socialite extends Model
{
    protected $table = 'socialite';
    protected $guarded = [];
    protected $casts = [];

    /**
     * プロバイダのユーザーIDからユーザー情報を特定します。
     *
     * @param string $provider プロバイダ名
     * @param string $id OpenID
     * @return array|false ユーザー情報
     */
    public static function getUserFromOpenId(string $provider, string $id) {
        $user = Socialite::where($provider, $id)->first();
        return  ($user !== null ? $user : false);
    }
}
