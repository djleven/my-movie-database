<template>
    <section-layout :header="$store.state.__t.trailer"
              :sub-header="$store.state.content?.title"
              class-list="trailer">
        <div class="mmdb-trailer-video">
            <iframe width="560" height="315" frameborder="0"
                    :src="'https://www.youtube-nocookie.com/embed/' + $store.state.content?.trailers?.youtube[0]?.source"
                    allowfullscreen>
            </iframe>
        </div>
    </section-layout>
</template>

<script>
import {getPropertyAsCsvFromObjectArray} from '@/helpers/templating';
    export default {
        computed: {
            content() {
                return this.$store.state.content
            },
            mainMeta()  {
                return {
                    release_date: {
                        showIf: this.content?.release_date,
                        value: this.$store.getters.getFormattedDate(this.content?.release_date)
                    },
                    starring: {
                        showIf: this.$store.state.credits?.cast?
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
        }
    }
</script>