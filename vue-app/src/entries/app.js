// import Vue from 'vue';
import { createApp } from 'vue'

import { createStore } from 'vuex'
import initiateStore from '../store/index.js';
import registerAllComponents from '../components/_globals.js'

import Root from './root.vue'
export default function(element, config, i18n, admin = false) {
    const componentName = admin ? 'admin' : 'index'
    const store = createStore(initiateStore(config, i18n))
    const app = createApp(Root, {componentName: componentName})
    registerAllComponents(app)
    app.use(store)

    return app.mount(element)
}
