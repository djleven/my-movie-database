Vue.component("cast-crew", {
    props: ['section'],
    computed: {
        credits: function () {
            const credits = this.$store.state.credits
            if (this.section === 'section_2') {
                this.type = 'cast'
                return credits.cast
            } else if (this.section === 'section_3')  {
                this.type = 'crew'
                return credits.crew
            }
            return null
        }
    },
    data: function () {
        return {
            type: ''
        }
    },
    template: `
    <sections :header="$store.state.__t[type]"
              :sub-header="$store.state.content.name || $store.state.content.title"
              :class-list="type">
        <slot>
            <template v-if="$store.state.type === 'person'">
                <template v-for="(mediaType, index) in credits" :key="index">
                    <credits v-if="mediaType.length"
                             :title="index + '_' + type"
                             image-size="medium"
                             :overview-on-hover="mmdb_conf.overviewOnHover"
                             column-class="twoColumn"
                             :credits="mediaType">
                    </credits>
                </template>
            </template>
            <credits v-else
                     :credits="credits">
            </credits>
        </slot>
    </sections>`
});
