(() => {
    const buttons = document.querySelectorAll('[data-article-operation-button]');
    for (let i = 0; i < buttons.length; i++) {-
        buttons[i].addEventListener('click', function () {
            let articleBox = $(this).parents('.article')[0];
            let postId = articleBox.dataset.id;
            switch (this.dataset.displayStyle) {
                case 'postowner':
                    contextmenu.set([
                        {
                            label: window.__.deleteThisPost,
                            className: 'danger-color',
                            data: {
                                id: postId
                            },
                            click: async function () {
                                let params = new URLSearchParams();
                                params.append('target', postId);
                                const res = await axios.post('/post/destroy', params);
                                if (res.data === 'success') {
                                    articleBox.classList.add('deleted');
                                    articleBox.firstElementChild.insertAdjacentHTML('beforeend', '<div class="article-deleted-box"><p>投稿は削除されました</p></div>');
                                    console.log('success');
                                } else {
                                    console.log('failed');
                                }
                            }.bind(this)
                        }
                    ]);
                    break;
                default:
                    contextmenu.set([
                        {
                            label: window.__.reportThisPost,
                            data: {
                                id: postId
                            },
                            click: async function (ev) {
                                let params = new URLSearchParams();
                                console.log(ev.currentTarget.dataset.id);
                                params.append('target', postId);
                                const res = await axios.post('/post/report', params);
                                if (res.data === 'success') {
                                    articleBox.classList.add('deleted');
                                    articleBox.firstElementChild.insertAdjacentHTML('beforeend', '<div class="article-deleted-box"><p>この投稿を報告しました。</p></div>');
                                    console.log('success');
                                } else {
                                    console.log('failed');
                                }
                            },
                        }
                    ]);
                    break;
            }

            contextmenu.open(this, 2);
        })
    }
})()
