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

const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

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
const app2 = new Vue({
    el: '#notification',
    router,
    data: {
        notifications: [],
    },
})
const app = new Vue({
    el: '#app',
    router,
    methods: {
        showDialog(typeDialog, title, msg, timer) {
            if (timer == 0) {
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
        },
    },
    created() {
        Echo.private("App.Models.User." + document.querySelector("#loginUserId").value)
            .notification((notification) => {
                switch (notification.event) {
                    case "login":
                        this.$fire({
                            title: notification.message,
                            html: "You will be automatically logged out",
                            type: "warning",
                            allowOutsideClick: false,
                            confirmButtonText: "OK",
                        })
                            .then((result) => {
                                if (result.value) {
                                    let a = document.createElement("a");
                                    a.target = "_self";
                                    a.href = '/login';
                                    a.click();
                                }
                            });
                        break;
                    case "notification":
                        let index = app2.notifications.length;
                        app2.notifications.push(notification.notification[0]);
                        //app2.$set(app2.notifications, index, notification.notification)
                        break;
                    default:
                        this.showDialog(
                            "success",
                            notification.message,
                            "",
                            0);
                        break;
                }
            })
    }
});