(() => {
    const avatar = document.getElementById('header-login-button');
    if (_.isElement(avatar)) {
        avatar.onclick = function (ev) {
            ev.preventDefault();
            contextmenu.set([
                {
                    label: 'Google ' + window.__.login,
                    href: '/oauth/google',
                    className: 'link google',
                    icon: 'mdi mdi-google',
                },
                {
                    label: 'Discord ' + window.__.login,
                    href: '/oauth/discord',
                    className: 'link discord',
                    icon: 'mdi mdi-discord',
                },
            ]);

            contextmenu.open(this, 8);
        }
    }
})()
