<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Profile;
use App\User;
use App\Socialite;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite as SocialiteFacade;

class OAuthController extends Controller
{
    function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * 各SNSのOAuth認証画面にリダイレクト
     *
     * @param string $provider プロバイダー名
     * @return mixed
     */
    public function redirect(string $provider)
    {
        if (!config('services.' . $provider)) {
            abort('404');
        }
        if ($provider === 'discord') {
            return SocialiteFacade::driver('discord')->setScopes(['identify'])->redirect();
        } elseif ($provider === 'google') {
            return SocialiteFacade::driver('google')->setScopes(['openid', 'https://www.googleapis.com/auth/userinfo.profile'])->redirect();
        } else {
            abort('404');
            return '';
        }
    }

    /**
     * 各サイトからのコールバック
     *
     * @param string $provider プロバイダー名
     * @return mixed
     * @throws \Exception
     */
    public function callback($provider)
    {
        if (!config('services.' . $provider)) {
            abort('404');
        }
        try {
            $socialUser = SocialiteFacade::driver($provider)->stateless()->user();
        } catch (\Exception $e) {
            return redirect()->route('login');
        }

        $user = Socialite::where($provider, $socialUser->getId())->first();

        if ($user !== null) {
            $prof = Profile::find($user->id);
            if ($provider === $prof->avatar_provider) {
                $prof->avatar_url = $socialUser->getAvatar();
            }

            if ($provider === 'discord') {
                if ($prof->discord_id !== $socialUser->getNickname()) {
                    $prof->discord_id = $socialUser->getNickname();
                    $prof->discord_id_updated_at = Carbon::now()->toDateTimeString();
                }
            }

            $prof->save();

            Auth::loginUsingId($user->id, true);
            return redirect('/');
        } else {
            $newUser = User::create([
                                        'username' => bin2hex(random_bytes(8)),
                                    ]);

            Socialite::create([
                                  'id' => $newUser->id,
                                  $provider => $socialUser->getId(),
                              ]);

            Profile::create([
                                'id' => $newUser->id,
                                'avatar_provider' => $provider,
                                'avatar_url' => $socialUser->getAvatar()
                            ]);

            if ($provider === 'discord') {
                $prof = Profile::find($newUser->id);
                $prof->discord_id = $socialUser->getNickname();
                $prof->discord_id_updated_at = Carbon::now()->toDateTimeString();
                $prof->save();
            }

            Auth::loginUsingId($newUser->id, true);
            return redirect('/account/settings')->with('primary-message', 'ようこそ、Megatherへ！まずはプロフィールを設定しましょう。');
        }

//        return redirect()->route('home');
    }
}
