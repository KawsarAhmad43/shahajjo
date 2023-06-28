require('./web_bootstrap');
import { createApp } from 'vue';

// plugin
import toast_plugin from "./plugin/toast"
import filters from "./plugin/filters"

// mixin
import global_mixin from "./mixins/global"
import crud_mixin from "./mixins/crud"
import utils_mixin from "./mixins/utils"


/** vuex */
import store from './store'
/** websie component */
import example from './views/website/Example.vue';
/**end websie component */

/** app initial */
const app = createApp({
    data() {
        return {
            baseurl: laravel.baseurl,
        }
    },
});
// Component load for website
app.component('example', example);
//
app.mixin(global_mixin)
app.use(toast_plugin)
app.use(filters)
app.use(store)


import loadThirdPartyPlugins from './plugin/third_party'
loadThirdPartyPlugins(app)

app.mount('#app');

