<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

/**
 * App\User
 *
 * @property int $id
 * @property string $username
 * @property string $status
 * @property string $role
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUsername($value)
 * @mixin \Eloquent
 */
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
}
