require('./bootstrap');

import { InertiaApp } from '@inertiajs/inertia-vue';
import Vue from 'vue';
import vuetify from './plugins/vuetify';
import Vuex from 'vuex';
import {snackbar} from './stores/snackbar';
import CustomMethods from './plugins/customMethods';

require('./plugins/vuelidate');
require('./plugins/vueOffline');

Vue.use(InertiaApp);
Vue.use(Vuex);
Vue.use(CustomMethods);

const app = document.getElementById('app');

Vue.mixin({
    methods: {
        route: route
    }
});

const store = new Vuex.Store({
    modules: {
        snackbar: snackbar,
    }
});

window.Vue = new Vue({
    vuetify,
    store,
    render: h => h(InertiaApp, {
        props: {
            initialPage: JSON.parse(app.dataset.page),
            resolveComponent: name => import(`./Pages/${name}`).then(module => module.default),
        },
    }),
}).$mount(app);
