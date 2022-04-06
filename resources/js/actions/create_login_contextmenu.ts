import contextmenu, { ContextPosition } from "../lib/contextmenu";
import { sprintf } from "sprintf-js"

const button = document.getElementById('header-login-button');
if (button) {
  button.onclick = function (ev) {
    ev.preventDefault();
    contextmenu.set([
      {
        label: sprintf(window.__?.loginWith ?? 'Login with %s', 'Google'),
        href: '/oauth/google',
        className: 'link google',
        icon: 'mdi mdi-google',
      },
      {
        label: sprintf(window.__?.loginWith ?? 'Login with %s', 'Discord'),
        href: '/oauth/discord',
        className: 'link discord',
        icon: 'mdi mdi-discord',
      },
    ]);

    contextmenu.open(button, ContextPosition.outerBottom);
  }
}
