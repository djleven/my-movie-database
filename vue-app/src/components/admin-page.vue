<template>
  <div class="mmdb-body mmdb-search white mmdb-content">
    <div class="mmdb-search-input">
      <div class="loader" v-if="loading">
        <div class="loaderInner">
        </div>
      </div>
      <debounced-input
          @output="fetchResults"
      />
    </div>
    <div :class="`credits-wrapper rectangular overview-on-hover`">
      <template v-for="(result, index) in results" :key="index"
           class="mmdb-search">
        <search-result
            :result="result"
            @select="select"
        />
      </template>
      <div v-if="!results.length && searched">
        <h4>No search results found</h4>
      </div>
    </div>
    <index-page />
  </div>

</template>
<script setup lang="ts">
import { computed, ref, Ref, watch } from 'vue';
import { useStore } from '@/store'
import PeopleSearchResponse, { PersonSearchData } from '@/models/searchTypes/person'
import TvShowsSearchResponse, { TvShowSearchData } from '@/models/searchTypes/tvshow'
import MoviesSearchResponse, { MovieSearchData } from '@/models/searchTypes/movie'

const page = ref(1)
const results: Ref<MovieSearchData[]> | Ref<TvShowSearchData[]> | Ref<PersonSearchData[]> = ref(  [])
const total_pages = ref(0)
const active = ref(null)
const searched = ref(false)
const loading = ref(false)

const store = useStore();
const type = computed(() => store.state.type);
const debug = computed(() => store.state.global_conf.debug)
const contentLoaded = computed(() => store.state.contentLoaded)

watch(contentLoaded, (newValue) => {
  if(newValue) {
    resetForm(true)
  }
});
const fetchResults = async (val) => {
  if(!val) {
    return
  }
  const results = await store.dispatch('searchForResources', val)
  setResults(results)
}

function setResults(data: PeopleSearchResponse | TvShowsSearchResponse | MoviesSearchResponse) {
  if (debug.value) {
    console.log(data, 'Search result response data')
  }
  page.value = data.page
  results.value = data.results
  total_pages.value = data.total_pages
  searched.value = true
}

function resetForm(loadSuccess = false) {
    results.value = []
  if(loadSuccess) {
    searched.value = false
  }
}

function select (id) {
  if(id) {
    const inputElement = document.getElementById('MovieDatabaseID') as HTMLInputElement
    inputElement.value = id;
    inputElement.dispatchEvent(new Event('change'));
    store.commit('setContentLoaded', false)
    store.commit('setID', id)
    store.commit('setActiveSection')
  }
}

</script>
