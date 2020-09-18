(() => {
    const input = document.getElementById('links-youtube');
    if (!_.isElement(input)) return;

    input.onchange = function (ev) {
        ev.currentTarget.value = ev.currentTarget.value.replace(/^(https?:\/\/|\/\/)?(www\.|m\.)?(youtube\.com\/)?(channel|user)\/([a-zA-Z0-9\-_]+).*$/, '$4/$5');
        if (ev.currentTarget.value !== '' && !ev.currentTarget.value.match(/^(channel|user)\/([a-zA-Z0-9\-_]+)$/)) {
            ev.currentTarget.value = ev.currentTarget.defaultValue;
        }
    }
})()
