<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Profile;
use App\User;
use App\Socialite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite as SocialiteFacade;

class OAuthController extends Controller
{
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
//            switch ($e->getCode()) {
//                case 400:
//                    echo 'Error';
//                    return redirect('/');
////                    break;
//            }
            return redirect('/');
        }

        $user = Socialite::where($provider, $socialUser->getId())->first();

        if ($user !== null) {
            $prof = Profile::find($user->id);
            $prof->avatar_url = $socialUser->getAvatar();
            $prof->save();

            Auth::loginUsingId($user->id, true);
            return redirect('/');
        } else {
            $newUser = User::create([
                                        'username' => bin2hex(random_bytes(8)),
//                'email' => $socialUser->getEmail(),
                                    ]);

            Socialite::create([
                                  'id' => $newUser->id,
                                  $provider => $socialUser->getId(),
                              ]);

            Profile::create([
                                'id' => $newUser->id,
                                'avatar_url' => $socialUser->getAvatar()
                            ]);

            Auth::loginUsingId($newUser->id, true);
            return redirect('/account/settings');
        }

//        return redirect()->route('home');
    }
}
