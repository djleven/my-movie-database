<template>
  <div class="mmdb-body mmdb-search white mmdb-content">
    <div class="mmdb-search-input">
      <div class="loader" v-if="loading">
        <div class="loaderInner">
        </div>
      </div>
      <input type="text"
             v-model="searchInput"
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
import { computed, ref, watch } from 'vue';
import { useStore } from '@/store'
import { searchAPI } from '@/helpers/resourceAPI';
import { useDebounce } from '@/helpers/utils';

import PeopleSearchResponse from '@/models/searchTypes/person'
import TvShowsSearchResponse from '@/models/searchTypes/tvshow'
import MoviesSearchResponse from '@/models/searchTypes/movie'

const page = ref(1)
const results = ref([])
const total_pages = ref(null)
const active = ref(null)
const searched = ref(false)
const loading = ref(false)
const searchInput = useDebounce('', 1000);

const store = useStore();
const type = computed(() => store.state.type);
const debug = computed(() => store.state.global_conf.debug);
const contentLoaded = computed(() => store.state.contentLoaded);

watch(searchInput, (val) => {
  if(val.length === 0) {
    return resetForm()
  }
  fetchResults(val)
});

watch(contentLoaded, (newValue) => {
  if(newValue) {
    resetForm(true)
  }
});
async function fetchResults(val) {
  const errorMsg = `Error fetching search results for ${val}`
  try {
    let data: PeopleSearchResponse | TvShowsSearchResponse | MoviesSearchResponse
    let query = await searchAPI(val, type.value)

    if(!query.parsedBody) {
      throw Error(errorMsg)
    }
    data = JSON.parse(query.parsedBody)

    return setResults(data)
  }
  catch(e){
    console.error(e, errorMsg)
    store.commit('setErrorMessage', errorMsg)
  }
}

function setResults(data) {
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
    // searchInput.value = ''
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
