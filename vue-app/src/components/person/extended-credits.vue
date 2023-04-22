<template>
  <template v-for="(mediaType, index) in credits" :key="index">
    <credit-list
        v-if="mediaType.length"
        :i18-title-key="getI18TitleKey(index)"
        :column-class="ImageType.Rectangular"
        :image-size="imageSize"
        :overview-on-hover="overviewOnHover"
        :credits="mediaType"
    >
    </credit-list>
  </template>
</template>

<script setup lang="ts">
import { PropType } from 'vue'
import { Sizes } from '@/models/settings'
import { ImageType } from '@/helpers/images'

const props = defineProps({
  credits: {
    type: Array,
    default: () => [] // TODO: substitute with type or interface
  },
  imageSize: {
    type: String as PropType<Sizes>,
    default: Sizes.Medium
  },
  overviewOnHover: {
    type: Boolean,
    default: false
  },
  wrapperClassList: {
    type: String,
    default: 'person credit-list-wrapper'
  },
  i18TitleKey: {
    type: String,
    default: null
  },
  i18TitleKeySuffix: {
    type: String,
    default: null
  },
})
function getI18TitleKey(indexKey) {
  return props.i18TitleKey ??
      (props.i18TitleKeySuffix ? `${indexKey}_${props.i18TitleKeySuffix}` : null)
}
</script>
