
require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router';
Vue.use(VueRouter);

// Vue Progress Bar
import VueProgressBar from 'vue-progressbar'
Vue.use(VueProgressBar, {
    color: '#3E4652',
    failedColor: 'red',
    height: '3px'
});

// import Vuetify from 'vuetify'
// Vue.use(Vuetify)
// import 'vuetify/dist/vuetify.min.css'

window.moment = require('moment');

import { Form, HasError, AlertError } from 'vform';
window.Form = Form;
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);



window.Fire = new Vue();


Vue.component('app-layout', require('./components/AppLayout.vue').default);
Vue.component('create-project', require('./components/projects/CreateProject.vue').default);


import Client from './components/clients/Client.vue';
import Project from './components/projects/Project.vue';
import ClientDetail from './components/clients/ClientDetail.vue';
import ProjectDetail from './components/projects/ProjectDetail.vue';
import TimeTracking from './components/timetrackings/TimeTracking.vue';
import TimeTrackingDetails from './components/timetrackings/TimeTrackingDetails.vue';




const routes = [
    {
        path: '/clients', 
        name: 'clients',
        component: Client,
        children: [
            {
                path: '/clients/:id',
                name: 'clientDetails',
                component: ClientDetail,
                props: true 
            }
        ]
    },
    {
        path: '/projects', 
        name: 'projects',
        component: Project,
        children: [
            {
                path: '/projects/:id',
                name: 'projectDetails',
                component: ProjectDetail,
                props: true 
            }
        ]
       
    },
    {
        path: '/timetracking', 
        name: 'timetracking',
        component: TimeTracking,
        children: [
            {
                path: '/timetracking/:id',
                name: 'timetrackingDetails',
                component: TimeTrackingDetails,
                props: true 
            }
        ]
       
    },
]

// Creating Instance of VueRouter
const router = new VueRouter({
    mode: 'history',
    routes 
});


const app = new Vue({
    el: '#app',
    router,
    
});
