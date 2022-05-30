require('./bootstrap');
import Vue from 'vue'; // if this is not work add this =>  window.Vue = require('vue');

import axios from 'axios';
import VueAxios from 'vue-axios';
import Auth from './Auth.js';

Vue.prototype.auth = Auth;
Vue.use(VueAxios, axios);

import App from './app.vue';
import router from './routes';

const app = new Vue({
    el: '#app',
    router,
    render: h => h(App),
});
