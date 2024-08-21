<template>
  <overview-section :main-meta="mainMeta"
            :title="getTitle"
            :description="content?.overview"
            :links-meta="linksMeta"
            :bottom-meta="bottomMeta">
  </overview-section>
</template>

<script setup lang="ts">
import { computed, inject } from 'vue'
import { useStore } from '@/store'

import { getPropertyAsCsvFromObjectArray, getTitleWithYear } from '@/helpers/templating'

const store = useStore();
const $t = inject('$t')
const content = computed(() => store.state.movie?.content)
const getTitle = computed(() => getTitleWithYear(content.value?.title, content.value?.release_date))
const getDirectors = computed(() => {
  const directors = store.state.movie?.credits?.crew.filter((person) => {
    return person.job_aggregate?.some((item) => {
      return item.job === 'Director'
    })
  })
  if (!directors?.length) {
    return null;
  }
  directors.slice(0, 3)
  return directors.map((person) => person.name).join(', ')
})
const mainMeta = computed(() => {
  return {
    release_date: {
      showIf: content.value?.release_date,
      value: store.getters.getFormattedDate(content.value?.release_date)
    },
    starring: {
      showIf: store.state.movie?.credits?.cast,
      value: getPropertyAsCsvFromObjectArray(
          store.state.movie?.credits?.cast?.slice(0, 3)
      )
    },
    directing: {
      value: getDirectors.value
    },
    genres: {
      showIf: content.value?.genres,
      value: getPropertyAsCsvFromObjectArray(content.value?.genres)
    },
    runtime: {
      showIf: content.value?.runtime,
      value: content.value?.runtime + ' ' + $t('min'),
    },
    original_title: {
      value: content.value?.original_title,
    },
    original_language: {
      showIf: content.value?.original_language,
      value: getLanguage()
    }
  }
})

const linksMeta = computed(() => {
  return {
    imdb_profile: {
      showIf: store.state.showSettings.imdb_link && content.value?.imdb_id,
      value: `https://www.imdb.com/title/${content.value?.imdb_id}`
    },
    homepage: {
      showIf: store.state.showSettings.homepage_link,
      value: content.value?.homepage,
    }
  }
})

const bottomMeta = computed(() => {
  return {
    production_countries: {
      value: getPropertyAsCsvFromObjectArray(content.value?.production_countries)
    },
    production_companies: {
      value: getPropertyAsCsvFromObjectArray(content.value?.production_companies)
    }
  }
})

function getLanguage() {
  let languages = content.value?.spoken_languages
  const original = content.value?.original_language
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
</script>
