require('./bootstrap');
import { createApp } from 'vue';

// plugin
import toast_plugin from "./plugin/toast"
import filters from "./plugin/filters"

// mixin
import global_mixin from "./mixins/global"
import crud_mixin from "./mixins/crud"
import utils_mixin from "./mixins/utils"

/** vue router */
import router from "./router";

/** vuex */
import store from './store'

/** app initial */
const app = createApp({
    data() {
        return {
            baseurl: laravel.baseurl,
            spinner: false,
            tableSpinner: false,
            submit: false,
            validation_errors: {},
            exception_errors: {}
        }
    },
    methods: {
        getInitializeSystems() {
            axios.get('/initialize-systems').then(res => {
                this.$store.dispatch("global/setGlobal", res.data);
            });
        },
        checkPermission(route) {
            let routeName = !route ? this.$route.name : route;
            let check = this.permissions.filter ? this.permissions.filter(x => x == routeName) : [];
            return Object.keys(check).length > 0 ? true : false
        },
    },
    mounted() {
        if (this.loggedIn) {
            this.getInitializeSystems();
        }

    },

});

import AdminApp from "./components/AdminApp.vue";

app.component("app", AdminApp)
app.mixin(global_mixin)
app.mixin(crud_mixin)
app.mixin(utils_mixin)
app.use(toast_plugin)
app.use(filters)
app.use(store)

app.use(router)


import loadCustomComponents from './plugin/custom'
loadCustomComponents(app)

import loadThirdPartyPlugins from './plugin/third_party'
loadThirdPartyPlugins(app)

app.mount('#app');
