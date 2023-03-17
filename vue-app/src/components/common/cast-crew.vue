<template>
    <sections :header="getHeader"
              :sub-header="$store.state.content.name || $store.state.content.title"
              :class-list="type">
        <slot>
          <extended-credits
              v-if="$store.state.type === 'person'"
              :credits="credits"
              :i18-title-key-suffix="type"
              :overview-on-hover="$store.state.global_conf.overviewOnHover"
          />
            <credits
                v-else
                :credits="credits"
            />
        </slot>
    </sections>
</template>

<script>
    export default {
        props: ['section'],
        computed: {
            credits() {
                const credits = this.$store.state.credits
                if (this.section === 'section_2') {
                    this.type = 'cast'
                    return credits.cast
                } else if (this.section === 'section_3')  {
                    this.type = 'crew'
                    return credits.crew
                }
                return null
            },
          getHeader(){
              if(this.type) {
                return this.$store.state.__t[this.type]
              }

            return this.type
          }
        },
        data() {
            return {
                type: ''
            }
        },
    }
</script>
