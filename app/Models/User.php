<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'name_updated_at' => 'datetime',
    ];

    /**
     * プロフィール画像のURLを取得します
     *
     * @return string URL
     */
    public function getAvatar(): string
    {
        return $this->profile->getAvatar();
    }

    public function canUpdateName(): bool
    {
        return $this->name_updated_at === null || (time() - strtotime($this->name_updated_at) > 2592000);
    }

    /**
     * 要求されたユーザー名が使用できるか確認します。
     *
     * @param string $value
     * @return bool
     */
    public static function checkName(string $value): bool
    {
        return self::checkNameFormat($value) && self::checkNameUnique($value);
    }

    /**
     * 要求されたユーザー名が正しい形式か確認します
     *
     * @param string $value
     * @return bool
     */
    public static function checkNameFormat(string $value): bool
    {
        return str($value)->test(config('megather.validation.username_regex'));
    }

    /**
     * 要求されたユーザー名が既に取得されていないか確認します
     *
     * @param string $value
     * @return bool
     */
    public static function checkNameUnique(string $value): bool
    {
        return ! static::where('name', $value)->first();
    }

    public function profile(): hasOne
    {
        return $this->hasOne(Profile::class);
    }

    public function socialites(): hasMany
    {
        return $this->hasMany(Socialite::class);
    }
}
