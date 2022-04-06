<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    public $timestamps = false;
    public $guarded = [];

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class);
    }

    public static function tag_normalize($tag_name): string
    {
        return mb_convert_kana(strtolower($tag_name), 'KVaC');
    }
}
