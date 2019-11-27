Vue.component("index", {
    mounted: function () {
        this.loadContent()
    },
    data: function () {
        return {
            crew: [],
            cast: []
        }
    },
    computed: {
        id: function () {
            return this.$store.state.id
        },
        loaded: function () {
            return this.$store.state.content && this.$store.state.credits
        },
        sections: function () {
            return {
                overview: {
                    showIf: true,
                    title: this.$store.state.__t.overview,
                    component: this.$store.state.components.overview.filename
                },
                section_2: {
                    showIf: this.$store.state.showSettings.section_2 && this.cast.length,
                    title: this.$store.state.__t.cast,
                    component: this.$store.state.components.section_2.filename
                },
                section_3: {
                    showIf:this.$store.state.showSettings.section_3 && this.crew.length,
                    title: this.$store.state.__t.crew,
                    component: this.$store.state.components.section_3.filename
                },
                section_4: {
                    showIf: this.$store.state.showSettings.section_4 && this.sectionFour(),
                    title: this.$store.state.__t.section_4,
                    component: this.$store.state.components.section_4.filename
                }
            }
        }
    },
    watch: {
        id: function () {
            this.loadContent()
        }
    },
    methods: {
        loadContent: function () {
            let id = this.id
            const _this = this
            if(id && id !== 0) {
                let credits
                const type = this.$store.state.type
                let content = theMovieDb[type].getById({id: id})
                content.then( function (data) {
                    _this.$store.commit('addContent', data)
                    if(mmdb_conf.debug) {
                        console.log(data)
                    }
                })
                credits = theMovieDb[type].getCredits({id: id})
                credits.then( function (data) {
                    _this.crew = data.crew
                    _this.cast = data.cast
                    _this.$store.commit(
                        'addCredits',
                        theMovieDb.helpers.processCreditsPayload(data, type)
                    )
                    if(mmdb_conf.debug) {
                        console.log(data)
                    }
                    _this.$emit('content-success')
                })
                content.always( function () {
                    _this.$emit('content-finally')
                })
            }
        },
        sectionFour: function () {
            const type = this.$store.state.type
            const content = this.$store.state.content
            if(type === 'movie') {
                return content.trailers.youtube && content.trailers.youtube.length
            } else if(type === 'tvshow') {
                return content.seasons.length
            }

            return false
        }
    },
    template: `
    <component v-if="loaded"
               :is="$store.state.template"
               :sections="sections">
    </component>`
});
