require('./bootstrap');
import Vue from 'vue'
import VueRouter from 'vue-router'
import VueProgressBar from 'vue-progressbar'
import swal from 'sweetalert2'
import moment from 'moment'
import 'vue-good-table/dist/vue-good-table.css'
import VueGoodTablePlugin from 'vue-good-table';

//admin
import Dashboard from './components/admin/Dashboard'
import Campus from './components/admin/Campus'
import Room from './components/admin/Room'
import Hall from './components/admin/Hall'

import { Form, HasError, AlertError } from 'vform'

Vue.use(VueRouter)
Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '3px'
})
Vue.use(VueGoodTablePlugin);
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
Vue.filter('formatDate', function(value) {
    if (value) {
        return moment(String(value)).format('MMMM Do YYYY')
    }
})
window.swal = swal;
window.Form = Form;
window.Fire = new Vue();
const toast = swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', swal.stopTimer)
        toast.addEventListener('mouseleave', swal.resumeTimer)
    }
})
window.toast = toast;

const router = new VueRouter({
    mode : 'history',
    routes: [
        {
            path: '/admin/dashboard',
            name: 'dashboard',
            component: Dashboard,
        },
        {
            path: '/admin/gedung',
            name: 'gedung',
            component: Hall,
        },
        {
            path: '/admin/kampus',
            name: 'campus',
            component: Campus,
        },
        {
            path: '/admin/ruang',
            name: 'room',
            component: Room,
        },

    ],
});

const app = new Vue({
    el: '#app',
    router
});
