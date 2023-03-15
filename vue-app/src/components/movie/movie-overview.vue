<template>
    <overview :main-meta="mainMeta"
              :title="getTitle"
              :description="content?.overview"
              :links-meta="linksMeta"
              :bottom-meta="bottomMeta">
    </overview>
</template>

<script>
import {getPropertyAsCsvFromObjectArray, getTitleWithYear} from '@/helpers/templating';
    export default {
        computed: {
            content() {
                return this.$store.state.content
            },
            getTitle() {
                return getTitleWithYear(this.content?.title, this.content?.release_date)
            },
            mainMeta()  {
                return {
                    release_date: {
                        showIf: this.content?.release_date,
                        value: this.$store.getters.getFormattedDate(this.content?.release_date)
                    },
                    starring: {
                        showIf: this.$store.state.credits?.cast,
                        value: getPropertyAsCsvFromObjectArray(
                            this.$store.state.credits?.cast?.slice(0, 3)
                        )
                    },
                    genres: {
                        value: getPropertyAsCsvFromObjectArray(this.content?.genres)
                    },
                    runtime: {
                        showIf: this.content?.runtime,
                        value: this.content?.runtime + ' ' + this.$store.state.__t?.min,
                    },
                    original_title: {
                        value: this.content?.original_title,
                    },
                    original_language: {
                        showIf: this.content?.original_language,
                        value: this.getLanguage()
                    }
                }
            },
            linksMeta() {
                return {
                    imdb_profile: {
                        showIf: this.content?.imdb_profile,
                        value: 'https://www.imdb.com/name/' + this.content?.imdb_id
                    },
                    homepage: {
                        value: this.content?.homepage,
                    }
                }
            },
            bottomMeta() {
                return {
                    production_countries: {
                        value: getPropertyAsCsvFromObjectArray(this.content?.production_countries)
                    },
                    production_companies: {
                        value: getPropertyAsCsvFromObjectArray(this.content?.production_companies)
                    }
                }
            }
        },
        methods: {
            getLanguage() {
                let languages = this.content?.spoken_languages
                const original = this.content?.original_language
                if (languages?.length) {
                    languages = languages.filter((lang) => {
                        if (lang.iso_639_1 === original) {
                            return lang
                        }
                    })
                  if (languages?.length) {
                    return `${languages[0]?.name} (${original})`
                  }
                }
                return original
            }
        }
    }
</script>