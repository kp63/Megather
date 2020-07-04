<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class OAuthController extends Controller
{
    /**
     * 各SNSのOAuth認証画面にリダイレクトして認証
     * @param string $provider サービス名
     * @return mixed
     */
    public function socialOAuth(string $provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * 各サイトからのコールバック
     * @param string $provider サービス名
     * @return mixed
     */
    public function handleProviderCallback($provider)
    {
        $socialUser = Socialite::driver($provider)->stateless()->user();
        $user = [
            'email' => $socialUser->getEmail(),
            'username' => $socialUser->getNickname(),
            'provider_id' => $socialUser->getId(),
            'provider_name' => $provider,
        ];

//        Auth::login($user);

        return var_dump($socialUser);
//        return redirect()->route('home');
    }
}
