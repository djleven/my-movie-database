import { createApp } from 'vue'
import { initiateStore, key } from './store'
import registerAllComponents from './_globals'
import i18nWpPlugin from '../plugins/wpI18n'
import RootComponent from './root-component'
import { validateBaseStateConfig } from '@/models/apiTypes/BaseStateConfig.validator'
export default function(element, config, admin = false) {
try {
    const componentName = admin ? 'admin-page' : 'index-page'
    const store = initiateStore(validateBaseStateConfig(config))
    const app = createApp(RootComponent, { componentName: componentName })
    registerAllComponents(app)
    app.use(store, key)
    app.use(i18nWpPlugin)

    return app.mount(element)
    }
    catch (e) {
        console.error(e)
    }
}
