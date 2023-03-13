/* eslint-disable */
import { ComponentCustomProperties } from 'vue'
import { Store } from 'vuex'

declare module '@vue/runtime-core' {
    // Declare your own store states.
    interface State {
        id: string,
        type: string,
        template: string,
        global_conf: {},
        showSettings: boolean,
        cssClasses: {
            multipleColumn: string,
            twoColumn: string,
            headerColor: string,
            bodyColor: string,
            transitionEffect: boolean,
        },
        placeholder: []
    }

    interface ComponentCustomProperties {
        $store: Store<State>
    }
}