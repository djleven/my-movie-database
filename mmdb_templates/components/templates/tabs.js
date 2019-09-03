Vue.component("tabs", {
    props: ['sections'],
    computed: {
        activeTab: function () {
            return this.$store.state.activeTab
        }
    },
    methods: {
        setActive: function (activeTab) {
            this.$store.commit('setActive', activeTab)
        }
    },
    template: `
    <div class="mmdbTabs">
        <ul class="nav nav-tabs">
            <template v-for="(section, index) in sections">
                <li :class="activeTab === index ? 'active' : ''"
                    v-if="section.showIf"
                    @click="setActive(index)">
                    <a :class="activeTab === index ? 'active activeTab' : ''">
                        {{ section.title }}
                    </a>
                </li>
            </template>
        </ul>
        <template v-for="(section, index) in sections">
            <transition :name="$store.state.cssClasses.transitionEffect">
                <template v-if="section.showIf">
                    <div v-show="activeTab === index"
                         class="tab-content mmdb-header">
                        <div class="tab-pane active">
                            <component :is="section.component"
                                       :section="index">
                            </component>
                        </div>
                    </div>
                </template>
            </transition>
        </template>
        <div class="clearfix"></div>
    </div>`
});