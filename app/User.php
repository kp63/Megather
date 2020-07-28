<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
//        'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
//        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * IDからユーザー名を取得する
     *
     * @param int $id ユーザーID
     * @return string ユーザー名
     */
    public static function getUsernameFromId(int $id) {
        return Profile::getUsernameFromId($id);
    }

    /**
     * IDからアバターURLを取得する
     *
     * @param int $id ユーザーID
     * @param bool $check_user_state ユーザーの状態確認
     * @return string アバターURL
     */
    public static function getAvatarFromId(int $id, bool $check_user_state = true) {
        return Profile::getAvatarFromId($id, $check_user_state);
    }
}
