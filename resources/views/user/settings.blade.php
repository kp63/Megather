@extends('layouts.app')

@section('page_title', __('Account Settings'))

@section('content')
    <div class="content-box">
        <form method="POST">
            @csrf

            <h1>{{ __('Account Settings') }}</h1>

            <h2>公開設定</h2>
            <div class="left-line">
                <h3 id="links">ニックネーム（呼び名）</h3>
                <label class="input">
                    <input type="text" name="nickname" value="{{ old('nickname') ?? $data['nickname'] ?? '' }}">
                </label>

                <h3 id="links">プロフィール文</h3>
                <label class="input">
                    <textarea name="bio">{{ old('bio') ?? $data['bio'] ?? '' }}</textarea>
                </label>

                <h3 id="links">リンク</h3>
                <table class="profile-links">
                    <tbody>
{{--                        <tr>--}}
{{--                            <th><label for="links-homepage">ホームページ</label></th>--}}
{{--                            <td>--}}
{{--                                <label>--}}
{{--                                    <input disabled id="links-homepage" name="links-homepage" type="text" class="@error('links-homepage') is-invalid @enderror" placeholder="https://" value="{{ (old('links-homepage') !== null) ? old('links-homepage') : $data['links.homepage'] ?? '' }}">--}}
{{--                                </label>--}}
{{--                            </td>--}}
{{--                        </tr>--}}
{{--                        <tr class="spacer">--}}
{{--                            @error('links-homepage')--}}
{{--                            <td colspan="2">--}}
{{--                                <div class="invalid-feedback">--}}
{{--                                    {{ $message }}--}}
{{--                                </div>--}}
{{--                            </td>--}}
{{--                            @enderror--}}
{{--                        </tr>--}}
                        <tr class="discord">
                            <th><label for="links-discord-publish"><i class="mdi mdi-discord"></i> Discord</label></th>
                            <td>
                                <label>
                                    <?php
                                    $discord_publish = old('links-discord-publish');
                                    if ($discord_publish === null) {
                                        if (isset($data['links.discord_publish']) && $data['links.discord_publish'] !== null) {
                                            $discord_publish = $data['links.discord_publish'];
                                        } else {
                                            $discord_publish = false;
                                        }
                                    }
                                    ?>
                                    <input id="links-discord-publish" name="links-discord-publish" type="checkbox" {{ ($discord_publish === true) ? 'checked' : '' }}>
                                    <span class="checkbox-label">公開する</span>
                                </label>
                            </td>
                        </tr>
                        <tr class="spacer">
                            @error('links-discord-publish')
                            <td colspan="2">
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            </td>
                            @enderror
                        </tr>
                        <tr class="twitter">
                            <th><label for="links-twitter"><i class="mdi mdi-twitter"></i> Twitter</label></th>
                            <td>
                                <label>
                                    <?php
                                    $twitter_value = old('links-twitter');
                                    if ($twitter_value === null) {
                                        if ($data['links.twitter']) {
                                            $twitter_value = '@' . $data['links.twitter'];
                                        } else {
                                            $twitter_value = '';
                                        }
                                    }
                                    ?>
                                    <input id="links-twitter" name="links-twitter" type="text" class="@error('links-twitter') is-invalid @enderror" placeholder="ユーザー名またはURL" @change="twitterLinkChallenge" value="{{ $twitter_value }}">
                                </label>
                            </td>
                        </tr>
                        <tr class="spacer">
                            @error('links-twitter')
                            <td colspan="2">
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            </td>
                            @enderror
                            </tr>
                        <tr class="youtube">
                            <th><label for="links-youtube"><i class="mdi mdi-youtube"></i> YouTube</label></th>
                            <td>
                                <label>
                                    <input id="links-youtube" name="links-youtube" type="text" class="@error('links-youtube') is-invalid @enderror" placeholder="URL" value="{{ old('links-youtube') ?? $data['links.youtube'] ?? '' }}">
                                </label>
                            </td>
                        </tr>
                        <tr class="spacer">
                            @error('links-youtube')
                            <td colspan="2">
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            </td>
                            @enderror
                        </tr>
                        <tr class="twitch">
                            <th><label for="links-twitch"><i class="mdi mdi-twitch"></i> Twitch</label></th>
                            <td>
                                <label>
                                    <input id="links-twitch" name="links-twitch" type="text" class="@error('links-twitch') is-invalid @enderror" placeholder="ユーザー名またはURL" value="{{ old('links-twitch') ?? $data['links.twitch'] ?? '' }}">
                                </label>
                            </td>
                        </tr>
                        <tr class="spacer">
                            @error('links-twitch')
                            <td colspan="2">
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            </td>
                            @enderror
                        </tr>
                    </tbody>
                </table>
            </div>

            <h2>プライベート設定</h2>
            <div class="left-line">
                <h3 id="connected-accounts">連携</h3>
                <table class="profile-links">
                    <tbody>
                    <tr class="google">
                        <th><label><i class="mdi mdi-google"></i> Google</label></th>
                        <td>
                            <p style="padding: 0 12px;">{{ $data['connected.google'] ? '連携済み' : '未連携' }}</p>
                        </td>
                    </tr>
                    <tr class="spacer"></tr>
                    <tr class="discord">
                        <th><label><i class="mdi mdi-discord"></i> Discord</label></th>
                        <td>
                            <p style="padding: 0 12px;">{{ $data['connected.discord'] ? '連携済み' : '未連携' }}</p>
                        </td>
                    </tr>
                    <tr class="spacer"></tr>
                    </tbody>
                </table>

{{--                <h3 id="account">アカウント</h3>--}}
{{--                <div>--}}
{{--                    <a href="#" class="btn btn-danger">アカウントの削除</a>--}}
{{--                </div>--}}

            </div>
            <button class="btn btn-primary" type="submit">{{ __('Update') }}</button>
        </form>
    </div>
@endsection
