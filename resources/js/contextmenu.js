/*
 * 0: (default)
 * 1: inner top
 * 2: inner left
 * 3: inner right
 * 4: inner bottom
 * 5: outler top
 * 6: outler left
 * 7: outler right
 * 8: outler bottom
 */

module.exports = (() => {

    const set = (contents) => {
        const container = document.getElementById('contextmenu');

        // Clear Contextmenu
        while (container.firstChild) {
            container.removeChild(container.firstChild);
        }

        for (let i = 0; i < contents.length; i++) {
            if (typeof contents[i].label === 'undefined') {
                if (typeof contents[i].type !== 'undefined' && contents[i].type === 'separator') {
                    container.appendChild(document.createElement('hr'));
                }
                continue;
            }

            if (typeof contents[i].href !== 'undefined') {
                var element = document.createElement('a');
                element.href = contents[i].href;
                element.addEventListener('click', () => {
                    setTimeout(close, 20);
                });
                element.addEventListener('mouseup', (event) => {
                    if (event.button === 1) {
                        setTimeout(close, 20);
                    }
                });
                element.addEventListener('keydown', (event) => {
                    if (event.keyCode === 38 || (event.keyCode === 9 && event.shiftKey === true)) {
                        event.preventDefault();
                        let element = event.currentTarget;
                        while (true) {
                            element = element.previousElementSibling;
                            if (element === null) {
                                let el = container.getElementsByClassName('link');
                                el[el.length - 1].focus();
                                break;
                            }
                            if (element.classList.contains('link')) {
                                element.focus();
                                break;
                            }
                        }
                        return false;
                    }
                    if (event.keyCode === 40 || (event.keyCode === 9 && event.shiftKey === false)) {
                        event.preventDefault();
                        let element = event.currentTarget;
                        while (true) {
                            element = element.nextElementSibling;
                            if (element === null) {
                                container.getElementsByClassName('link')[0].focus();
                                break;
                            }
                            if (element.classList.contains('link')) {
                                element.focus();
                                break;
                            }
                        }
                        return false;
                    }
                    if (event.keyCode === 27) {
                        close();
                        return false;
                    }
                });
                element.classList.add('link');
            } else {
                var element = document.createElement('span');
                element.addEventListener('keydown', (event) => {
                    if (event.keyCode === 38 || (event.keyCode === 9 && event.shiftKey === true)) {
                        event.preventDefault();
                        let element = event.currentTarget;
                        while (true) {
                            element = element.previousElementSibling;
                            if (element === null) {
                                let el = container.getElementsByClassName('link');
                                el[el.length - 1].focus();
                                break;
                            }
                            if (element.classList.contains('link')) {
                                element.focus();
                                break;
                            }
                        }
                        return false;
                    }
                    if (event.keyCode === 40 || (event.keyCode === 9 && event.shiftKey === false)) {
                        event.preventDefault();
                        let element = event.currentTarget;
                        while (true) {
                            element = element.nextElementSibling;
                            if (element === null) {
                                container.getElementsByClassName('link')[0].focus();
                                break;
                            }
                            if (element.classList.contains('link')) {
                                element.focus();
                                break;
                            }
                        }
                        return false;
                    }
                    if (event.keyCode === 27) {
                        close();
                        return false;
                    }
                });
            }
            element.innerText = contents[i].label;
            if (typeof contents[i].className !== 'undefined') {
                element.className = contents[i].className;
            }
            if (typeof contents[i].click !== 'undefined') {
                element.onclick = contents[i].click;
                element.addEventListener('click', close);
                element.addEventListener('mousedown', (event) => {
                    if (event.button === 1) {
                        event.preventDefault();
                        return false;
                    }
                });
                element.addEventListener('keydown', (event) => {
                    if (event.keyCode === 13) {
                        contents[i].click();
                        close();
                        return false;
                    }
                });
                element.classList.add('link');
                element.tabIndex = 0;
            }
            container.appendChild(element);
        }
    };

    const open = (arg1, arg2, arg3) => {
        const container = document.getElementById('contextmenu');
        const background = document.getElementById('contextmenu-background');
        let position = {};
        if (typeof arg1 === 'number' && typeof arg2 === 'number') {
            container.style.display = 'block';
            container.style.visibility = 'hidden';

            container.style.top = arg2 + 'px';
            container.style.left = arg1 + 'px';
            // if (typeof w !== 'undefined') {
            //   container.style.left = arg1 - container.offsetWidth + w + 'px';
            // }
        } else if (typeof arg1 === 'object') {
            container.style.display = 'block';
            container.style.visibility = 'hidden';
            var clientRect = arg1.getBoundingClientRect();
            position.top = clientRect.top;
            if (arg2 === 8) {
                position.top += clientRect.height;
            }
            if (arg2 === 2) {
                position.left = clientRect.left - (container.clientWidth - clientRect.width);
            } else {
                if (clientRect.left + container.clientWidth < document.body.clientWidth) {
                    position.left = clientRect.left;
                } else {
                    position.left = document.body.clientWidth - container.clientWidth - 10;
                }
            }

            for (let key in position) {
                container.style[key] = position[key] + 'px';
            }

            container.style.display = 'none';
            container.style.visibility = 'visible';
            $(container).slideDown(120);
            background.style.display = 'block';
            container.firstElementChild.focus();
        }
    };

    const close = () => {
        const container = document.getElementById('contextmenu');
        const background = document.getElementById('contextmenu-background');
        if (container.style.display !== 'none') {
            container.style.top = '-9999px';
            container.style.left = '-9999px';
            container.style.right = '';
            container.style.bottom = '';
            container.style.display = 'none';
            background.style.display = 'none';
            return false;
        }
    };

    const init = () => {
        const container = document.getElementById('contextmenu');
        const background = document.getElementById('contextmenu-background');
        background.onmousedown = close;
        window.onresize = close;
        document.onscroll = close;
        container.oncontextmenu = (event) => {
            event.preventDefault();
            return false;
        };
        container.addEventListener('mousedown', (event) => {
            if (event.button === 1) {
                event.preventDefault();
                return false;
            }
        });
    }

    return {
        init: init,
        set: set,
        open: open,
        close: close,
    };
})();
