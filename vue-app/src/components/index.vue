<template>
    <component v-if="loaded"
               :is="$store.state.template"
               :sections="sections">
    </component>
</template>

<script>
    import helpers from '../mixins/helpers.js';
    import api from '../mixins/resourceAPI.js';

    export default {
        mixins: [helpers, api],
        mounted() {
            this.loadContent()
        },
        data() {
            return {
              castLength: false,
              crewLength:  false,
            }
        },
        computed: {
            id() {
                return this.$store.state.id
            },
            loaded() {
                return this.$store.state.content && this.$store.state.credits
            },
          components(){
            return this.$store.state.components
          },
          showSettings(){
            return this.$store.state.showSettings
          },
            sections() {
                return {
                    overview: {
                        showIf: true,
                        title: this.$store.state.__t.overview,
                        component: this.components.overview
                    },
                    section_2: {
                        showIf: this.showSettings.section_2 && this.castLength,
                        title: this.$store.state.__t.cast,
                        component: this.components.section_2
                    },
                    section_3: {
                        showIf: this.showSettings.section_3 && this.crewLength,
                        title: this.$store.state.__t.crew,
                        component: this.components.section_3
                    },
                    section_4: {
                        showIf: this.showSettings.section_4 && this.sectionFour(),
                        title: this.$store.state.__t.section_4,
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
          let id = this.id
          if (id && id !== 0) {
            let credits
            let content = this.getById(id)
            content.then((data) => {
              data = JSON.parse(data)
              if (this.$store.state.global_conf.debug) {
                console.log(data)
              }
              if(data.hasOwnProperty('credits')) {
                credits = data.credits
              } else if(data.hasOwnProperty('combined_credits')) {
                credits = data.combined_credits
              } else {
                console.log('Error: No credits found in response')
              }

              this.crewLength = credits.crew.length
              this.castLength = credits.cast.length

              this.$store.commit('addContent', data)
              this.$store.commit(
                  'addCredits',
                  this.processCreditsPayload(credits)
              )

              this.$emit('content-success')
              console.log(this.$store.state)
            })
            content.catch(() => {

            })
            content.finally(() => {
              this.$emit('content-finally')
            })
                }
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