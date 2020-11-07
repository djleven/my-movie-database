<template>
    <sections :header="getHeader"
              :sub-header="$store.state.content.name || $store.state.content.title"
              :class-list="type">
        <slot>
            <template v-if="$store.state.type === 'person'">
                <template v-for="(mediaType, index) in credits">
                    <credits v-if="mediaType.length"
                             :title="index + '_' + type"
                             image-size="medium"
                             :overview-on-hover="$store.state.global_conf.overviewOnHover"
                             column-class="twoColumn"
                             :credits="mediaType">
                    </credits>
                </template>
            </template>
            <credits v-else
                     :credits="credits">
            </credits>
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

<!--<style scoped lang="less">-->

<!--</style>-->