Vue.component("person-overview", {
    computed: {
        content: function () {
            return this.$store.state.content
        },
        mainMeta: function ()  {
            return {
                known_for_department: {
                    value: this.content.known_for_department
                },
                also_known_as: {
                    showIf: this.content.also_known_as.length,
                    value: this.content.also_known_as.join(', ')
                },
                birthday: {
                    showIf: this.content.birthday,
                    value: theMovieDb.helpers.formatDate(this.content.birthday)
                },
                place_of_birth: {
                    value: this.content.place_of_birth
                },
                death_date: {
                    showIf: this.content.death_date,
                    value: theMovieDb.helpers.formatDate(this.content.death_date)
                },
                movie_cast: {
                    value: this.$store.state.credits.cast.movie.length
                },
                tv_cast: {
                    value: this.$store.state.credits.cast.tv.length
                },
                movie_crew: {
                    value: this.$store.state.credits.crew.movie.length
                },
                tv_crew: {
                    value: this.$store.state.credits.crew.tv.length
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
        }
    },
    template: `
    <overview :main-meta="mainMeta"
              :title="content.name"
              :description="content.biography"
              :links-meta="linksMeta">
    </overview>`
});
