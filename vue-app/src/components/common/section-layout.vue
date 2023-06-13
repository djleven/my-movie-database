<template>
    <div class="mmdb-section" :style="bodyColors">
      <div class="mmdb-header-wrapper">
        <h3 class="mmdb-header"
            v-if="showHeader"
            :style="headerColors">
            <span class="mmdb-header-title" :style="`color:${stylingConfig.headerFontColor};`">
                {{ header }}
            </span>
          <span v-if="subHeader" class="mmdb-header-sub-title">{{ subHeader }}</span>
        </h3>
      </div>

        <div :class="`mmdb-body ${classList}`">
            <slot></slot>
        </div>
    </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import { useStore } from '@/store'
import { setStyleColors } from '@/helpers/templating'

defineProps({
  showHeader: {
    type: Boolean,
    default: true
  },
  header: {
    type: String,
    required: true
  },
  subHeader: {
    type: String,
    default: null
  },
  classList: {
    type: String,
    default: ''
  },
  showIf: {
    type: Boolean,
    default: true
  }
})

const store = useStore();
const stylingConfig = computed(() => store.state.styling);
const headerColors = computed(() => {
  const bg = stylingConfig.value.headerColor
  const font = stylingConfig.value.headerFontColor

  return setStyleColors(bg, font)
})

const bodyColors = computed(() => {
  const bg = stylingConfig.value.bodyColor
  const font = stylingConfig.value.bodyFontColor

  return setStyleColors(bg, font)
})

</script>