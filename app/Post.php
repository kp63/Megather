<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    protected $table = 'posts';
    protected $guarded = ['id'];
    protected $casts = ['details' => 'json'];

    public static function getAll()
    {
        return DB::table('posts')
            ->orderBy('created_at', 'desc')
            ;
    }

    public static function getPostsFromId(string $id)
    {
        return DB::table('posts')
            ->where('id', $id)
            ->orderBy('created_at', 'desc')
            ;
    }

    public static function getPostsFromUserId(int $user_id)
    {
        return DB::table('posts')
            ->where('user_id', $user_id)
            ->orderBy('created_at', 'desc')
            ;
    }

    public static function create(array $data)
    {
        return DB::table('posts')
            ->insert([
                'user_id' => $data['user_id'] ?? Auth::id(),
                'details' => json_encode($data['details']),
                'content' => $data['content'],
            ]);

//        ここのコードが上手く機能しない
//        return self::create([
//                'user_id' => $data['user_id'] ?? Auth::id(),
//                'details' => $data['details'],
//                'content' => $data['content'],
//            ]);
    }

    public static function convert($items): array
    {
        $results = [];
        foreach ($items as $item) {
            $display_style = null;
            if (Auth::id() === $item->{'user_id'}) {
                $display_style = 'postowner';
            }
            $results[] = [
                'username' => DB::table('users')->find($item->{'user_id'})->{'username'},
                'content' => $item->{'content'},
                'display_style' => $display_style,
                'details' => json_decode($item->{'details'}, true),
                'postdate' => self::convert_to_fuzzy_time($item->{'created_at'}),
            ];
        }
        return $results;
    }

    protected static function convert_to_fuzzy_time($unix): string
    {
        $unix = strtotime($unix);
        $now        = time();
        $diff_sec   = $now - $unix;
        if ($diff_sec < 60) {
            $output = sprintf(__('%d second(s) ago'), $diff_sec);
        } elseif ($diff_sec < 3600) {
            $output = sprintf(__('%d minute(s) ago'), $diff_sec / 60);
        } elseif ($diff_sec < 86400) {
            $output = sprintf(__('%d hour(s) ago'), $diff_sec / 3600);
        } elseif ($diff_sec < 2764800) {
            $output = sprintf(__('%d day(s) ago'), $diff_sec / 86400);
        } else {
            if (date('Y') !== date('Y', $unix)) {
                $output = date(__('F jS, Y'), $unix);
            } else {
                $output = date(__('F jS'), $unix);
            }
        }
        return $output;
    }
}
