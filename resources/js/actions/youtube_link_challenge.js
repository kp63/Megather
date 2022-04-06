(() => {
  const input = document.getElementById('links-youtube');
  if (input) {
    input.onchange = function (ev) {
      let el = ev.currentTarget;

      // もし値がIDベースURLだった場合IDを抽出し書き換える。
      if (!el.value.match(/^(https?:\/\/)?(www\.|m\.)?(youtube\.com\/channel\/)$/)) {
        el.value = el.value.replace(/^(https?:\/\/)?(www\.|m\.)?(youtube\.com\/channel\/)([a-zA-Z0-9\-_]+).*$/, '$4');
      }

      // もし値がIDではなかった場合、初期値に戻す。
      if (el.value !== '' && !el.value.match(/^([a-zA-Z0-9\-_]+)$/)) {
        el.value = el.defaultValue;
      }
    }
  }
})()
