<template>
    <div :class="getWrapperClassList">
        <h4 v-if="i18TitleKey"
            :class="i18TitleKey"
            :style="`color: ${store.state.styling.bodyFontColor}`"
        >
          {{ $t(i18TitleKey) }}
        </h4>
        <div :class="`credits-wrapper ${columnClass} ${overviewOnHover ? 'overview-on-hover' : ''}`">
            <template v-for="(credit, index) in credits" :key="index">
               <credit-item
                   :credit="credit"
                   :column-class="columnClass"
                   :image-size="imageSize"
                   :has-set-active-events="overviewOnHover"
               />
            </template>
        </div>
    </div>
</template>

<script setup lang="ts">
import { inject, PropType, computed } from 'vue'
import { useStore } from '@/store'
import { Sizes } from "@/models/settings";
import { ImageType } from "@/helpers/images";

const $t = inject('$t')
const props = defineProps({
  credits: {
    type: Array,
    required: true
  },
  wrapperClassList: {
    type: String,
    default: 'credit-list-wrapper'
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
  overviewOnHover: {
    type: Boolean,
    default: false
  }
})

const store = useStore()

const getWrapperClassList = computed(() => `${props.wrapperClassList} ${props.imageSize}`)

</script>
