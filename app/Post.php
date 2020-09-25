<?php

namespace App;

use App\Helpers\DateTool;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    protected $table = 'posts';
    protected $guarded = ['id'];

    public function tags() {
        return $this->belongsToMany('App\Tag', 'post_tag_relations', 'post_id', 'tag_id');
    }

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
        $tags = [];
        preg_match_all('/#(([0-9A-Za-zＡ-Ｚａ-ｚ０-９ー～_]|\p{Hiragana}|\p{Katakana}|\p{Han}|\p{Hangul})+)/u', $data['content'], $matches);
        foreach ($matches[1] as $tag) {
            $record = Tag::firstOrCreate(['name' => Tag::tag_normalize($tag)]);
            array_push($tags, $record['id']);
        }

        $post = new Post();
        $post->user_id = Auth::id();
        $post->content = $data['content'];
        $post->game = $data['game'];
        $post->type = $data['type'];
        $result1 = $post->save();
        if ($tags !== []) {
            $result2 = $post->tags()->attach($tags);
        } else {
            $result2 = true;
        }

        if ($result1 && $result2) {
            return true;
        }
        return false;
    }

    public static function convert($items): array
    {
        $results = [];
        foreach ($items as $item) {
            $user = User::find($item->user_id);
            $profile = Profile::find($item->user_id);
            $display_style = null;
            if (Auth::id() === $item->user_id) {
                $display_style = 'postowner';
            }

            $content = str_replace("\n", "<br>", e($item->content));
            $content = preg_replace('/(#(([0-9A-Za-zＡ-Ｚａ-ｚ０-９ー～_]|\p{Hiragana}|\p{Katakana}|\p{Han}|\p{Hangul})+))/u', '<a href="/search?tags=$2">#$2</a>', $content);

            $results[] = [
                'id' => $item->id,
                'username' => $user->username ?? 'Unknown User',
                'avatar_uri' => $profile->avatar_url ?? asset(Profile::$default_avatar),
                'content' => $content,
                'display_style' => $display_style,
                'details' => [
                    'game' => $item->game,
                    'type' => $item->type,
                ],
                'postdate' => DateTool::abs2rel($item->created_at),
            ];
        }
        return $results;
    }
}
