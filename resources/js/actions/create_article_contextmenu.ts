import contextmenu, { ContextPosition } from "../lib/contextmenu";
import axios from "axios";

const buttons = document.querySelectorAll('[data-article-operation-button]');
for (let i = 0; i < buttons.length; i++) {
  const button = buttons[i] as HTMLElement;
  button.addEventListener('click', () => {
    const articleBox = button.parentNode?.parentNode?.parentNode as HTMLElement;
    if (!articleBox)
      return null;
    const postId = articleBox.dataset?.id;
    console.log(postId)
    switch (button.dataset.displayStyle) {
      case 'postowner':
        contextmenu.set([
          {
            label: window.__?.deleteThisPost,
            className: 'danger-color',
            data: {
              id: postId
            },
            click: async function (event, data) {
              if (!data?.id)
                return;

              const params = new URLSearchParams();
              params.append('target', data.id);
              const res = await axios.post('/post/destroy', params);
              if (res.data === 'success') {
                articleBox.classList.add('deleted');
                (articleBox.firstElementChild as HTMLElement)?.insertAdjacentHTML('beforeend', '<div class="article-deleted-box"><p>投稿は削除されました</p></div>');
              } else {
                alert('投稿の削除に失敗しました。');
              }
            }
          }
        ]);
        break;
      default:
        // contextmenu.set([
        //   {
        //     label: window.__?.reportThisPost,
        //     data: {
        //       id: postId
        //     },
        //     click: async function (ev) {
        //       let params = new URLSearchParams();
        //       console.log(ev.currentTarget.dataset.id);
        //       params.append('target', postId);
        //       const res = await axios.post('/post/report', params);
        //       if (res.data === 'success') {
        //         articleBox.classList.add('deleted');
        //         articleBox.firstElementChild.insertAdjacentHTML('beforeend', '<div class="article-deleted-box"><p>この投稿を報告しました。</p></div>');
        //         console.log('success');
        //       } else {
        //         console.log('failed');
        //       }
        //     },
        //   }
        // ]);
        break;
    }

    contextmenu.open(button, ContextPosition.innerLeft);
  });
}
