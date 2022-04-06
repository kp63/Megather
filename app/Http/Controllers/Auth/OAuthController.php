<?php

namespace App\Http\Controllers\Auth;

use App\Enums\Providers;
use App\Helpers\Util;
use App\Http\Controllers\Controller;
use App\Models\Socialite;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite as SocialiteFacade;
use Laravel\Socialite\Contracts\User as SocialUser;

class OAuthController extends Controller
{
    function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * 各OAuth認証画面にリダイレクトします
     *
     * @param Providers $provider プロバイダー
     * @return mixed
     */
    public function redirect(Providers $provider)
    {
        if (!$provider->isEnabled()) {
            abort('404');
        }

        return match ($provider) {
            Providers::Discord => SocialiteFacade::driver('discord')
                ->setScopes(['identify'])
                ->redirect(),
            Providers::Google => SocialiteFacade::driver('google')
                ->setScopes(['openid', 'https://www.googleapis.com/auth/userinfo.profile'])
                ->redirect()
        };
    }

    /**
     * 各OAuth認証画面からのコールバック処理を行います
     *
     * @param Providers $provider プロバイダー名
     * @return mixed
     */
    public function callback(Providers $provider)
    {
        if (!$provider->isEnabled()) {
            abort('404');
        }

        try {
            $socialUser = SocialiteFacade::driver($provider->value)->stateless()->user();
        } catch (\Exception $e) {
            return redirect()->route('login');
        }

        $user = Socialite::getUserByOpenId($provider, $socialUser->getId());

        if ($user) {
            if ($provider === $user->profile->avatar_provider) {
                $user->profile->avatar_url = $socialUser->getAvatar();
            }

            if ($provider === Providers::Discord) {
                if ($user->profile->discord_id !== $socialUser->getNickname()) {
                    $user->profile->discord_id = $socialUser->getNickname();
                    $user->profile->discord_id_updated_at = Carbon::now()->toDateTimeString();
                }
            }

            $user->profile->save();

            if (Auth::loginUsingId($user->id, true)) {
                return redirect('/');
            }
            return redirect('/')->with('error', 'ログインに失敗しました。');
        } else {
            if (static::register($provider, $socialUser)) {
                return redirect('/account/settings')
                    ->with('primary-message', 'ようこそ、Megatherへ！まずはプロフィールを設定しましょう。');
            } else {
                return 'アカウントの作成に失敗しました。';
            }
        }
    }

    /**
     * 新しくアカウントを作成します。
     *
     * @param Providers $provider
     * @param SocialUser $socialUser
     * @return false|User
     */
    public static function register(Providers $provider, SocialUser $socialUser): bool|User
    {
        if (!$provider->isEnabled()) {
            return false;
        }

        $newUser = User::create([ 'name' => Util::randomHex(16) ]);

        $newUser->socialites()->create([
            $provider->value => $socialUser->getId()
        ]);

        $profile = collect([
            'avatar_provider' => $provider,
            'avatar_url' => $socialUser->getAvatar()
        ]);

        if ($provider === Providers::Discord) {
            $profile->put('discord_id', $socialUser->getNickName());
            $profile->put('discord_id_updated_at', Carbon::now()->toDateTimeString());
        }

        $newUser->profile()->create($profile->all());

        return Auth::loginUsingId($newUser->id, true);
    }
}
