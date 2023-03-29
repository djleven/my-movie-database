import { createApp } from 'vue'
import { initiateStore, key } from './store';
import registerAllComponents from './_globals'
import i18nWpPlugin from '../plugins/wpI18n'
import RootComponent from './root-component'
export default function(element, config, admin = false) {
    const componentName = admin ? 'admin-page' : 'index-page'
    const store = initiateStore(config)
    const app = createApp(RootComponent, { componentName: componentName })
    registerAllComponents(app)
    app.use(store, key)
    app.use(i18nWpPlugin)

    return app.mount(element)
}
