Vue.component("movie-trailer", {
    computed: {
        content: function () {
            return this.$store.state.content
        },
        mainMeta: function ()  {
            return {
                release_date: {
                    showIf: this.$store.state.content.release_date,
                    value: theMovieDb.helpers.formatDate(this.content.release_date)
                },
                starring: {
                    showIf: this.$store.state.credits.cast,
                    value: theMovieDb.helpers.getPropertyAsCsvFromObjectArray(
                        this.$store.state.credits.cast.slice(0, 3)
                    )
                },
                genres: {
                    value: theMovieDb.helpers.getPropertyAsCsvFromObjectArray(this.content.genres)
                },
                runtime: {
                    showIf: this.$store.state.content.runtime,
                    value: this.$store.state.content.runtime + ' ' + this.$store.state.__t.min,
                },
                original_title: {
                    value: this.$store.state.content.original_title,
                },
                original_language: {
                    showIf: this.$store.state.content.original_language,
                    value: this.getLanguage()
                }
            }
        },
        linksMeta: function () {
            return {
                imdb_profile: {
                    showIf: this.content.imdb_profile,
                    value: 'https://www.imdb.com/name/' + this.content.imdb_id
                },
                homepage: {
                    value: this.content.homepage,
                }
            }
        },
        bottomMeta: function () {
            return {
                production_countries: {
                    value: theMovieDb.helpers.getPropertyAsCsvFromObjectArray(this.content.production_countries)
                },
                production_companies: {
                    value: theMovieDb.helpers.getPropertyAsCsvFromObjectArray(this.content.production_companies)
                }
            }
        }
    },
    methods: {
        getLanguage: function () {
            let languages = this.$store.state.content.spoken_languages
            const original = this.$store.state.content.original_language
            if (languages.length) {
                languages = languages.filter(function (lang) {
                    if (lang.iso_639_1 === original) {
                        return lang
                    }
                })
                return languages[0].name + '(' + original + ')'
            }
            return original
        }
    },
    template: `
    <sections :header="$store.state.__t.trailer"
              :sub-header="$store.state.content.title"
              class-list="trailer">
        <div class="mmdb-trailer-video">
            <iframe width="560" height="315" frameborder="0"
                    :src="'https://www.youtube-nocookie.com/embed/' + $store.state.content.trailers.youtube[0].source"
                    allowfullscreen>
            </iframe>
        </div>
    </sections>`
});