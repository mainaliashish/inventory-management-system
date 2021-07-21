
require('./bootstrap');

import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

// Import routes
import { routes } from './routes';

// Import User class helper
import User from './Helpers/User';
window.User = User;

/*
* Integrate Noty for notifications
*/
import Notification from './Helpers/Notification';
window.Notification = Notification;

/*
* Integrate Swee Alert
*/
import Swal from 'sweetalert2'
window.Swal = Swal;

const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: toast => {
        toast.addEventListener("mouseenter", Swal.stopTimer);
        toast.addEventListener("mouseleave", Swal.resumeTimer);
    }
});

window.Toast = Toast;


const router = new VueRouter({
    mode: 'history',
    routes
});


const app = new Vue({
    el: '#app',
    router
});
