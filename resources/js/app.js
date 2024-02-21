import {createApp} from 'vue/dist/vue.esm-bundler.js';
import App from './App.vue';
import Vuetify from '../../src/plugins/vuetify';
import '../css/app.css';
import VueCarousel from 'vue-carousel';

const app = createApp({});

window.Vue = import ("vue").default;

app.use(Vuetify, VueCarousel);

app.component('app', App);

app.mount("#app");
