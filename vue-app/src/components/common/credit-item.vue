<template>
  <div :class="wrapperClasses"
       @touchstart="setActive()"
       @touchend="setActive(false)"
       @mouseenter="setActive()"
       @mouseleave="setActive(false)"
  >
    <div :class="imgContainerClasses" :style="bgImageCss">
      <div v-if="isActive"
           class="credit-image description">
        <template v-if="credit.overview">
          {{ overviewExcerpt }}
        </template>
        <template v-else-if="!!$slots['active-slot-content']">
          <slot name="active-slot-content" />
        </template>

        <div v-else>
          {{ $t('no_description') }}
        </div>
        <slot name="active-slot-after" />
      </div>
      <img v-else
           :class="imageClass"
           :alt="credit.title || credit.name + ' image'"
           :height="imageSize.height"
           :width="imageSize.width"
           :src="imageSource"/>

    </div>
    <ul class="credit-text-items">
      <li>{{ title }}</li>
      <slot>
        <li v-if="credit.character">
          {{ $t('role') }}: {{ credit.character }}
        </li>
        <li v-if="credit.job">{{ credit.job }}
        </li>
        <li v-if="credit.air_date">
          {{ $t('first_air_date') }}: {{ store.getters.getFormattedDate(credit.air_date) }}
        </li>
        <li v-if="credit.episode_count">
          {{ $tc('episode_count', credit.episode_count ) }}
        </li>
      </slot>
    </ul>
  </div>
</template>

<script setup lang="ts">
import { computed, inject, PropType, ref } from 'vue'
import { useStore } from '@/store'
import { getExcerpt } from '@/helpers/templating'
import { getImageUrl, ImageType, rectangularImageSizes, squareImageSizes } from '@/helpers/images'
import { Sizes } from "@/models/settings";

const $t = inject('$t')
const $tc = inject('$tc')
const props = defineProps({
  credit: {
    type: Object,
    required: true
  },
  columnClass: {
    type: String as PropType<ImageType>,
    default: ImageType.Square
  },
  i18TitleKey: {
    type: String,
    default: null
  },
  imageSize: {
    type: String as PropType<Sizes>,
    default: Sizes.Medium
  },
  hasSetActiveEvents: {
    type: Boolean,
    default: false
  },
})
const isActive = ref(false)

const setActive = (state = true) => {
  if(props.hasSetActiveEvents) {
    isActive.value = state
  }
}

const store = useStore()

const excerptLength = {
  [Sizes.Small]: 225,
  [Sizes.Medium]: 300,
  [Sizes.Large]: 500,
}

const overviewExcerpt = computed(() => getExcerpt(props.credit.overview, excerptLength[props.imageSize]))
const title = computed(() => {
  const credit = props.credit
  const title = credit.name ?? credit.title
  if(credit.release_date) {
    return `${title} (${new Date(credit.release_date).getFullYear()})`
  }
  return title
})

const imageSource = computed(() => {
  const size = props.imageSize
  const imageType = props.columnClass
  const filePath = props.credit.profile_path ?? props.credit.poster_path

  return getImageUrl(filePath, size, imageType)
})

const wrapperClasses = computed(() => {
  const activeClass = isActive.value ? 'bg-image' : ''

  return `${props.imageSize}-${props.columnClass} credits ${activeClass}`
})

const bgImageCss = computed(() => {

  return isActive.value ? `background-image: url(${imageSource.value})` : `none`
})

const imageSize = computed(() => {
  const imageSizes = props.columnClass === ImageType.Square ? squareImageSizes : rectangularImageSizes

  return imageSizes[props.imageSize]
})

const imgContainerClasses = computed(() => {
  const baseClass = 'img-container'
  const placeholderClass = imageSource.value.includes('mmdb-placeholder-') ? 'no-image-available' : ''

  return `${baseClass} ${placeholderClass}`
})

const imageClass = computed(() => {

  return props.columnClass === ImageType.Square ? 'img-circle' : 'image credit-image'
})
</script>
