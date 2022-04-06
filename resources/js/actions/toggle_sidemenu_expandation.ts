import $ from "jquery";

(() => {

  const buttons = document.getElementsByClassName('sidemenu-expandable-button');
  for (let i = 0; i < buttons.length; i++) {
    (buttons[i] as HTMLButtonElement).onclick = function (ev) {
      const target = (ev.currentTarget as HTMLElement)?.parentNode as HTMLElement;
      if (target.classList.contains('expanded')) {
        target.classList.remove('expanded');
        $(target.getElementsByTagName('ul')[0]).slideUp('fast');
      } else {
        target.classList.add('expanded');
        $(target.getElementsByTagName('ul')[0]).slideDown('fast');
      }
    }
  }
})()
