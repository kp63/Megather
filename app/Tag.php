<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public $timestamps = false;
    public $guarded = [];

    public function posts() {
        return $this->belongsToMany('App\Post', 'post_tag_relations', 'tag_id', 'post_id');
    }

    public static function tag_normalize($tag_name) {
        return mb_convert_kana(strtolower($tag_name), 'KVaC');
    }
}
