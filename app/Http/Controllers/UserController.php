<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index($username)
    {
        $user = DB::table('users')->where('username', '=', $username)->first();

        if ($user === null) {
            return 'User not found.';
        }

        $profile = DB::table('profiles')->find($user->id);

        $links = (array) (isset($profile->links) ? json_decode($profile->links, true) : []);

        if (isset($links['youtube']) && $links['youtube'] !== null) {
            $youtube_name = Cache::get('youtube_name_' . $links['youtube']);
            if ($youtube_name === null) {
                if (0 === strncmp($links['youtube'], 'user', 4)) {
                    $youtube_name = file_get_contents('https://www.googleapis.com/youtube/v3/channels?forUsername=' . substr($links['youtube'], 5) . '&key=AIzaSyBkuIUEx9im7B20vAgb7lYDSxVChYCsgjA&part=snippet');
                } else if (0 === strncmp($links['youtube'], 'channel', 7)) {
                    $youtube_name = file_get_contents('https://www.googleapis.com/youtube/v3/channels?id=' . substr($links['youtube'], 8) . '&key=AIzaSyBkuIUEx9im7B20vAgb7lYDSxVChYCsgjA&part=snippet');
                } else {
                    $youtube_name = null;
                }
                $youtube_name = ($youtube_name !== null && $youtube_name !== false) ? json_decode($youtube_name, true) : null;
                if (is_array($youtube_name) && isset($youtube_name['items'])) {
                    $youtube_name = $youtube_name['items'][0]['snippet']['title'];
                    Cache::put('youtube_name_' . $links['youtube'], $youtube_name, 86400);
                } else {
                    $youtube_name = $links['youtube'];
                }
            }
        }

        if ($profile !== null) {
            return view('user.profile-page', [
                'username' => $username,
                'nickname' => $profile->nickname,
                'avatar_uri' => $profile->avatar_url !== null ? $profile->avatar_url : asset('img/userdata/avatar/default.png'),
                'bio' => $profile->bio,
                'links' => (array) ($profile->links !== null ? $links : []),
                'links_youtube_name' => $youtube_name ?? null,
                'publish_discord_id' => (bool) $profile->publish_discord_id,
            ]);
        } else {
            return view('user.profile-page', [
                'username' => $username,
                'nickname' => null,
                'avatar_uri' => asset('img/userdata/avatar/default.png'),
                'bio' => 'このユーザーはプロフィールを作成していません。',
                'links' => [],
                'publish_discord_id' => false,
            ]);
        }
    }

    public function settings()
    {
        $user      = Auth::user();
        $id        = Auth::id();
        $socialite = DB::table('socialite')->find($id);
        $profile   = DB::table('profiles') ->find($id);
        $profile_links = (array) (isset($profile->links) ? json_decode($profile->links, true) : []);

        return view('user.settings', [
            'data' => [
                'nickname' => $profile->nickname ?? '',
                'bio' => $profile->bio ?? '',
                'links.homepage' => $profile_links['homepage'] ?? null,
                'links.discord_publish' => (bool) ($profile->publish_discord_id ?? false),
                'links.twitter' => $profile_links['twitter'] ?? null,
                'links.youtube' => $profile_links['youtube'] ?? null,
                'links.twitch' => $profile_links['twitch'] ?? null,
                'connected.google'  => (bool) (isset($socialite->google)  ? ($socialite->google  !== null) : null),
                'connected.discord' => (bool) (isset($socialite->discord) ? ($socialite->discord !== null) : null),
            ],
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
                                       'nickname' => 'max:32',
                                       'bio' => 'max:2000',
                                       'links-homepage' => 'max:255',
                                       'links-discord-publish' => [],
                                       'links-twitter' => ['max:255', 'regex:/^@?[a-zA-Z0-9_]{5,15}$/', 'nullable'],
//                                       'links-youtube' => ['max:255', 'regex:/^(https?:\/\/|\/\/)?(www\.|m\.)?youtube\.com\/channel\/([a-zA-Z0-9\-_.]+)/', 'nullable'],
                                       'links-youtube' => ['max:255', 'regex:/^(https?:\/\/|\/\/)?(www\.|m\.)?(youtube\.com\/)?(channel|user)\/([a-zA-Z0-9\-]+).*$/', 'nullable'],
                                       'links-twitch' => 'max:255',
                                   ]);

        $result = DB::table('profiles')
            ->where('id', Auth::id())
            ->update([
               'nickname' => $data['nickname'] ?? null,
               'bio' => $data['bio'] ?? null,
               'links' => json_encode([
                   'homepage' => $data['links-homepage'] ?? null,
                   'twitter'  => (isset($data['links-twitter']) && $data['links-twitter'] !== null && trim($data['links-twitter']) !== '') ? ltrim($data['links-twitter'], '@') : null,
                   'youtube'  => (isset($data['links-youtube']) && $data['links-youtube'] !== null && trim($data['links-youtube']) !== '') ? preg_replace('/^(https?:\/\/|\/\/)?(www\.|m\.)?(youtube\.com\/)?(channel|user)\/([a-zA-Z0-9\-]+).*$/', '$4/$5', $data['links-youtube']) : null,
                   'twitch'   => $data['links-twitch'] ?? null,
               ]),
                'publish_discord_id' => (bool) ($data['links-discord-publish'] ?? false),
                'updated_at' => date('Y-m-d H:i:s', time()),
           ]);

        if ($result) {
            return redirect()->route('user_profile_page', ['username' => Auth::user()->{'username'}]);
        } else {
            echo 'error';
        }
    }
}
