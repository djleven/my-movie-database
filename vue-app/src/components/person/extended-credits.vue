<template>
  <template v-for="(mediaType, index) in credits" :key="index">
    <credit-list
        v-if="mediaType.length"
        :i18-title-key="getI18TitleKey(index)"
        image-size="medium"
        :overview-on-hover="overviewOnHover"
        column-class="twoColumn"
        :credits="mediaType"
    >
    </credit-list>
  </template>
</template>

<script setup lang="ts">
import {defineProps} from "vue"

const props = defineProps({
  credits: {
    type: Array,
    default: () => [] // TODO: substitute with type or interface
  },
  overviewOnHover: {
    type: Boolean,
    default: false
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
