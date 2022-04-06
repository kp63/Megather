<x-app-layout title="コンポーネント一覧">
  <div class="content-box">
    <form>
      @csrf

      <h1>コンポーネント一覧</h1>

      <h2>通知</h2>
      <div class="alert alert-primary">
        正常に動作しました。
      </div>
      <div class="alert alert-success">
        正常に動作しました。
      </div>
      <div class="alert alert-warn">
        正常に動作しました。
      </div>

      <h2>一般タグ</h2>
      <div class="left-line">
        <h1>h1 タグ</h1>
        <h2>h2 タグ</h2>
        <h3>h3 タグ</h3>
        <h4>h4 タグ</h4>
        <p>p タグ</p>
        <p><strong>strong タグ</strong></p>
        <p><b>b タグ</b></p>
        <p><i>i タグ</i></p>
        <p><s>s タグ</s></p>
        <p><span>span タグ</span></p>
        <p><a href="#">a タグ (href属性有り)</a></p>
        <p><a>a タグ (href属性無し)</a></p>
      </div>

      <h2>フォーム</h2>
      <div class="left-line">
        <h3>入力欄</h3>

        <label class="input">
          <span>Input</span>
          <input type="text">
        </label>

        <label class="input google">
          <span>Input (Google Color)</span>
          <input type="text">
        </label>

        <label class="input">
          <span>Disabled Input</span>
          <input type="text" disabled value="Disabled">
        </label>

        <label class="input">
          <span>Textarea</span>
          <textarea></textarea>
        </label>

        <label class="input">
          <span>Disabled Textarea</span>
          <textarea disabled>Disabled</textarea>
        </label>

        <h3>接頭辞付き入力欄（複数）</h3>
        <table class="profile-links">
          <tbody>
          <tr>
            <th><label for="s1">https://</label></th>
            <td>
              <label>
                <input id="s1" name="links-homepage" type="text" placeholder="example.com">
              </label>
            </td>
          </tr>
          <tr class="spacer"></tr>
          <tr>
            <th><label for="s2">Disabled https://</label></th>
            <td>
              <label>
                <input id="s2" name="links-homepage" type="text" placeholder="example.com" disabled>
              </label>
            </td>
          </tr>
          <tr class="spacer"></tr>
          <tr class="discord">
            <th><label for="s3"><i class="mdi mdi-discord"></i> Discord ID</label></th>
            <td>
              <label>
                <input id="s3" name="links-homepage" type="text" placeholder="Example#1234">
              </label>
            </td>
          </tr>
          <tr class="spacer"></tr>
          <tr class="discord">
            <th><label for="s4">Disabled <i class="mdi mdi-discord"></i> Discord ID</label></th>
            <td>
              <label>
                <input id="s4" name="links-homepage" type="text" placeholder="Example#1234" disabled>
              </label>
            </td>
          </tr>
          <tr class="spacer"></tr>
          </tbody>
        </table>

        <h3>選択</h3>

        <label class="input select">
          <span>Input</span>
          <select>
            <option value="">Sample</option>
          </select>
        </label>

        <h3>ボタン</h3>
        <div class="btn-container">
          <a href="#" class="btn">.btn</a>
          <a href="#" class="btn btn-primary">.btn.btn-primary</a>
          <a href="#" class="btn btn-danger">.btn.btn-danger</a>
          <a href="#" class="btn btn-warn">.btn.btn-warn</a>
          <a href="#" class="btn btn-black">.btn.btn-black</a>
        </div>

      </div>
    </form>
  </div>
</x-app-layout>
