Vue.component("sections", {
    props: {
        showHeader: {
            type: String,
            default: true
        },
        header: {
            type: String,
            required: true
        },
        subHeader: {
            type: String,
            default: null
        },
        classList: {
            type: String,
            default: ''
        },
        showIf: {
            type: Boolean,
            default: true
        }
    },
    template: `
    <div>
        <div class="mmdb-header"
             v-if="showHeader"
             :style="'background-color: ' + $store.state.cssClasses.headerColor + ';'">
            <h3 class="mmdb-header-title">
                {{ header }}
                <span v-if="subHeader" class="pull-right">{{ subHeader }}</span>
            </h3>
        </div>
        <div :class="'col-md-12 mmdb-body ' + classList"
             :style="'background-color: ' + $store.state.cssClasses.bodyColor + ';'">
           <slot></slot>
        </div>
    </div>`
});