(() => {
    const avatar = document.getElementById('self-avatar');
    if (_.isElement(avatar)) {
        avatar.onclick = function () {
            contextmenu.set([
                {
                    label: window.__.myProfile,
                    href: '/u/' + this.dataset.username,
                },
                {
                    label: window.__.accountSettings,
                    href: '/account/settings',
                },
                // {
                //     label: window.__.displaySettings,
                //     href: '/settings',
                // },
                {
                    type: 'separator',
                },
                {
                    label: window.__.logout,
                    className: 'danger-color',
                    click: function () {
                        document.getElementById('logout-form').submit();
                    },
                },
            ]);

            contextmenu.open(this, 8);
        }
    }
})()
