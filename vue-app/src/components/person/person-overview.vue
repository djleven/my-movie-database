<template>
  <overview-section :main-meta="mainMeta"
            :title="content?.name"
            :description="content?.biography"
            :links-meta="linksMeta">
  </overview-section>
</template>
<script setup lang="ts">
import { computed } from 'vue'
import { useStore } from '@/store'

const store = useStore();
const content = computed(() => store.state.person?.content)
const castCredits = computed(() => store.state.person?.credits?.cast)
const crewCredits = computed(() => store.state.person?.credits?.crew)
const mainMeta = computed(() => {
  return {
    known_for_department: {
      value: content.value?.known_for_department
    },
    also_known_as: {
      showIf: content.value?.also_known_as?.length,
      value: content.value?.also_known_as?.join(', ')
    },
    birthday: {
      showIf: content.value?.birthday,
      value: store.getters.getFormattedDate(content.value?.birthday)
    },
    place_of_birth: {
      value: content.value?.place_of_birth
    },
    deathday: {
      showIf: content.value?.deathday,
      value: store.getters.getFormattedDate(content.value?.deathday)
    },
    movie_cast: {
      value: castCredits.value?.movie?.length
    },
    tv_cast: {
      value: castCredits.value?.tv?.length
    },
    movie_crew: {
      value: crewCredits.value?.movie?.length
    },
    tv_crew: {
      value: crewCredits.value?.tv?.length
    }
  }
})
const linksMeta = computed(() => {
  return {
    imdb_profile: {
      showIf: content.value?.imdb_id,
      value: `https://www.imdb.com/name/${content.value?.imdb_id}`
    },
    homepage: {
      value: content.value?.homepage,
    }
  }
})
</script>