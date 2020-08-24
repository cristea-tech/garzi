/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

// urmatoarele 2 linii trebuiesc pentru a folosi vue-router -- vezi documentatia de la vue-router
import VueRouter from 'vue-router'
import dashboard from './components/Dashboard.vue'
import users from './components/Users.vue'
import profile from './components/Profile.vue'

Vue.use(VueRouter)
// folosesc let in loc de const deoarece la const nu mai poate fi modificat
let routes = [
    { path: '/dashboard', component: dashboard },
    { path: '/profile', component: profile },
    { path: '/users', component: users }
  ]

const router = new VueRouter({
    mode: 'history',
    routes, // short for `routes: routes`
    linkActiveClass: 'active'
  })

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
    router
});
