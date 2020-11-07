import Vue from 'vue';
import Vuex from 'vuex';
import VueResource from 'vue-resource';
// Globally register all `_base`-prefixed components
import '../components/_globals.js'
import initiateStore from '../store/index.js';

Vue.use(Vuex)
Vue.use(VueResource);

export default function(element, config, i18n, admin = false) {

    admin = admin ? 'Admin' : 'Index'

    return new Vue({
        store: new Vuex.Store(initiateStore(config, i18n)),
        render: h => h(admin)
    }).$mount(element)
}

// or for one method only
// export default helloWorld
