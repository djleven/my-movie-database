<template>
  <div>
     <span
         v-for="(credit, index) in credits"
         :key="index"
     >
    {{ creditText(credit, index) }}
  </span>
  </div>
</template>

<script setup lang="ts">
import { inject } from 'vue'

const $t = inject('$t')
const $tc = inject('$tc')
const props = defineProps({
  credits: {
    type: Array,
    required: true
  },
})

const creditText = (credit, index) => {
  let text = credit.job
  if(credit.episode_count) {
    text += ` (${$tc('episode_count', credit.episode_count)})`
  }
  if(props.credits.length - 1 !== index) {
    text += ', '
  }

  return text
}

</script>
