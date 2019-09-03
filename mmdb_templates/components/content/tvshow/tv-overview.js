Vue.component("tv-overview", {
    computed: {
        content: function () {
            return this.$store.state.content
        },
        mainMeta: function ()  {
            return {
                genres: {
                    value: theMovieDb.helpers.getPropertyAsCsvFromObjectArray(this.content.genres)
                },
                created_by: {
                    value: theMovieDb.helpers.getPropertyAsCsvFromObjectArray(this.content.created_by)
                },
                starring: {
                    showIf: this.$store.state.credits.cast,
                    value: theMovieDb.helpers.getPropertyAsCsvFromObjectArray(
                        this.$store.state.credits.cast.slice(0, 3)
                    )
                },
                number_of_episodes: {
                    showIf: this.content.number_of_episodes && this.content.number_of_seasons,
                    value: this.content.number_of_episodes + ' / ' + this.content.number_of_seasons
                },
                first_air_date: {
                    showIf: this.content.first_air_date,
                    value: theMovieDb.helpers.formatDate(this.content.first_air_date)
                },
                last_air_date: {
                    showIf: !this.content.in_production && this.content.last_air_date,
                    value: theMovieDb.helpers.formatDate(this.content.last_air_date)
                },
                episode_run_time: {
                    showIf: this.content.episode_run_time.length,
                    value: this.content.episode_run_time[0] + ' ' + this.$store.state.__t.min
                }
            }
        },
        linksMeta: function () {
            return {
                homepage: {
                    value: this.content.homepage
                }
            }
        },
        bottomMeta: function () {
            return {
                networks: {
                    value: theMovieDb.helpers.getPropertyAsCsvFromObjectArray(this.content.networks)
                },
                production_companies: {
                    value: theMovieDb.helpers.getPropertyAsCsvFromObjectArray(this.content.production_companies)
                }
            }
        }
    },
    template: `
    <overview :main-meta="mainMeta"
              :title="theMovieDb.helpers.getTitleWithYear(content.name, content.first_air_date)"
              :description="content.overview"
              :links-meta="linksMeta"
              :bottom-meta="bottomMeta">
    </overview>`
});
