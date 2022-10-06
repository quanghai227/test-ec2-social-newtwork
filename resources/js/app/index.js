require('../bootstrap');

window.Vue = require('vue');
import router from '../router'
import store from '../stores'
import i18n from '@/locales/home/i18n';

import App from '@/pages/home/App.vue';

Vue.component('welcome', require('../pages/home/layouts/Default.vue').default);

const app = new Vue({
    el: '#app',
    i18n,
    router,
    store,
    render: h => h(App)
});
