
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


import Vue from 'vue';
import Buefy from 'buefy';
import 'buefy/dist/buefy.css';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.use(Buefy);
Vue.component('articles', require('./components/articles.vue'));
Vue.component('navbar', require('./components/navbar.vue'));

const app = new Vue({
    el: '#app'
});
