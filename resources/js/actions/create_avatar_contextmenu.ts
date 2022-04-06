import contextmenu, { ContextPosition } from "../lib/contextmenu";

const avatar = document.getElementById('self-avatar');
if (avatar) {
  avatar.onclick = function () {
    contextmenu.set([
      {
        label: window.__?.myProfile,
        href: '/u/' + window.user?.name,
      },
      {
        label: window.__?.accountSettings,
        href: '/account/settings',
      },
      // {
      //     label: window.__.displaySettings,
      //     href: '/settings',
      // },
      {
        type: 'separator'
      },
      {
        label: window.__?.logout,
        className: 'danger-color',
        click: function () {
          (document.getElementById('logout-form') as HTMLFormElement | null)?.submit();
        },
      },
    ]);

    contextmenu.open(avatar, ContextPosition.outerBottom);
  }
}
