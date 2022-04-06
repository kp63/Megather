@php($browser = strtolower($_SERVER['HTTP_USER_AGENT']))
@if (strstr($browser, 'trident') || strstr($browser, 'msie'))
  <div style="padding: 14px 10px; background-color: #be5757; color: whitesmoke; -ms-user-select: text;">
    警告: 現在使っているInternet Explorerは既に開発が終了している古いブラウザです。<br>
    安全のため<a href="https://www.microsoft.com/ja-jp/edge" target="_blank">Microsoft Edge</a>または<a href="https://www.google.co.jp/chrome/" target="_blank">Google Chrome</a>に乗り換えましょう。
  </div>
@endif
