Vue.component("accordion", {
    props: ['sections'],
    computed: {
        activeTab: function () {
            return this.$store.state.activeTab
        }
    },
    methods: {
        setActive: function (activeTab) {
            if(activeTab === this.activeTab) {
                activeTab = -1
            }
            this.$store.commit('setActive', activeTab)
        }
    },
    template:`
    <div class="panel-group">
        <template v-for="(section, index) in sections">
            <div v-if="section.showIf"
                  class="panel panel-default">
                <div class="panel-heading"
                     @click="setActive(index)"
                     :style="'background-color: ' + $store.state.cssClasses.headerColor + ';'">
                    <h3 class="panel-title">
                        <a :class="activeTab === index ? 'activeTab' : ''">
                            {{ section.title }}
                        </a>
                    </h3>
                </div>
                <transition :name="$store.state.cssClasses.transitionEffect">
                    <div class="panel-body mmdb-body"
                         :style="'background-color: ' + $store.state.cssClasses.bodyColor + ';'"
                         v-show="activeTab === index">
                        <component :is="section.component"
                                   :section="index">
                        </component>
                    </div>
                </transition>
            </div>
        </template>
    </div>`
});