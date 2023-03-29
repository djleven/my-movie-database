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
          {{ $t('known_for_department') }}
          <span v-if="result.known_for_department">{{result.known_for_department}}</span>
          <div v-if="knownFor">{{ knownFor }}</div>
        </div>
        <p v-else class="center-text">{{ $t('no_description') }}</p>
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
<script setup lang="ts">
import { computed, inject, ref } from 'vue'
import { useStore } from '@/store'
import { getExcerpt, getImageUrl, getTitleWithYear, placeholderImages } from '@/helpers/templating'

const $t = inject('$t')
const props = defineProps({
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
})

const emit = defineEmits(['setActive', 'select'])

const select = () => {
  emit('select', props.index)
}
const setActive = () => {
  emit('setActive', props.index)
}

const store = useStore();
const releaseDate = computed(() => props.result.release_date || props.result.first_air_date)
const getTitle = computed(() => {
  const title = props.result.name || props.result.title

  return getTitleWithYear(title, releaseDate)
})

const getImage = computed(() => {
  const size = 'medium'
  let file =
      props.result.poster_path || props.result.profile_path
  if (file) {
    return getImageUrl(file, size)
  }

  return ref(require(`../../assets/img/${placeholderImages[size]}`)).value
})

const getTextExcerpt = computed(() =>
    props.result?.overview ? getExcerpt(props.result.overview, 350) : null
)

const knownFor = computed(() => {
  let known_for = props.result.known_for
  if(known_for && known_for.length) {
    return known_for.map((elem) => {
      return elem.name || elem.title
    }).join(", ")
  }
  return null
})

const bgImage = computed(() => props.active ? `background-image: url("${getImage.value}")` : '')
</script>
