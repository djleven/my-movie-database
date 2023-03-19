import { createApp } from 'vue'
import { createStore } from 'vuex'

import initiateStore from './store';
import registerAllComponents from './_globals'

import RootComponent from './root-component'
export default function(element, config, i18n, admin = false) {
    const componentName = admin ? 'admin' : 'index'
    const store = createStore(initiateStore(config, i18n))
    const app = createApp(RootComponent, {componentName: componentName})
    registerAllComponents(app)
    app.use(store)

    return app.mount(element)
}
