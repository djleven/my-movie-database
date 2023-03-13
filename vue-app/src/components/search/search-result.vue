<template>
  <div :class="active ? 'info bg-image' : 'info'"
       :style="bgImage"
       @click="setActive()"
       @mouseover="setActive()">
    <div class="title-container">
      <h3>{{ getTitle }}</h3>
    </div>
    <div class="description">
      <template v-if="active">
        <p class="bold center-text">TMDb ID: {{ result.id }}</p>
        <div v-if="getTextExcerpt">{{ getTextExcerpt }}</div>
        <div v-else-if="knownFor || result.known_for_department">
          {{ $store.state.__t.known_for_department }}
          <span v-if="result.known_for_department">{{result.known_for_department}}</span>
          <div v-if="knownFor">{{ knownFor }}</div>
        </div>
        <p v-else class="center-text">{{ $store.state.__t.no_description }}</p>
      </template>
    </div>
    <div v-if="active"
         class="button-primary"
         @click="select()">
      Select
    </div>
    <img :src="getImage" v-else/>
  </div>
</template>
<script>
import helpers from '../../mixins/helpers.js';

export default {
  mixins: [helpers],
  emits: ['setActive', 'select'],
  props: {
    result: {
      type: Object,
      required: true
    },
    active: {
      type: Boolean,
      default: false
    },
    index: {
      type: Number,
      required: true
    }
  },
  computed: {
    getTitle () {
      const title = this.result.name || this.result.title

      return this.getTitleWithYear(title, this.releaseDate)
    },
    getImage () {
      const size = 'medium'
      let file =
          this.result.poster_path || this.result.profile_path
      if(file) {
        return this.getImageUrl(file, size)
      }

      return this.$store.state.placeholder[size]
    },
    getTextExcerpt () {

      if(typeof this.result.overview !== 'undefined') {

        return this.getExcerpt(this.result.overview, 350)
      }
      return null
    },
    knownFor () {
      let known_for = this.result.known_for
      if(known_for && known_for.length) {
        return known_for.map((elem) => {
          return elem.name || elem.title
        }).join(", ")
      }
      return null
    },
    releaseDate () {

      return this.result.release_date || this.result.first_air_date
    },
    bgImage () {
      if(this.active) {
        return 'background-image: url("' + this.getImage + '")'
      }
      return ''
    },
  },
  methods: {
    select () {
      this.$emit('select', this.index)
    },
    setActive () {
      this.$emit('setActive', this.index)
    }
  },
}
</script>
