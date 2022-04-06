<?php

namespace App\Http\Controllers;

use App\Helpers\DateTool;
use App\Helpers\YouTubeDataApi;
use App\Models\Profile;
use App\Models\Socialite;
use App\Models\User;
use App\Rules\UsernameCooldown;
use App\Rules\UsernameUnique;
use App\Rules\UsernameFormat;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\HtmlString;

class UserController extends Controller
{
    public function show(string $username)
    {
        $user = User::where('name', $username)->first();

        if (!$user) {
            return view('user.show', [
                'username' => 'Unknown User',
                'nickname' => null,
                'avatar_uri' => asset('img/avatar/default_x256.png'),
                'bio' => '該当のユーザーは見つかりませんでした。',
                'links' => [],
            ]);
        }

        $profile = $user->profile;
        $links = collect([]);

        if (isset($profile->discord_id) && $profile->publish_discord_id === true) {
            $links->push([
                'className' => 'discord',
                'icon' => 'mdi-discord',
                'href' => null,
                'content' => $profile->discord_id,
            ]);
        }

        if (isset($profile->links['youtube']) && is_string($profile->links['youtube'])) {
            $links->push([
                'className' => 'youtube',
                'icon' => 'mdi-youtube',
                'href' => 'https://www.youtube.com/channel/' . $profile->links['youtube'] . '/featured',
                'content' => YouTubeDataApi::getChannelName($profile->links['youtube']) ?? $profile->links['youtube'],
            ]);
        }

        if (isset($profile->links['twitter'])) {
            $links->push([
                'className' => 'twitter',
                'icon' => 'mdi-twitter',
                'href' => 'https://twitter.com/' . $profile->links['twitter'],
                'content' => '@' . $profile->links['twitter'],
            ]);
        }

        if (isset($profile->links['twitch'])) {
            $links->push([
                'className' => 'twitch',
                'icon' => 'mdi-twitch',
                'href' => 'https://twitch.com/' . $profile->links['twitch'],
                'content' => $profile->links['twitch'],
            ]);
        }

        return view('user.show', [
            'user' => $user,
            'links' => $links,
            'discord_id_updated_at' => (((bool) $profile->publish_discord_id === true) ? $profile->discord_id_updated_at->diffForHumans() : null),
        ]);
    }

    public function settings()
    {
        $this->middleware('auth');
        $user      = Auth::user();
        $id        = Auth::id();
        $socialite = Socialite::find($id);
        $profile   = Profile::find($id);

        return view('user.settings', [
            'user' => $user,
            'data' => [
                'links.homepage' => $profile->links['homepage'] ?? null,
                'links.discord_publish' => (bool) ($profile->publish_discord_id ?? false),
                'links.twitter' => $profile->links['twitter'] ?? null,
                'links.youtube' => $profile->links['youtube'] ?? null,
                'links.twitch' => $profile->links['twitch'] ?? null,
                'connected.google'  => (bool) (isset($socialite->google)  ? ($socialite->google  !== null) : null),
                'connected.discord' => (bool) (isset($socialite->discord) ? ($socialite->discord !== null) : null),
            ],
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'username' => [
                'between:3,20',
                new UsernameFormat,
                new UsernameUnique,
                new UsernameCooldown,
            ],
            'nickname' => 'max:32',
            'bio' => 'max:2000',
            'links-homepage' => 'max:255',
            'links-discord-publish' => [],
            'links-twitter' => ['max:255', 'regex:/^@?[a-zA-Z0-9_]{5,15}$/', 'nullable'],
            'links-youtube' => ['max:255', 'regex:/^[a-zA-Z0-9\-_]+$/', 'nullable'],
            'links-twitch' => 'max:255',
        ]);

        $user = Auth::user();

        if (!isset($data['username']) || trim($data['username']) === '') {
            $data['username'] = $user->name;
        }

        if ($user->name !== $data['username']) {
            $data['username_updated_at'] = Carbon::now()->toDateTimeString();
        }

        if (Profile::store($data)) {
            return Redirect::back()->with('success-message', new HtmlString('アカウント設定は正常に更新されました。 <a href="' . url('/account/profile') . '">プロフィールを確認</a>'));
        } else {
            return Redirect::back()->with('error-message', 'アカウント設定の更新に失敗しました。');
        }
    }

    public function logout() {
        return view('auth.logout');
    }

    public function viewOwnProfile() {
        return redirect()->route('profile_page', [
            'username' => Auth::user()->name
        ]);
    }
}
