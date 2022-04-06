import _ from "lodash"

const previewArea = document.querySelector('[data-post-form-content-preview]');
if (!_.isElement(previewArea)) {
  return false;
}
previewArea.style.display = 'block';
if (_.isElement(previewArea)) {
  const watchForm = document.forms['new-post-form'];
  const games = window.app?.options.games;
  const types = window.app?.options.types;
  let escape = function (string) {
    return string.replace(/["<>]/g, function(match) {
      return {
        '"': '&quot;',
        '<': '&lt;',
        '>': '&gt;',
      }[match]
    });
  }
  let update = function () {
    let from = watchForm['content'];
    let to = document.getElementById('content-prev-content');
    to.innerHTML = escape(from.value)
      .replace('＃', '#')
      .replace(/(#(([0-9A-Za-zＡ-Ｚａ-ｚ０-９ー～_]|\p{Script=Hira}|\p{Script=Kana}|\p{Script=Han}|\p{Script=Hang})+))/gu, '<a style="color: #07f;" href="/search?tags=$2" target="_blank">$1</a>')
      .replace(/\n/g, '<br>');

    if (_.isString(games[watchForm['game'].value])) {
      document.getElementById('content-prev-game').style.display = '';
      document.getElementById('content-prev-game').href = '/search?games=' + watchForm['game'].value;
      document.getElementById('content-prev-game').innerText = 'ゲーム: ' + games[watchForm['game'].value];
    } else {
      document.getElementById('content-prev-game').style.display = 'none';
    }
    if (_.isString(types[watchForm['type'].value])) {
      document.getElementById('content-prev-type').style.display = '';
      document.getElementById('content-prev-type').href = '/search?types=' + watchForm['type'].value;
      document.getElementById('content-prev-type').innerText = 'タイプ: ' + types[watchForm['type'].value];
    } else {
      document.getElementById('content-prev-type').style.display = 'none';
    }
  }
  update();

  let elements = ['game', 'type', 'content'];
  for (let i = 0; i < elements.length; i++) {
    let target = watchForm[elements[i]];
    if (target.nodeName === 'INPUT' || target.nodeName === 'TEXTAREA') {
      target.oninput = () => { update() };
    }
    target.onchange = () => { update() };
  }
}
