<template>
  <overview-section :main-meta="mainMeta"
            :title="getTitle"
            :description="content.overview"
            :links-meta="linksMeta"
            :bottom-meta="bottomMeta">
  </overview-section>
</template>

<script setup lang="ts">
import { computed, inject } from 'vue'
import { useStore } from '@/store'

import { getPropertyAsCsvFromObjectArray, getTitleWithYear } from '@/helpers/templating'

const store = useStore()
const $t = inject('$t')

const content = computed(() => store.state.tvshow?.content)
const castCredits = computed(() => store.state.tvshow?.credits?.cast)
const getTitle = computed(() => getTitleWithYear(content.value?.name, content.value?.first_air_date))
const mainMeta = computed(() => {
  return {
    genres: {
      value: getPropertyAsCsvFromObjectArray(content.value?.genres)
    },
    created_by: {
      value: getPropertyAsCsvFromObjectArray(content.value?.created_by)
    },
    starring: {
      showIf: castCredits?.value?.length,
      value: getPropertyAsCsvFromObjectArray(castCredits.value?.slice(0, 3))
    },
    number_of_episodes: {
      label: `${$t('episodes')} / ${$t('seasons')}`,
      showIf: content.value?.number_of_episodes && content.value?.number_of_seasons,
      value: `${content.value?.number_of_episodes} / ${content.value?.number_of_seasons}`
    },
    first_air_date: {
      showIf: content.value?.first_air_date,
      value: store.getters.getFormattedDate(content.value?.first_air_date)
    },
    last_air_date: {
      showIf: !content.value?.in_production && content.value?.last_air_date,
      value: store.getters.getFormattedDate(content.value?.last_air_date)
    },
    episode_run_time: {
      showIf: content.value?.episode_run_time?.length,
      value: `${content.value?.episode_run_time[0]} ${$t('min')}`
    }
  }
})

const linksMeta = computed(() => {
  return {
    homepage: {
      value: content.value?.homepage
    }
  }
})

const bottomMeta = computed(() => {
  return {
    networks: {
      value: getPropertyAsCsvFromObjectArray(content.value?.networks)
    },
    production_companies: {
      value: getPropertyAsCsvFromObjectArray(content.value?.production_companies)
    }
  }
})
</script>