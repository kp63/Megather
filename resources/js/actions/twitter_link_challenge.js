(() => {
  const input = document.getElementById('links-twitter');
  if (input) {
    input.onchange = function (ev) {
      ev.currentTarget.value = ev.currentTarget.value.replace(/^(https?:\/\/|\/\/)?(mobile\.)?twitter.com\/([a-zA-Z0-9_]{5,15})(\/.*)?(\?.*)?(#.*)?$/, '$3');
      if (ev.currentTarget.value.match(/^[a-zA-Z0-9_]{5,15}$/)) {
        ev.currentTarget.value = '@' + ev.currentTarget.value;
      }
      if (ev.currentTarget.value !== '' && !ev.currentTarget.value.match(/^@[a-zA-Z0-9_]{5,15}$/)) {
        ev.currentTarget.value = ev.currentTarget.defaultValue;
      }
    }
  }
})()
