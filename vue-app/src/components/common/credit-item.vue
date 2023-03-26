<template>
  <div :class="wrapperClasses"
       ref="creditWrapper"
       :style="bgImageCss"
       @click="setActive"
       @mouseover="setActive">
    <div class="img-container">
      <div v-if="isActive"
           class="description">
        <template v-if="credit.overview">
          {{ overviewExcerpt }}
        </template>
        <p v-else class="center-text">
          {{ store.state.__t.no_description }}
        </p>

      </div>
      <img v-else
           :class="imageSize === 'small' ? 'img-circle' : 'image'"
           :alt="credit.title || credit.name + ' image'"
           :src="imageSource"/>
    </div>
    <ul class="credits">
      <template v-if="showCreditDuringEvent || !showCreditDuringEvent && !isActive">
        <li>{{ title }}</li>
        <li v-if="credit.character">
          {{ store.state.__t.role }}: {{ credit.character }}
        </li>
        <li v-if="credit.job">{{ credit.job }}
        </li>
        <li v-if="credit.air_date">
          {{ store.state.__t.air_date }}: {{ store.getters.getFormattedDate(credit.air_date) }}
        </li>
        <li v-if="credit.episode_count">
          {{ store.state.__t.episode_count }}: {{ credit.episode_count }}
        </li>
      </template>
    </ul>
  </div>
</template>

<script setup lang="ts">
import { computed, ref } from 'vue'
import { useStore } from '@/store'
import { getExcerpt, getImageUrl } from '@/helpers/templating'

const props = defineProps({
  credit: {
    type: Object,
    required: true
  },
  index: {
    type: Number,
    required: true
  },
  isActive: {
    type: Boolean,
    default: false
  },
  columnClass: {
    type: String,
    default: 'multipleColumn'
  },
  i18TitleKey: {
    type: String,
    default: null
  },
  imageSize: {
    type: String,
    default: 'small'
  },
  hasSetActiveEvents: {
    type: Boolean,
    default: false
  },
  showCreditDuringEvent: {
    type: Boolean,
    default: false
  }
})

const emit = defineEmits(['setActive'])
const setActive = () => {
  if(props.hasSetActiveEvents) {
    emit('setActive', props.index)
  }
}
const store = useStore()
const creditWrapper = ref(null)
const excerptLength = 350
const overviewExcerpt = computed(() => getExcerpt(props.credit.overview, excerptLength))
const title = computed(() => {
  const credit = props.credit
  const title = credit.name ?? credit.title
  if(credit.release_date) {
    return `${title} (${new Date(credit.release_date).getFullYear()})`
  }
  return title
})
const imageSource = computed(() => {
  let size = props.imageSize
  let file =
      props.credit.poster_path || props.credit.profile_path

  if(file) {
    return getImageUrl(file, size)
  }

  return store.state.placeholder[size]
})
const wrapperClasses = computed(() => {
  const activeClass = props.isActive ? 'bg-image' : ''
  return `${store.state.cssClasses[props.columnClass]} credits ${activeClass}`
})
const bgImageCss = computed(() => {
  return props.isActive ? `background-image: url(${imageSource.value})` : `none`
})

</script>
