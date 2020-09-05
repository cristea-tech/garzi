/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import moment from 'moment';
// moment().format();
import { Form, HasError, AlertError } from 'vform';

// importam clasa creata Gate din fisierul Gate.js
import Gate from "./Gate";
// definesc $gate de tip prototip in javascript insemnand ca poate fi accesat de oriunde
// folosind sintaxa this.$gate sau chiar si $gate
Vue.prototype.$gate = new Gate(window.user);
/* apoi voi folosi pentru verificare in components sintaxa
            @auth
                window.user = @JSON(auth()->user());
            @endauth */


window.Form = Form;
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);

// urmatoarele 2 linii trebuiesc pentru a folosi vue-router -- vezi documentatia de la vue-router
import VueRouter from 'vue-router';
import dashboard from './components/Dashboard.vue';
import users from './components/Users.vue';
import profile from './components/Profile.vue';
import developer from './components/Developer.vue';
import notFound from './components/NotFound.vue';

Vue.use(VueRouter);

import VueProgressBar from 'vue-progressbar';

Vue.use(VueProgressBar, {
  color: 'rgb(143, 255, 199)',
  failedColor: 'red',
  height: '3px'
});

// sweetalert2 -- documentation on https://sweetalert2.github.io/#examples
// import sweetalert pentru notificari in fereastra
import Swal from 'sweetalert2';
window.Swal = Swal;

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  });
// stochez ca variabila globala pentru a putea fi accesata de oriunde
  window.toast = Toast;


// folosesc let in loc de const deoarece la const nu mai poate fi modificat
let routes = [
    { path: '/dashboard', component: dashboard },
    { path: '/profile', component: profile },
    { path: '/developer', component: developer },
    { path: '/users', component: users },
    { path: '*', component: notFound }
];

const router = new VueRouter({
    mode: 'history',
    routes, // short for `routes: routes`
    linkActiveClass: 'active'
  });

  Vue.filter('upText', function(text){
    return text.charAt(0).toUpperCase() + text.slice(1)
  });

  Vue.filter('myDate', function(created){
      return moment(created).format("DD.MM.YYYY hh:mm:ss");
  });

  // creez o functie pentru a declansa refresh-ul paginii curente
  // pentru a actualiza informatiile detinute de pagina

     window.Fire = new Vue();

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
);
Vue.component(
    'notFound',
    require('./components/NotFound.vue').default
);

// folosesc pachetul vue pagination pentru a afisa in tabela paginarea folosind vue
Vue.component('pagination', require('laravel-vue-pagination'));


const app = new Vue({
    el: '#app',
    router,
    data: {
        search: ''
    },
    methods:{
        // definesc o functie care se initiaza cand fac cautare in pagina
        searchit: _.debounce(()=>{
            Fire.$emit('searching');
            // console.log("searching ...");
        },1000),
        // definesc o functie de printare
        printme(){
            window.print();
        }
    }
});

// folosit la autentificare cu token
window.axios.defaults.headers.common = {
    "X-Requested-With": "XMLHttpRequest",
    "X-CSRF-TOKEN": document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content")
};
