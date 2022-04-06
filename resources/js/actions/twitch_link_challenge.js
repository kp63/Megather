(() => {
  const input = document.getElementById('links-twitch');
  if (input) {
    input.onchange = function (ev) {
      ev.currentTarget.value = ev.currentTarget.value.replace(/^(https?:\/\/|\/\/)?(www\.|m\.)?(twitch\.(tv|com)\/)?@?([a-zA-Z0-9\-_.]+).*$/, '$5');
      if (ev.currentTarget.value !== '' && !ev.currentTarget.value.match(/^([a-zA-Z0-9\-_.]{4,25})$/)) {
        ev.currentTarget.value = ev.currentTarget.defaultValue;
      }
    }
  }
})()
