require('./bootstrap');

import Vue from 'vue';
const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

const app = new Vue({
  el: '#app',
});

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
