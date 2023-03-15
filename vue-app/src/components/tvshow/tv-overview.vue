<template>
    <overview :main-meta="mainMeta"
              :title="getTitle"
              :description="content.overview"
              :links-meta="linksMeta"
              :bottom-meta="bottomMeta">
    </overview>
</template>


<script>
import {getPropertyAsCsvFromObjectArray, getTitleWithYear} from '@/helpers/templating.js';
    export default {
        computed: {
            content() {
                return this.$store.state.content
            },
            getTitle() {
                return getTitleWithYear(this.content.name, this.content.first_air_date)
            },
            mainMeta() {
                return {
                    genres: {
                        value: getPropertyAsCsvFromObjectArray(this.content.genres)
                    },
                    created_by: {
                        value: getPropertyAsCsvFromObjectArray(this.content.created_by)
                    },
                    starring: {
                        showIf: this.$store.state.credits.cast,
                        value: getPropertyAsCsvFromObjectArray(
                            this.$store.state.credits.cast.slice(0, 3)
                        )
                    },
                    number_of_episodes: {
                        showIf: this.content.number_of_episodes && this.content.number_of_seasons,
                        value: this.content.number_of_episodes + ' / ' + this.content.number_of_seasons
                    },
                    first_air_date: {
                        showIf: this.content.first_air_date,
                        value: this.$store.getters.getFormattedDate(this.content.first_air_date)
                    },
                    last_air_date: {
                        showIf: !this.content.in_production && this.content.last_air_date,
                        value: this.$store.getters.getFormattedDate(this.content.last_air_date)
                    },
                    episode_run_time: {
                        showIf: this.content.episode_run_time.length,
                        value: this.content.episode_run_time[0] + ' ' + this.$store.state.__t.min
                    }
                }
            },
            linksMeta() {
                return {
                    homepage: {
                        value: this.content.homepage
                    }
                }
            },
            bottomMeta() {
                return {
                    networks: {
                        value: getPropertyAsCsvFromObjectArray(this.content.networks)
                    },
                    production_companies: {
                        value: getPropertyAsCsvFromObjectArray(this.content.production_companies)
                    }
                }
            }
        }
    }
</script>