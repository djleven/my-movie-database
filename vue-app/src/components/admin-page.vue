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
    <div class="panel-body">
      <div v-for="(result, index) in results" :key="index"
           class="col-2xl-3 col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12 credits mmdb-search">
        <search-result
            :active="active === index"
            :result="result"
            :index="index"
            @select="select"
            @setActive="setActive"
        />
      </div>
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
    searchInput.value = ''
  if(loadSuccess) {
    searched.value = false
  }
}

function select (index: number) {
  const id = results.value[index]?.['id']
  if(id) {
    const inputElement = document.getElementById('MovieDatabaseID') as HTMLInputElement
    inputElement.value = id;
    store.commit('setID', id)
    store.commit('setActiveSection')
  }
}
function setActive (index) {
  active.value = index
}

</script>
