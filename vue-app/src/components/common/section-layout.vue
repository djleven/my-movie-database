<template>
    <section class="mmdb-section">
        <div class="mmdb-header"
             v-if="showHeader"
             :style="headerColors">
            <h3 class="mmdb-header-title" :style="`color:${stylingConfig.headerFontColor};`">
                {{ header }}
                <span v-if="subHeader" class="pull-right">{{ subHeader }}</span>
            </h3>
        </div>
        <div :class="`col-md-12 mmdb-body ${classList}`"
             :style="bodyColors">
            <slot></slot>
        </div>
    </section>
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
const stylingConfig = computed(() => store.state.cssClasses);
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