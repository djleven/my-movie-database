<template>
    <component v-if="loaded"
               :is="$store.state.template"
               :sections="sections">
    </component>
</template>

<script>
    export default {
        mounted() {
            this.loadContent()
        },
        computed: {
            id() {
                return this.$store.state.id
            },
            loaded() {
                return this.$store.state.content && this.creditsContent
            },
          components(){
            return this.$store.state.components
          },
          showSettings(){
            return this.$store.state.showSettings
          },
          translations(){
            return this.$store.state.__t
          },
          creditsContent(){
            return this.$store.state.credits
          },
            sections() {
                return {
                    overview: {
                        showIf: true,
                        title: this.translations.overview,
                        component: this.components.overview
                    },
                    section_2: {
                        showIf: this.showSettings.section_2 && this.creditsContent?.cast?.length,
                        title: this.translations.cast,
                        component: this.components.section_2
                    },
                    section_3: {
                        showIf: this.showSettings.section_3 && this.creditsContent?.crew?.length,
                        title: this.translations.crew,
                        component: this.components.section_3
                    },
                    section_4: {
                        showIf: this.showSettings.section_4 && this.sectionFour(),
                        title: this.translations.section_4,
                        component: this.components.section_4
                    }
                }
            }
        },
        watch: {
            id() {
                this.loadContent()
            }
        },
      methods: {
        loadContent() {
          this.$store.dispatch('loadContent')
            },
            sectionFour() {
                const type = this.$store.state.type
                const content = this.$store.state.content
                if (type === 'movie') {
                    return content.trailers.youtube && content.trailers.youtube.length
                } else if (type === 'tvshow') {
                    return content.seasons.length
                }

                return false
            },
        }
    }
</script>