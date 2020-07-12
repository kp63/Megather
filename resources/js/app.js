/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    methods: {
        operation_button_click: function(e) {
            if (e.currentTarget.dataset.displayStyle === 'postowner') {
                contextmenu.set([
                    {
                        label: window.__.deleteThisPost,
                        className: 'danger-color',
                        click: async function () {
                            let params = new URLSearchParams();
                            params.append('target', this.dataset.id);
                            const res = await axios.post('/post/destroy', params);
                            if (res.data === 'success') {
                                console.log('success');
                            } else {
                                console.log('failed');
                            }
                        },
                        data: {
                            id: e.currentTarget.parentNode.parentNode.dataset.id
                        }
                    }
                ]);
            } else {
                contextmenu.set([
                    {
                        label: window.__.reportThisPost,
                        click: function () {
                            console.log('報告処理');
                        },
                    }
                ]);
            }

            contextmenu.open(e.currentTarget, 2);
        },
        usernameButtonClick: function(e) {
            contextmenu.set([
                {
                    label: window.__.myProfile,
                    href: '/u/' + e.currentTarget.dataset.username,
                },
                {
                    label: window.__.accountSettings,
                    href: '/account/settings',
                },
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

            contextmenu.open(e.currentTarget, 8);
        },
        closeContextMenu: function() {
            contextmenu.close();
        },
        toggleSidemenuExpand: function(ev) {
            const target = ev.currentTarget.parentNode;
            if (target.classList.contains('expanded')) {
                target.classList.remove('expanded');
                $(target.getElementsByTagName('ul')[0]).slideUp('fast');
            } else {
                target.classList.add('expanded');
                $(target.getElementsByTagName('ul')[0]).slideDown('fast');
            }
        },
        // updateSearchQuery: function(events) {
        //     console.log(events);
        // },
        twitterLinkChallenge: function (ev) {
            ev.currentTarget.value = ev.currentTarget.value.replace(/^(https?:\/\/)?(mobile\.)?twitter.com\/([a-zA-Z0-9_]{5,15})(\/.*)?(\?.*)?(#.*)?$/, '$3');
            if (ev.currentTarget.value.match(/^[a-zA-Z0-9_]{5,15}$/)) {
                ev.currentTarget.value = '@' + ev.currentTarget.value;
            }
            if (ev.currentTarget.value !== '' && !ev.currentTarget.value.match(/^@[a-zA-Z0-9_]{5,15}$/)) {
                ev.currentTarget.value = ev.currentTarget.defaultValue;
            }
        },
    }
});
