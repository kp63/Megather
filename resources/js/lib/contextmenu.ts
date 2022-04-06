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

import _ from "lodash";

export const ContextPosition = {
  default: 0,
  innerTop: 1,
  innerLeft: 2,
  innerRight: 3,
  innerBottom: 4,
  outerTop: 5,
  outerLeft: 6,
  outerRight: 7,
  outerBottom: 8,
}

const slideDown = (target: HTMLElement, duration: number = 500) => {
  target.style.removeProperty('display');
  let display = window.getComputedStyle(target).display;
  if (display === 'none') display = 'block';
  target.style.display = display;
  let height = target.offsetHeight;
  target.style.overflow = 'hidden';
  target.style.height = '0';
  target.style.paddingTop = '0';
  target.style.paddingBottom = '0';
  target.style.marginTop = '0';
  target.style.marginBottom = '0';
  target.offsetHeight;
  target.style.boxSizing = 'border-box';
  target.style.transitionProperty = "height, margin, padding";
  target.style.transitionDuration = duration + 'ms';
  target.style.height = height + 'px';
  target.style.removeProperty('padding-top');
  target.style.removeProperty('padding-bottom');
  target.style.removeProperty('margin-top');
  target.style.removeProperty('margin-bottom');
  window.setTimeout( () => {
    target.style.removeProperty('height');
    target.style.removeProperty('overflow');
    target.style.removeProperty('transition-duration');
    target.style.removeProperty('transition-property');
  }, duration);
}

const keydownHandler = (event: KeyboardEvent, container: HTMLElement) => {
  if (event.code === 'AllowUp' || (event.code === 'Tab' && event.shiftKey)) {
    event.preventDefault();
    let element: any = event.currentTarget;
    while (true) {
      element = element.previousElementSibling;
      if (element === null) {
        let el = container.getElementsByClassName('link');
        (el[el.length - 1] as HTMLElement).focus();
        break;
      }
      if (element.classList.contains('link')) {
        element.focus();
        break;
      }
    }
    return false;
  }

  if (event.code === 'AllowDown' || (event.code === 'Tab' && !event.shiftKey)) {
    event.preventDefault();
    let element: Element | null = (event.currentTarget as HTMLElement);
    while (true) {
      element = element.nextElementSibling;
      if (element === null) {
        (container.getElementsByClassName('link')[0] as HTMLElement).focus();
        break;
      }
      if (element.classList.contains('link')) {
        (element as HTMLElement | null)?.focus();
        break;
      }
    }
    return false;
  }

  if (event.code === 'Escape') {
    close();
    return false;
  }
};

export type DataTypeClickEvent = ((ev?: MouseEvent, data?: DOMStringMap) => void);
export type DataType = {
  label?: string | null;
  className?: string | null;
  type?: 'link';
  href?: string | null;
  data?: any;
  click?: DataTypeClickEvent;
  icon?: string | null;
} | {
  type: 'separator';
}

export const set = (items: DataType[]) => {
  const container = document.getElementById('contextmenu');

  if (!container)
    return false;

  // Clear Contextmenu
  while (container.firstChild) {
    container.removeChild(container.firstChild);
  }

  for (let i = 0; i < items.length; i++) {
    const item = items[i];
    if (item?.type === 'separator') {
      container.appendChild(document.createElement('hr'));
      continue;
    }

    let element;
    if (typeof item.href === 'string') {
      element = document.createElement('a');
      element.href = String(item.href);
      element.addEventListener('click', () => {
        setTimeout(close, 20);
      });
      element.addEventListener('mouseup', (event) => {
        if (event.button === 1) {
          setTimeout(close, 20);
        }
      });
      element.classList.add('link');
      element.addEventListener('keydown', (e) => keydownHandler(e, container));
    } else {
      element = document.createElement('span');
      element.addEventListener('keydown', (e) => keydownHandler(e, container));
    }

    element.innerText = String(item.label);
    if (typeof item.className === 'string') {
      element.className = String(item.className);
    }
    if (_.isObjectLike(item.data)) {
      for (const data in item.data) {
        element.dataset[data] = item.data[data];
      }
    }

    if (item?.click) {
      element.onclick = (event: MouseEvent) =>
      (item.click as DataTypeClickEvent)(event, (event.currentTarget as HTMLElement)?.dataset ?? undefined);
      element.addEventListener('click', close);
      element.addEventListener('mousedown', (event) => {
        if (event.button === 1) {
          event.preventDefault();
          return false;
        }
      });
      element.addEventListener('keydown', (event) => {
        if (event.code === 'Enter') {
          (event.currentTarget as HTMLElement).click();
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

export const open = (elementOrLeft?: number | HTMLElement, positionOrTop?: number | null) => {
  const container = document.getElementById('contextmenu');
  const background = document.getElementById('contextmenu-background');
  if (!container || !background)
    return false;

  const positions = {
    top: 10,
    left: 10,
  };

  if (typeof elementOrLeft === 'number' && typeof positionOrTop === 'number')
  {
    container.style.display = 'block';
    container.style.visibility = 'hidden';

    container.style.top = positionOrTop + 'px';
    container.style.left = elementOrLeft + 'px';
    // if (typeof w !== 'undefined') {
    //   container.style.left = arg1 - container.offsetWidth + w + 'px';
    // }
  }
  else if (elementOrLeft instanceof HTMLElement)
  {
    container.style.display = 'block';
    container.style.visibility = 'hidden';
    const clientRect = elementOrLeft.getBoundingClientRect();
    positions.top = clientRect.top;
    if (positionOrTop === ContextPosition.outerBottom) {
      positions.top += clientRect.height;
    }
    if (positionOrTop === ContextPosition.innerLeft) {
      positions.left = clientRect.left - (container.clientWidth - clientRect.width);
    } else {
      if (clientRect.left + container.clientWidth < document.body.clientWidth) {
        positions.left = clientRect.left;
      } else {
        positions.left = document.body.clientWidth - container.clientWidth - 10;
      }
    }
  }

  container.style.top = String(positions.top) + 'px';
  container.style.left = String(positions.left) + 'px';

  container.style.display = 'none';
  container.style.visibility = 'visible';
  slideDown(container, 120);
  background.style.display = 'block';
  (container.firstElementChild as HTMLElement).focus();
};

export const  close = () => {
  const container = document.getElementById('contextmenu');
  const background = document.getElementById('contextmenu-background');
  if (!container || !background)
    return false;

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

export const  init = () => {
  const container = document.getElementById('contextmenu');
  const background = document.getElementById('contextmenu-background');
  if (!container || !background)
    return false;

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

export default {
  init,
  set,
  open,
  close,
  ContextPosition
};
