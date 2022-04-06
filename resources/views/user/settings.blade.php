<x-app-layout :title="__('Account Settings')">
  <div class="content-box">
    <form method="POST">
      @csrf

      <h1>{{ __('Account Settings') }}</h1>

      @if (Session::get('primary-message') !== null)
        <div class="alert alert-primary" style="margin: 14px 8px;">
          {{ Session::get('primary-message') }}
        </div>
      @endif
      @if (Session::get('success-message') !== null)
        <div class="alert alert-success" style="margin: 14px 8px;">
          {{ Session::get('success-message') }}
        </div>
      @endif
      @if (Session::get('error-message') !== null)
        <div class="alert alert-danger" style="margin: 14px 8px;">
          {{ Session::get('error-message') }}
        </div>
      @endif

      {{--            <div class="alert alert-warning">--}}
      {{--                <h3>意図しないアカウント作成してしまった場合</h3>--}}
      {{--                <a class="btn btn-danger" href="#">アカウント作成の取り消し</a>--}}
      {{--                <a class="btn btn-text " href="#">別アカウントとの連携</a>--}}
      {{--            </div>--}}

      <h2>公開設定</h2>
      <div class="left-line">
        <label class="input" id="username">
          <span>ユーザー名</span>
          <input type="text" name="username" value="{{ old('username', $user->name) }}" id="settings-username-input"
                 @if ($user->canUpdateName())
                 title="ユーザー名には半角英数字と一部の記号(-_.)のみ使用できます。"
                 @else
                 disabled
            @endif
          >
          <i class="mdi mdi-check-circle-outline" id="kDosXcdq" title="このユーザー名は使用できます。"></i>
          <i class="mdi mdi-alert-circle-outline" id="SoxCmdfF" title="{{ config('megather.validation.username_regex_error') }}"></i>
          <i class="mdi mdi-close-circle-outline" id="OdIedXcv" title="このユーザー名は既に使用されています。"></i>
        </label>
        @error('username')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
        @enderror
        <p style="padding: 10px; font-size: 12px; color: gray;">ユーザー名は一度変更すると30日間変更できません。</p>

        <label class="input" id="nickname">
          <span>ニックネーム（呼び名）</span>
          <input type="text" name="nickname" value="{{ old('nickname', $user->profile->nickname) }}">
        </label>
        @error('nickname')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
        @enderror

        <label class="input" id="bio">
          <span>プロフィール文</span>
          <textarea name="bio">{{ old('bio', $user->profile->bio) }}</textarea>
        </label>
        @error('bio')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
        @enderror

        {{--                <h3 id="links">リンク</h3>--}}
        <div class="input">
          <span>リンク</span>
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
                  <input id="links-twitter" name="links-twitter" type="text" class="@error('links-twitter') is-invalid @enderror" placeholder="ユーザー名またはURL" value="{{ $twitter_value }}">
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
                  <input id="links-youtube" name="links-youtube" type="text" class="@error('links-youtube') is-invalid @enderror" placeholder="チャンネル IDまたはIDベースのURL" value="{{ old('links-youtube') ?? $data['links.youtube'] ?? '' }}">
                </label>
              </td>
            </tr>
            <tr class="spacer">
              <td colspan="2"><p class="text-right"><a class="btn mini" href="https://support.google.com/youtube/answer/3250431?hl=ja" target="_blank">チャンネルIDの確認方法</a></p></td>
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
      </div>

      <h2>プライベート設定</h2>
      <div class="left-line">
        <div class="input" id="connected-accounts">
          <span>連携</span>
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
        </div>

        {{--                <h3 id="account">アカウント</h3>--}}
        {{--                <div>--}}
        {{--                    <a href="#" class="btn btn-danger">アカウントの削除</a>--}}
        {{--                </div>--}}

      </div>
      <button class="btn btn-primary" type="submit">{{ __('Update') }}</button>
    </form>
  </div>
</x-app-layout>
