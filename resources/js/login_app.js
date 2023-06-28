require('./login_bootstrap');
import { createApp } from 'vue';

/** validate for form */
import validate from "simple-vue-validator";
const Validator = validate.Validator;
window.Validator = Validator;

// plugin
import toast_plugin from './plugin/toast'

// mixin
import crud_mixin from "./mixins/crud"

// vuex
import store from './store'

/** login page */
import login from './views/auth/login.vue'

/** app initial */
const app = createApp({
    data() {
        return {
            baseurl: laravel.baseurl,
            spinner: false,
            site: this.getInitializeSystems()
        }
    },
    methods: {
        async getInitializeSystems() {
            await axios.get('site/initialize-systems').then(res => {
                this.site = res.data.site;
            });
            return this.site;
        },
    },
    created(){
        this.getInitializeSystems();
    }
});

app.component("login", login)
app.mixin(crud_mixin)
app.use(validate)
app.use(toast_plugin)
app.use(store)
app.mount('#app');
