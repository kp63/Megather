<?php

namespace App\Http\Controllers;

use App\Helpers\DateTool;
use App\Helpers\YouTubeDataApi;
use App\Profile;
use App\Rules\UsernameCooldown;
use App\Rules\UsernameUnique;
use App\Rules\UsernameValidation;
use App\Socialite;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    public function index($username)
    {
        $user = User::where('username', $username)->first();

        if ($user === null) {
            return 'User not found.';
        }

        $profile = Profile::find($user->id);

        if ($profile !== null) {
            return view('user.profile-page', [
                'username' => $username,
                'nickname' => $profile->nickname,
                'avatar_uri' => $profile->avatar_url !== null ? $profile->avatar_url : asset('img/userdata/avatar/default.png'),
                'bio' => $profile->bio,
                'links' => (array) ($profile->links !== null ? $profile->links : []),
                'links_youtube_name' => YouTubeDataApi::getYouTubeChannelName($profile->links['youtube'] ?? null),
                'publish_discord_id' => (bool) $profile->publish_discord_id ?? false,
                'discord_id' => (((bool) $profile->publish_discord_id === true) ? $profile->discord_id : null),
                'discord_id_updated_at' => (((bool) $profile->publish_discord_id === true) ? DateTool::abs2rel($profile->discord_id_updated_at) : null),
            ]);
        } else {
            return view('user.profile-page', [
                'username' => $username,
                'nickname' => null,
                'avatar_uri' => asset('img/userdata/avatar/default.png'),
                'bio' => '',
                'links' => [],
                'publish_discord_id' => false,
            ]);
        }
    }

    public function settings()
    {
        $this->middleware('auth');
        $user      = Auth::user();
        $id        = Auth::id();
        $socialite = Socialite::find($id);
        $profile   = Profile::find($id);

        return view('user.settings', [
            'data' => [
                'username' => $user->username,
                'username.disabled' => !($user->username_updated_at === null || (time() - strtotime($user->username_updated_at) > 2592000)),
                'nickname' => $profile->nickname ?? '',
                'bio' => $profile->bio ?? '',
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
                                           new UsernameValidation,
                                           new UsernameUnique,
                                           new UsernameCooldown,
                                       ],
                                       'nickname' => 'max:32',
                                       'bio' => 'max:2000',
                                       'links-homepage' => 'max:255',
                                       'links-discord-publish' => [],
                                       'links-twitter' => ['max:255', 'regex:/^@?[a-zA-Z0-9_]{5,15}$/', 'nullable'],
                                       'links-youtube' => ['max:255', 'regex:/^(channel|user)\/([a-zA-Z0-9\-]+)$/', 'nullable'],
                                       'links-twitch' => 'max:255',
                                   ]);

        $user = Auth::user();

        if (!isset($data['username']) || $data['username'] === null || trim($data['username']) === '') {
            $data['username'] = $user->username;
        }

        if ($user->username !== $data['username']) {
            $data['username_updated_at'] = Carbon::now()->toDateTimeString();
        }

        if (Profile::store($data)) {
            return Redirect::back()->with('success-message', 'アカウント設定は正常に更新されました。');
        } else {
            return Redirect::back()->with('error-message', 'アカウント設定の更新に失敗しました。');
        }
    }

    public function logout() {
        return view('auth.logout');
    }

    public function viewOwnProfile() {
        return redirect()->route('profile_page', [
            'username' => Auth::user()->{'username'}
        ]);
    }
}
