<template>
  <div class="mmdb-body mmdb-search white">
    <div>
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
           class="col-xl-4 col-lg-6 col-md-6 col-sm-6 credits mmdb-search">
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
    <index @content-success="contentLoadSuccess"
           @content-finally="contentLoadFinally">
    </index>
  </div>

</template>
<script>
import api from '../mixins/resourceAPI.js';

export default {
  mixins: [api],
  data() {
    return {
      page: 1,
      results: [],
      total_pages: null,
      active: null,
      searched: false,
      loading: false,
      timeout: null,
      debouncedInput: ''
    }
  },
  computed: {
    searchInput: {
      get() {
        return this.debouncedInput
      },
      set(val) {
        if (this.timeout) clearTimeout(this.timeout)
        this.timeout = setTimeout(() => {
          this.debouncedInput = val
        }, 600)
      }
    }
  },
  watch: {
    searchInput(val) {
      if(val.length === 0) {
        this.searched = false
        this.results = []
        return
      }
      let query = this.searchAPI(val)
      query.then((response) => {
        const data = JSON.parse(response)
        const debug = this.$store.state.global_conf.debug
        if (debug) {
          console.log(data)
        }
        this.page = data.page
        this.results = data.results
        this.total_pages = data.total_pages
        this.searched = true
      })
    }
  },
  methods: {
    contentLoadSuccess() {
      this.results = []
      this.searchInput = ''
      this.searched = false
    },
    contentLoadFinally() {
      this.loading = false
    },
    select (index) {
      const id = this.results[index].id
      this.loading = true
      document.getElementById('MovieDatabaseID').value = id;
      this.$store.commit('setID', id)
      this.$store.commit('setActive', 'overview')
      this.loading = false
    },
    setActive (index) {
      this.active = index
    }
  },
}
</script>
