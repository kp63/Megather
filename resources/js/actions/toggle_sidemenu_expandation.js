(() => {
    let buttons = document.getElementsByClassName('sidemenu-expandable-button');
    for (let i = 0; i < buttons.length; i++) {
        buttons[i].onclick = function () {
            const target = this.parentNode;
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
