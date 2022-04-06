<?php

namespace App\Models;

use App\Helpers\Util;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [];

    static ?array $games = null;
    static ?array $types = null;

    public static function getAllGames(): array
    {
        if (static::$games)
            return static::$games;

        static::$games = Util::flattenOptions(config('megather.options.games'));
        return static::$games;
    }

    public static function getAllTypes(): array
    {
        if (static::$types)
            return static::$types;

        static::$types = Util::flattenOptions(config('megather.options.types'));
        return static::$types;
    }

    public static function getGameTitle(string $key): ?string
    {
        return static::getAllGames()[$key] ?? null;
    }

    public static function getTypeName(string $key): ?string
    {
        return static::getAllTypes()[$key] ?? null;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }
}
