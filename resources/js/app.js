/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;
import VueSimpleAlert from "vue-simple-alert";
import VueRouter from 'vue-router';
import Vue from "vue";

Vue.use(VueSimpleAlert);
Vue.use(VueRouter);
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

//const files = require.context('./', true, /\.vue$/i)
//files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const routes = [
    {
        path: '/login', component: require('./components/LoginForm.vue').default

    },
    {
        path: '/register', component: require('./components/RegisterForm.vue').default

    },
]

const router = new VueRouter({
    routes,
    mode: "history"
})

const app = new Vue({
    el: '#app',
    router,
    methods: {
        showDialog(typeDialog, title, msg, timer) {
            if(timer == 0){
                this.$fire({
                    title: title,
                    html: msg,
                    type: typeDialog,
                })
            } else {
                this.$fire({
                    title: title,
                    html: msg,
                    type: typeDialog,
                    timer: timer,
                })
            }
        }
    }
});


/*const app = new Vue({
    el: '#app',
    router,
    data: {
        messages: [],
        users: [],
        login : "",
    },

    created() {
        Echo.channel('events')
            .listen('RealTimeMessage', (event) => {
                this.$fire({
                    title: "Login Fired!",
                    text: event.message,
                    type: "success",
                    timer: 3000
                  }).then(r => {
                   console.log(r.value);
                  });
            });
    },
})*/
