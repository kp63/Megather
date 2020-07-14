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
        if (preg_match_all('/#([^\x00-\x2F\x3A-\x40\x5B-\x5E\x60\x7B-\x7F]+)/', $data['content'], $included_tags)) {
            $included_tags = $included_tags[1];
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
            $content = preg_replace('/#([^\x00-\x2F\x3A-\x40\x5B-\x5E\x60\x7B-\x7F]+)/', '<a href="/search?tags=$1">#$1</a>', $content);

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
