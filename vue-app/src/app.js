import { createApp } from 'vue'

import { initiateStore, key } from './store';
import registerAllComponents from './_globals'

import RootComponent from './root-component'
export default function(element, config, i18n, admin = false) {
    const componentName = admin ? 'admin-page' : 'index-page'
    const store = initiateStore(config, i18n)
    const app = createApp(RootComponent, {componentName: componentName})
    registerAllComponents(app)
    app.use(store, key)

    return app.mount(element)
}
