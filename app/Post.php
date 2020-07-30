<?php

namespace App;

use App\Helpers\DateTool;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    protected $table = 'posts';
    protected $guarded = ['id'];
    protected $casts = ['details' => 'json'];

    public static function getPostFromId(string $id)
    {
        return Post::find($id);
    }

    public static function getPostsFromUserId(int $user_id)
    {
        return Post::where('user_id', $user_id)->latest();
    }

    public static function store(array $data)
    {
        if (preg_match_all('/(#(([0-9A-Za-zＡ-Ｚａ-ｚ０-９ー～_]|\p{Hiragana}|\p{Katakana}|\p{Han}|\p{Hangul})+))/u', $data['content'], $included_tags)) {
            $included_tags = $included_tags[2];
        } else {
            $included_tags = [];
        }
        return Post::create([
                                'user_id' => Auth::id(),
                                'details' => [
                                    'game' => $data['game'],
                                    'type' => $data['type'],
                                    'included_tags' => $included_tags,
                                ],
                                'content' => $data['content'],
                            ]);
    }

    public static function convert($items): array
    {
        $results = [];
        foreach ($items as $item) {
            $profile = Profile::find($item->user_id);
            $display_style = null;
            if (Auth::id() === $item->user_id) {
                $display_style = 'postowner';
            }

            $content = str_replace("\n", "<br>", e($item->content));
            $content = preg_replace('/(#(([0-9A-Za-zＡ-Ｚａ-ｚ０-９ー～_]|\p{Hiragana}|\p{Katakana}|\p{Han}|\p{Hangul})+))/u', '<a href="/search?tags=$2">#$2</a>', $content);

            $results[] = [
                'id' => $item->id,
                'username' => User::getUsernameFromId($item->user_id),
                'avatar_uri' => User::getAvatarFromId($item->user_id),
                'content' => $content,
                'display_style' => $display_style,
                'details' => $item->details,
                'postdate' => DateTool::abs2rel($item->created_at),
            ];
        }
        return $results;
    }
}
